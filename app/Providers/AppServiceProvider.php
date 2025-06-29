<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CartService;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Event;
use App\Models\MailLog;
use App\Models\Order;

App::singleton(CartService::class, function () {
    return new CartService();
});

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public function register()
{
    $this->app->singleton(CartService::class, function () {
        return new CartService();
    });
    $this->app->singleton('cart', function($app) {
    return new \App\Services\CartService();
});
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('access-admin', function (User $user) {
        return $user->hasRole('admin');
    });

    View::composer('*', function ($view) {
        $cartService = app(CartService::class);
        $view->with('cartCount', $cartService->getCartCount());

        });

        // Логирование успешной отправки
        Event::listen(MessageSent::class, function ($event) {
    MailLog::create([
        'to' => $event->message->getTo()[0]->getAddress(),
        'subject' => $event->message->getSubject(),
        'body' => strip_tags($event->message->getHtmlBody()), // Удаляем HTML-теги
        'status' => 'sent'
    ]);
});

        // Логирование ошибок (дополнительно)
        Event::listen(\Illuminate\Mail\Events\MessageSending::class, function ($event) {
            // Можно добавить предварительную обработку
        });

        Order::observe(\App\Observers\OrderObserver::class);

        Order::withoutEvents(function () {
        // Код без триггера событий
    });
    \Event::listen(\Illuminate\Notifications\Events\NotificationSending::class, function ($event) {
        \Log::info('Notification sending', [
            'notifiable' => get_class($event->notifiable),
            'notification' => get_class($event->notification),
            'channel' => $event->channel
        ]);
    });

    \Event::listen(\Illuminate\Notifications\Events\NotificationSent::class, function ($event) {
        \Log::info('Notification sent', [
            'notifiable' => get_class($event->notifiable),
            'notification' => get_class($event->notification),
            'channel' => $event->channel
        ]);
    });
    }

    }




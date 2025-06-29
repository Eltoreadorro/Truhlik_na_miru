<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class OrderReadyNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Order $order,
        public string $previousStatus
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        try {
            return (new MailMessage)
                ->subject('Objednávka #'.$this->order->id.' je připravena k odeslání')
                ->greeting('Vážený zákazníku,')
                ->line('Vaše objednávka č. '.$this->order->id.' je připravena k odeslání.')
                ->line('')
                ->line('**Detaily objednávky:**')
                ->line('- Číslo: #'.$this->order->id)
                ->line('- Odeslání: '.now()->addDays(1)->format('d.m.Y'))
                ->line('- Způsob dopravy: '.$this->getDeliveryMethod())
                ->line('')
                ->when($this->order->seller_comment, function ($mail) {
                    $mail->line('**Komentář prodejce:**')
                        ->line($this->order->seller_comment)
                        ->line('');
                })
                ->salutation('S pozdravem, '.config('app.name'));

        } catch (\Exception $e) {
            Log::error('OrderReadyNotification failed: '.$e->getMessage());

            return (new MailMessage)
                ->subject('Objednávka #'.$this->order->id.' je připravena k odeslání')
                ->line('Vaše objednávka je připravena k odeslání.')
                ->line('Omlouváme se, ale technické potíže nám zabránily zobrazit všechny detaily.');
        }
    }

    protected function getDeliveryMethod(): string
    {
        return $this->order->delivery_method === 'courier'
            ? 'Doručení poštou'
            : 'Osobní odběr';
    }
}

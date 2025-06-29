<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as PublicProductController;
use App\Http\Controllers\CheckoutController;
use App\Models\ProductVariant;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\ContactRequestController;
use App\Http\Controllers\Admin\MailLogController;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Models\Order;

// Основные маршруты
Route::get('/', [HomeController::class, 'index'])->name('home');

// Информационные страницы
Route::controller(PageController::class)->group(function () {
    Route::get('/delivery', 'delivery')->name('page.delivery');
    Route::get('/returns', 'returns')->name('page.returns');
    Route::get('/terms', 'terms')->name('page.terms');
    Route::get('/privacy', 'privacy')->name('page.privacy');
});

// Продукты
Route::controller(PublicProductController::class)->group(function () {
    Route::get('/products', 'index')->name('products.index');
    Route::get('/products/load', 'loadMore')->name('products.load');
    Route::get('/products/{product}', 'show')->name('products.show');
});

// Контакты
Route::controller(ContactController::class)->group(function () {
    Route::get('/kontakty', 'index')->name('contacts');
    Route::post('/kontakty/individually-objednavka', 'sendCustomOrder')->name('contacts.send.custom-order');
});

// Галерея
Route::get('/gallery/load-more', [GalleryController::class, 'loadMore'])->name('gallery.load-more');

// PDF маршруты
Route::get('/download-return-form', function() {
    $pdf = PDF::loadView('pdf.return-form');
    return $pdf->download('formular-vraceni-zbozi.pdf');
})->name('download.return.form');


// Варианты продуктов
Route::get('/variants/{variant}', function(ProductVariant $variant) {
    return response()->json([
        'id' => $variant->id,
        'price' => $variant->price,
        'volume' => $variant->volume,
        'color' => $variant->color,
        'image' => asset('storage/' . ($variant->image ?? $variant->product->image))
    ]);
});

// Корзина
Route::prefix('cart')->controller(CartController::class)->group(function () {
    Route::get('/', 'index')->name('cart.index');
    Route::post('/add/{variant}', 'add')->name('cart.add');
    Route::patch('/update/{variant}', 'update')->name('cart.update');
    Route::delete('/remove/{variant}', 'remove')->name('cart.remove');
});

// Оформление заказа
Route::prefix('checkout')->name('checkout.')->controller(CheckoutController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/step1', 'processStep1')->name('step1.process');
    Route::get('/step2', 'step2')->name('step2');
    Route::post('/step2', 'processStep2')->name('step2.process');
    Route::get('/step3', 'step3')->name('step3');
    Route::post('/complete', 'complete')->name('complete');
    Route::get('/success/{order}', 'success')->name('success');
    Route::post('/update-summary', 'updateSummary')->name('update-summary');
});

// Админка
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Ресурсные маршруты
    Route::resources([
        'products' => ProductController::class,
        'categories' => CategoryController::class,
        'colors' => ColorController::class,
        'orders' => OrderController::class,
        'users' => UserController::class,
    ]);

    // Настройки
    Route::controller(SettingController::class)->group(function () {
        Route::get('settings', 'index')->name('settings.index');
        Route::post('settings', 'update')->name('settings.update');
    });

    // Фактуры
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);

    Route::get('orders/{order}/invoice', [\App\Http\Controllers\Admin\OrderController::class, 'invoice'])
        ->name('orders.invoice');

    Route::patch('orders/{order}/payment-status', [\App\Http\Controllers\Admin\OrderController::class, 'updatePaymentStatus'])
        ->name('orders.update-payment-status');
    Route::get('orders/{order}/tracking', [OrderController::class, 'tracking'])
        ->name('orders.tracking');

    // Варианты продуктов
    Route::prefix('products/{product}/variants')->name('products.variants.')->controller(ProductVariantController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{variant}', 'show')->name('show');
        Route::get('/{variant}/edit', 'edit')->name('edit');
        Route::put('/{variant}', 'update')->name('update');
        Route::delete('/{variant}', 'destroy')->name('destroy');
    });

    // Подписчики
    Route::controller(SubscriberController::class)->group(function () {
        Route::get('subscribers', 'index')->name('subscribers.index');
        Route::delete('subscribers/{subscriber}', 'destroy')->name('subscribers.destroy');
    });

    // Контактные запросы
    Route::controller(ContactRequestController::class)->group(function () {
        Route::get('contact-requests', 'index')->name('contact-requests.index');
        Route::get('contact-requests/{contactRequest}', 'show')->name('contact-requests.show');
        Route::delete('contact-requests/{contactRequest}', 'destroy')->name('contact-requests.destroy');
    });

    // Логи писем
    Route::resource('mail-logs', MailLogController::class)->except(['create', 'edit', 'update', 'store'])->names('admin.mail-logs');
});

// Подписка
Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');

// Профиль пользователя
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/objednavky/{order}', [OrderController::class, 'tracking'])
    ->name('order.tracking');

    Route::get('/orders/{order}/review', function(Order $order) {
    return view('order.review', compact('order'));
})->name('order.review');


require __DIR__.'/auth.php';

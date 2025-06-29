<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nová objednávka #' . $this->order->id)
            ->line('Byla vytvořena nová objednávka!')
            ->line('Zákazník: ' . $this->order->customer_name)
            ->line('Částka: ' . number_format($this->order->total, 2) . ' Kč')
            ->line('Způsob dopravy: ' . $this->getDeliveryMethod())
            ->action('Zobrazit objednávku', route('admin.orders.show', $this->order))
            ->line('Prosím zpracujte objednávku co nejdříve.');
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'customer' => $this->order->customer_name,
            'amount' => $this->order->total,
            'status' => $this->order->status,
            'url' => route('admin.orders.show', $this->order)
        ];
    }

    protected function getDeliveryMethod(): string
    {
        return $this->order->delivery_method === 'courier'
            ? 'Doručení poštou'
            : 'Osobní odběr';
    }
}

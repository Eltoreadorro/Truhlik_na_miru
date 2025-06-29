<?php

namespace App\Observers;

use App\Models\Order;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderConfirmationNotification;

class OrderObserver
{
    public function created(Order $order)
    {
        if (!app()->runningInConsole()) {
            $this->notifyAdmin($order);

            // Отправка подтверждения клиенту
            if ($order->email) {
                try {
                    $order->notifyNow(new OrderConfirmationNotification($order));
                } catch (\Exception $e) {
                    \Log::error('Failed to send order confirmation: '.$e->getMessage());
                }
            }
        }
    }

    protected function notifyAdmin(Order $order)
    {
        try {
            \App\Models\User::where('is_admin', true)->each(function($admin) use ($order) {
                $admin->notifyNow(new NewOrderNotification($order));
            });
        } catch (\Exception $e) {
            \Log::error('Admin notification failed: '.$e->getMessage());
        }
    }
}

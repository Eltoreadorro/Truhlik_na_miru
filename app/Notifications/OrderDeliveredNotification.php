<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OrderDeliveredNotification extends Notification
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
            // Генерация PDF
            $pdf = Pdf::loadView('pdf.order_delivered', [
                'order' => $this->order,
                'date' => now()->format('d.m.Y'),
                'company' => [
                    'name' => config('app.name'),
                    'address' => config('app.company_address', 'Sulicka 42, Sulice, 25168 Praha-vychod'),
                    'ico' => config('app.company_ico', '17578981'),
                    'account' => config('app.company_account', '4753073093/0800')
                ]
            ])->setPaper('a4');

            // Генерация уникального имени файла
            $fileName = 'delivery_confirmation_'.$this->order->id.'_'.time().'.pdf';
            $filePath = storage_path('app/public/temp/'.$fileName);

            // Сохранение PDF
            Storage::disk('public')->makeDirectory('temp');
            $pdf->save($filePath);

            // Отправка письма
            $mail = (new MailMessage)
                ->subject('Objednávka #'.$this->order->id.' byla doručena')
                ->greeting('Vážený zákazníku,')
                ->line('Vaše objednávka č. '.$this->order->id.' byla úspěšně doručena.')
                ->line('')
                ->line('**Detaily doručení:**')
                ->line('- Datum: '.now()->format('d.m.Y'))
                ->line('- Místo: '.$this->getDeliveryLocation())
                ->line('- Podpis: '.$this->order->customer_name)
                ->line('')
                ->when($this->order->seller_comment, function ($mail) {
                    $mail->line('**Komentář prodejce:**')
                        ->line($this->order->seller_comment)
                        ->line('');
                })
                ->attach($filePath, [
                    'as' => 'potvrzeni-o-doruceni-'.$this->order->id.'.pdf',
                    'mime' => 'application/pdf',
                ])
                ->line('')
                ->line('Děkujeme za váš nákup!')
                ->salutation('S pozdravem, '.config('app.name'));

            // Удаление файла после отправки
            register_shutdown_function(function() use ($filePath) {
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            });

            return $mail;

        } catch (\Exception $e) {
            Log::error('PDF generation error in OrderDeliveredNotification: '.$e->getMessage());
            Log::error($e->getTraceAsString());

            // Отправка письма без вложения в случае ошибки
            return (new MailMessage)
                ->subject('Objednávka #'.$this->order->id.' byla doručena')
                ->greeting('Vážený zákazníku,')
                ->line('Vaše objednávka č. '.$this->order->id.' byla úspěšně doručena.')
                ->line('')
                ->line('**Detaily doručení:**')
                ->line('- Datum: '.now()->format('d.m.Y'))
                ->line('- Místo: '.$this->getDeliveryLocation())
                ->line('- Podpis: '.$this->order->customer_name)
                ->line('')
                ->when($this->order->seller_comment, function ($mail) {
                    $mail->line('**Komentář prodejce:**')
                        ->line($this->order->seller_comment)
                        ->line('');
                })
                ->line('Omlouváme se, ale technické potíže nám zabránily připojit potvrzení o doručení.')
                ->line('')
                ->line('Děkujeme za váš nákup!')
                ->salutation('S pozdravem, '.config('app.name'));
        }
    }

    protected function getDeliveryLocation(): string
    {
        return $this->order->delivery_method === 'pickup'
            ? 'Osobní odběr '.config('app.pickup_address')
            : 'Doručovací adresa: '.$this->order->address;
    }
}

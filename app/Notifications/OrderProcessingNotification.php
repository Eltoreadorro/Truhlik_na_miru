<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OrderProcessingNotification extends Notification
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
            $pdf = Pdf::loadView('pdf.order_processing', [
                'order' => $this->order,
                'production_days' => 3,
                'company' => [
                    'name' => config('app.name'),
                    'address' => config('app.company_address', 'Sulicka 42, Sulice, 25168 Praha-vychod'),
                    'ico' => config('app.company_ico', '17578981'),
                    'phone' => config('app.company_phone', '+420 606 912 403')
                ]
            ])->setPaper('a4');

            // Генерация уникального имени файла
            $fileName = 'processing_'.$this->order->id.'_'.time().'.pdf';
            $filePath = storage_path('app/public/temp/'.$fileName);

            // Сохранение PDF
            Storage::disk('public')->makeDirectory('temp');
            $pdf->save($filePath);

            // Создание письма
            $mail = (new MailMessage)
                ->subject('Objednávka #'.$this->order->id.' se připravuje')
                ->greeting('Vážený zákazníku,')
                ->line('Vaše objednávka č. '.$this->order->id.' byla přijata a připravuje se.')
                ->line('')
                ->line('**Detaily objednávky:**')
                ->line('- Číslo: #'.$this->order->id)
                ->line('- Předpokládané dokončení: '.now()->addDays(3)->format('d.m.Y'))
                ->line('- Odeslání: do '.now()->addDays(5)->format('d.m.Y'))
                ->line('')
                ->when($this->order->seller_comment, function ($mail) {
                    $mail->line('**Komentář prodejce:**')
                        ->line($this->order->seller_comment)
                        ->line('');
                })
                ->attach($filePath, [
                    'as' => 'informace-o-vyrobe-'.$this->order->id.'.pdf',
                    'mime' => 'application/pdf',
                ])
                ->salutation('S pozdravem, '.config('app.name'));

            // Удаление файла после отправки
            register_shutdown_function(function() use ($filePath) {
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            });

            return $mail;

        } catch (\Exception $e) {
            Log::error('PDF generation error in OrderProcessingNotification: '.$e->getMessage());
            Log::error($e->getTraceAsString());

            // Отправка письма без вложения в случае ошибки
            return (new MailMessage)
                ->subject('Objednávka #'.$this->order->id.' se připravuje')
                ->greeting('Vážený zákazníku,')
                ->line('Vaše objednávka č. '.$this->order->id.' byla přijata a připravuje se.')
                ->line('')
                ->line('Omlouváme se, ale technické potíže nám zabránily připojit informační PDF.')
                ->line('')
                ->when($this->order->seller_comment, function ($mail) {
                    $mail->line('**Komentář prodejce:**')
                        ->line($this->order->seller_comment)
                        ->line('');
                })
                ->salutation('S pozdravem, '.config('app.name'));
        }
    }
}

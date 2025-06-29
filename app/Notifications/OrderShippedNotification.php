<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OrderShippedNotification extends Notification
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
            $pdf = $this->generatePdf();

            // Сохранение временного файла
            $fileName = 'shipping_info_'.$this->order->id.'_'.time().'.pdf';
            $filePath = storage_path('app/public/temp/'.$fileName);

            Storage::disk('public')->makeDirectory('temp');
            $pdf->save($filePath);

            // Создание письма
            $mail = (new MailMessage)
                ->subject('Objednávka #'.$this->order->id.' byla odeslána')
                ->greeting('Vážený zákazníku,')
                ->line('Vaše objednávka č. '.$this->order->id.' byla odeslána.')
                ->line('')
                ->line('**Detaily odeslání:**')
                ->line('- Dopravce: '.$this->order->delivery_service)
                ->line('- Sledovací číslo: '.$this->order->tracking_number)
                ->line('- Předpokládané doručení: '.$this->order->estimated_delivery_date?->format('d.m.Y'))
                ->line('')
                ->when($this->order->seller_comment, function ($mail) {
                    $mail->line('**Komentář prodejce:**')
                        ->line($this->order->seller_comment)
                        ->line('');
                })
                ->attach($filePath, [
                    'as' => 'informace-o-odeslani-'.$this->order->id.'.pdf',
                    'mime' => 'application/pdf',
                ])
                ->salutation('S pozdravem, '.config('app.name'));

            // Удаление временного файла после отправки
            register_shutdown_function(function() use ($filePath) {
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            });

            return $mail;

        } catch (\Exception $e) {
            Log::error('Failed to generate shipping PDF: '.$e->getMessage());
            Log::error($e->getTraceAsString());

            // Отправка письма без вложения в случае ошибки
            return (new MailMessage)
                ->subject('Objednávka #'.$this->order->id.' byla odeslána')
                ->greeting('Vážený zákazníku,')
                ->line('Vaše objednávka č. '.$this->order->id.' byla odeslána.')
                ->line('')
                ->line('**Detaily odeslání:**')
                ->line('- Dopravce: '.$this->order->delivery_service)
                ->line('- Sledovací číslo: '.$this->order->tracking_number)
                ->line('- Předpokládané doručení: '.$this->order->estimated_delivery_date?->format('d.m.Y'))
                ->line('')
                ->when($this->order->seller_comment, function ($mail) {
                    $mail->line('**Komentář prodejce:**')
                        ->line($this->order->seller_comment)
                        ->line('');
                })
                ->line('')
                ->line('Omlouváme se, ale technické potíže nám zabránily připojit informační PDF.')
                ->salutation('S pozdravem, '.config('app.name'));
        }
    }

    protected function generatePdf()
    {
        return Pdf::loadView('pdf.order_shipped', [
            'order' => $this->order,
            'date' => now()->format('d.m.Y'),
            'company' => [
                'name' => config('app.name'),
                'address' => config('app.company_address', 'Sulicka 42, Sulice, 25168 Praha-vychod'),
                'ico' => config('app.company_ico', '17578981'),
                'phone' => config('app.company_phone', '+420 606 912 403')
            ]
        ])->setPaper('a4');
    }

    protected function getTrackingUrl(): string
    {
        return match($this->order->delivery_service) {
            'Česká pošta' => 'https://www.postaonline.cz/trackandtrace/-/zasilka/cislo?parcelNumbers='.$this->order->tracking_number,
            'PPL' => 'https://www.ppl.cz/main2.aspx?cls=Package&idSearch='.$this->order->tracking_number,
            default => route('order.tracking', $this->order)
        };
    }
}

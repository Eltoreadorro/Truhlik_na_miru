<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OrderCancelledNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Order $order,
        public string $reason
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Гарантируем наличие причины отмены
        $cancellationReason = $this->reason ?: 'Zrušeno administrátorem';

        try {
            // Генерация PDF
            $pdf = $this->generateCancellationPdf($cancellationReason);

            // Сохранение временного файла
            $fileName = 'cancellation_'.$this->order->id.'_'.time().'.pdf';
            $filePath = storage_path('app/public/temp/'.$fileName);
            Storage::disk('public')->makeDirectory('temp');
            $pdf->save($filePath);

            // Формирование письма
            $mail = (new MailMessage)
                ->subject('Objednávka #'.$this->order->id.' byla zrušena')
                ->greeting('Vážený zákazníku,')
                ->line('Bohužel jsme museli zrušit vaši objednávku č. '.$this->order->id.'.')
                ->line('')
                ->line('**Důvod zrušení:**')
                ->line($cancellationReason)
                ->line('')
                ->line('**Detaily objednávky:**')
                ->line('- Číslo: #'.$this->order->id)
                ->line('- Celková částka: '.number_format($this->order->total, 2).' Kč')
                ->line('- Datum vytvoření: '.$this->order->created_at->format('d.m.Y H:i'))
                ->attach($filePath, [
                    'as' => 'potvrzeni-zruseni-'.$this->order->id.'.pdf',
                    'mime' => 'application/pdf',
                ]);

            // Добавляем информацию о возврате средств, если нужно
            if ($this->order->payment_status === 'paid') {
                $mail->line('')
                    ->line('**Vrácení platby:**')
                    ->line('Vaše platba bude vrácena na váš účet do 7 pracovních dnů.');
            }

            $mail->action('Kontaktovat podporu', route('contacts'))
                ->salutation('S pozdravem, '.config('app.name'));

            // Удаление временного файла после отправки
            register_shutdown_function(function() use ($filePath) {
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            });

            return $mail;

        } catch (\Exception $e) {
            Log::error('Chyba při generování PDF pro zrušenou objednávku: '.$e->getMessage());
            Log::error($e->getTraceAsString());

            // Fallback без PDF, но с обязательным отображением причины
            return (new MailMessage)
                ->subject('Objednávka #'.$this->order->id.' byla zrušena')
                ->greeting('Vážený zákazníku,')
                ->line('Bohužel jsme museli zrušit vaši objednávku č. '.$this->order->id.'.')
                ->line('')
                ->line('**Důvod zrušení:**')
                ->line($cancellationReason)
                ->line('')
                ->line('**Detaily objednávky:**')
                ->line('- Číslo: #'.$this->order->id)
                ->line('- Celková částka: '.number_format($this->order->total, 2).' Kč')
                ->line('')
                ->when($this->order->payment_status === 'paid', function($mail) {
                    $mail->line('**Vrácení platby:**')
                        ->line('Vaše platba bude vrácena na váš účet do 7 pracovních dnů.')
                        ->line('');
                })
                ->action('Kontaktovat podporu', route('contacts'))
                ->line('')
                ->salutation('S pozdravem, '.config('app.name'));
        }
    }

    protected function generateCancellationPdf(string $reason)
    {
        return Pdf::loadView('pdf.order_cancelled', [
            'order' => $this->order,
            'reason' => $reason,
            'date' => now()->format('d.m.Y'),
            'company' => [
                'name' => config('app.name'),
                'address' => config('app.company_address', 'Sulicka 42, Sulice, 25168 Praha-vychod'),
                'ico' => config('app.company_ico', '17578981'),
                'account' => config('app.company_account', '4753073093/0800')
            ]
        ])->setPaper('a4', 'portrait');
    }
}

<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OrderConfirmationNotification extends Notification
{
    use Queueable;

    public function __construct(public Order $order) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        try {
            // Генерация PDF с учетом комментария продавца
            $pdf = $this->generatePdf();

            // Создаем временную папку, если не существует
            $tempPath = storage_path('app/public/temp');
            if (!file_exists($tempPath)) {
                mkdir($tempPath, 0755, true);
            }

            // Генерация уникального имени файла
            $fileName = 'invoice_'.$this->order->id.'_'.time().'.pdf';
            $filePath = $tempPath.'/'.$fileName;

            // Сохранение PDF
            $pdf->save($filePath);

            // Создаем письмо
            $mail = (new MailMessage)
                ->subject('Potvrzení objednávky #'.$this->order->id)
                ->greeting('Vážený zákazníku,')
                ->line('Děkujeme za vaši objednávku v našem obchodě!')
                ->line('')
                ->line('**Detaily objednávky:**')
                ->line('- Číslo: #'.$this->order->id)
                ->line('- Celková částka: '.number_format($this->order->total, 2).' Kč')
                ->line('- Variabilní symbol: '.$this->order->variable_symbol)
                ->line('- Způsob platby: '.$this->getPaymentMethod());

            // Добавляем комментарий продавца, если он есть
            if (!empty($this->order->seller_comment)) {
                $mail->line('')
                    ->line('**Poznámka prodejce:**')
                    ->line($this->order->seller_comment);
            }

            $mail->line('')
                ->line('**Platební instrukce:**')
                ->line($this->getPaymentInstructions())
                ->attach($filePath, [
                    'as' => 'faktura-'.$this->order->id.'.pdf',
                    'mime' => 'application/pdf',
                ]);

            // Удаление файла после отправки
            register_shutdown_function(function() use ($filePath) {
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            });

            return $mail;

        } catch (\Exception $e) {
            Log::error('PDF generation error: '.$e->getMessage());
            Log::error($e->getTraceAsString());

            // Альтернативное письмо без PDF
            $mail = (new MailMessage)
                ->subject('Potvrzení objednávky #'.$this->order->id)
                ->greeting('Vážený zákazníku,')
                ->line('Děkujeme za vaši objednávku!')
                ->line('')
                ->line('**Detaily objednávky:**')
                ->line('- Číslo: #'.$this->order->id)
                ->line('- Celková částka: '.number_format($this->order->total, 2).' Kč')
                ->line('- Variabilní symbol: '.$this->order->variable_symbol)
                ->line('- Způsob platby: '.$this->getPaymentMethod());

            if (!empty($this->order->seller_comment)) {
                $mail->line('')
                    ->line('**Poznámka prodejce:**')
                    ->line($this->order->seller_comment);
            }

            $mail->line('')
                ->line('Omlouváme se, ale technické potíže nám zabránily připojit fakturu k tomuto e-mailu.')
                ->line('Fakturu vám zašleme v následujícím e-mailu.');

            return $mail;
        }
    }

    protected function generatePdf()
    {
        return Pdf::loadView('pdf.order_confirmation', [
            'order' => $this->order,
            'date' => now()->format('d.m.Y'),
            'due_date' => now()->addDays(14)->format('d.m.Y'),
            'company' => [
                'name' => config('app.name'),
                'address' => config('app.company_address', 'Sulicka 42, Sulice, 25168 Praha-vychod'),
                'ico' => config('app.company_ico', '17578981'),
                'account' => config('app.company_account', '4753073093/0800')
            ],
            'seller_comment' => $this->order->seller_comment // Передаем комментарий в шаблон
        ])->setPaper('a4', 'portrait');
    }

    protected function getPaymentMethod(): string
    {
        return match($this->order->payment_method) {
            'full_prepayment' => 'Plná předplatba (bankovní převod)',
            'partial_prepayment' => 'Částečná předplatba (bankovní převod)',
            default => 'Nespecifikováno'
        };
    }

    protected function getPaymentInstructions(): string
{
    // Определяем сумму платежа в зависимости от типа оплаты
    $paymentAmount = ($this->order->payment_method === 'partial_prepayment')
        ? $this->order->total / 2
        : $this->order->total;

    // Формируем текст инструкций
    $instructions = "Prosím proveďte platbu:\n"
        . "- Částka: ".number_format($paymentAmount, 2)." Kč\n"
        . "- Číslo účtu: ".config('app.company_account', '4753073093/0800')."\n"
        . "- Variabilní symbol: ".$this->order->variable_symbol."\n"
        . "- Do poznámky: Objednávka ".$this->order->id;

    // Добавляем информацию о частичной оплате, если нужно
    if ($this->order->payment_method === 'partial_prepayment') {
        $instructions .= "\n\nPoznámka: Toto je první část platby (50%). Druhá částka ve výši "
            . number_format($paymentAmount, 2) . " Kč bude splatná po dokončení výroby.";
    }

    return $instructions;
}
}

<?php

namespace App\Services;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceService
{
    public function generate(Order $order)
    {
        $order->load(['items.variant.product', 'payments']);

        $pdf = Pdf::loadView('admin.invoices.template', [
            'order' => $order,
            'date' => now()->format('d.m.Y'),
            'due_date' => now()->addDays(14)->format('d.m.Y')
        ]);

        return $pdf->stream("invoice-{$order->id}.pdf");
    }
}

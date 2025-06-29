<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Order::with(['items'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'klient',
            'Telefon',
            'Částka',
            'Status',
            'Datum',
            'Zboží'
        ];
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->customer_name,
            $order->phone,
            $order->total,
            $order->status,
            $order->created_at->format('d.m.Y H:i'),
            $order->items->map(function($item) {
                return $item->variant->product->name . ' (' . $item->variant->volume . 'L) x' . $item->quantity;
            })->implode(', ')
        ];
    }
}

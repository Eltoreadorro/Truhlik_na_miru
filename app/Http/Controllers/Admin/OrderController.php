<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Notifications\{
    OrderProcessingNotification,
    OrderReadyNotification,
    OrderShippedNotification,
    OrderDeliveredNotification,
    OrderCancelledNotification,
    OrderConfirmationNotification
};
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
   public function index()
    {
        return view('admin.orders.index', [
            'orders' => Order::with(['items'])
                ->latest()
                ->paginate(10),
            'statuses' => Order::statuses()
        ]);
    }

    public function show(Order $order)
    {
        $order->load(['items.variant.product', 'payments', 'statusHistory']);
        return view('admin.orders.show', [
            'order' => $order,
            'history' => $order->statusHistory
        ]);
    }


    public function create()
    {
        return view('admin.orders.create');
    }

    public function store(Request $request)
    {
        // Implement if needed
    }

    public function edit(Order $order)
    {
        $order->load(['items.variant.product', 'payments']);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
{
    $validated = $request->validate([
        'status' => 'required|in:'.implode(',', array_keys(Order::statuses())),
        'payment_status' => 'required|in:pending,partially_paid,paid,refunded',
        'tracking_number' => 'nullable|string|max:100',
        'estimated_delivery_date' => 'nullable|date',
        'delivery_service' => 'nullable|string|max:100',
        'notes' => 'nullable|string',
        'seller_comment' => [
            Rule::requiredIf($request->status === Order::STATUS_CANCELLED),
            'nullable', 'string', 'max:500'
        ],
    ]);

    \DB::transaction(function () use ($order, $validated) {
        $previousStatus = $order->status;
        $order->update($validated);

        if ($order->wasChanged('status')) {
            \App\Models\OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => $order->status,
                'notes' => $order->status === Order::STATUS_CANCELLED
                    ? ($validated['seller_comment'] ?? 'Zrušeno bez uvedení důvodu')
                    : 'Status changed from '.$previousStatus.' to '.$order->status
            ]);

            $this->sendStatusNotification($order, $previousStatus);
        }
    });

    // Возвращаем редирект вместо JSON
    return redirect()->route('admin.orders.show', $order)
        ->with('success', 'Stav objednávky byl aktualizován');
}

protected function handleStatusNotifications(Order $order, string $previousStatus)
{
    try {
        switch ($order->status) {
            case Order::STATUS_PROCESSING:
                $order->notify(new OrderProcessingNotification($order, $previousStatus));
                break;
            case Order::STATUS_READY:
                $order->notify(new OrderReadyNotification($order, $previousStatus));
                break;
            case Order::STATUS_SHIPPED:
                $order->notify(new OrderShippedNotification($order, $previousStatus));
                break;
            case Order::STATUS_DELIVERED:
                $order->notify(new OrderDeliveredNotification($order, $previousStatus));
                break;
            case Order::STATUS_CANCELLED:
                $order->notify(new OrderCancelledNotification(
                    $order,
                    $order->seller_comment ?? 'Zrušeno administrátorem'
                ));
                break;
        }
    } catch (\Exception $e) {
        \Log::error('Notification failed: '.$e->getMessage());
    }
}
   protected function sendStatusNotification(Order $order, string $previousStatus)
{
    try {
        switch ($order->status) {
            case Order::STATUS_PROCESSING:
                $order->notify(new OrderProcessingNotification($order, $previousStatus));
                break;
            case Order::STATUS_READY:
                $order->notify(new OrderReadyNotification($order, $previousStatus));
                break;
            case Order::STATUS_SHIPPED:
                $order->notify(new OrderShippedNotification($order, $previousStatus));
                break;
            case Order::STATUS_DELIVERED:
                $order->notify(new OrderDeliveredNotification($order, $previousStatus));
                break;
            case Order::STATUS_CANCELLED:
                $reason = $order->seller_comment ?? 'Zrušeno administrátorem';
                $order->notify(new OrderCancelledNotification($order, $reason));
                break;
        }
    } catch (\Exception $e) {
        \Log::error('Failed to send status notification: '.$e->getMessage());
    }
}


    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')
                    ->with('success', 'Objednávka byla smazána!');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,partially_paid,paid,refunded'
        ]);

        $order->update(['payment_status' => $request->status]);
        $order->payments()->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'updated_at' => $order->updated_at->format('d.m.Y H:i')
        ]);
    }

    public function invoice(Order $order)
    {
        $order->load(['items.variant.product', 'payments']);

        $pdf = Pdf::loadView('admin.invoices.template', [
            'order' => $order,
            'date' => now()->format('d.m.Y'),
            'due_date' => now()->addDays(14)->format('d.m.Y'),
            'company' => [
                'name' => config('app.name'),
                'address' => 'Sulicka 42, Sulice, 25168 Praha-vychod',
                'ico' => '17578981',
                'account' => '4753073093/0800'
            ]
        ]);

        return $pdf->stream("faktura-{$order->id}.pdf");
    }

    public function tracking(Order $order)
    {
        return view('order.tracking', compact('order'));
    }
}

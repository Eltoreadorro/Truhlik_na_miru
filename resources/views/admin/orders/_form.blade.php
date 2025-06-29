{{-- resources/views/admin/orders/_form.blade.php --}}
<div class="card-body">
    <form action="{{ isset($order) ? route('admin.orders.update', $order) : route('admin.orders.store') }}" method="POST">
        @csrf
        @if(isset($order))
            @method('PUT')
        @endif

        <div class="form-group">
            <label>Stav objednávky</label>
            <select name="status" class="form-control">
                @foreach(\App\Models\Order::statuses() as $key => $status)
                    <option value="{{ $key }}" {{ isset($order) && $order->status == $key ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Stav platby</label>
            <select name="payment_status" class="form-control">
                <option value="pending" {{ isset($order) && $order->payment_status == 'pending' ? 'selected' : '' }}>Čeká na platbu</option>
                <option value="partially_paid" {{ isset($order) && $order->payment_status == 'partially_paid' ? 'selected' : '' }}>Částečně zaplaceno</option>
                <option value="paid" {{ isset($order) && $order->payment_status == 'paid' ? 'selected' : '' }}>Zaplaceno</option>
                <option value="refunded" {{ isset($order) && $order->payment_status == 'refunded' ? 'selected' : '' }}>Vráceno</option>
            </select>
        </div>

        <div class="form-group">
            <label>Sledovací číslo</label>
            <input type="text" name="tracking_number" class="form-control"
                   value="{{ $order->tracking_number ?? '' }}">
        </div>

        <div class="form-group">
            <label>Předpokládané doručení</label>
            <input type="date" name="estimated_delivery_date" class="form-control"
                   value="{{ isset($order) && $order->estimated_delivery_date ? $order->estimated_delivery_date->format('Y-m-d') : '' }}">
        </div>

        <div class="form-group">
            <label>Poznámka</label>
            <textarea name="notes" class="form-control" rows="3">{{ $order->notes ?? '' }}</textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Uložit</button>
        </div>
    </form>
</div>

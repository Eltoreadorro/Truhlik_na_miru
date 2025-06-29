    @extends('admin.layout')

    @section('title', 'Objednávky')

    @section('content_header')
        @section('header_title', 'Seznam objednávek')
    @stop

    @section('admin_content')
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Číslo</th>
                            <th>Zákazník</th>
                            <th>Celkem</th>
                            <th>Stav</th>
                            <th>Datum</th>
                            <th>Akce</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ number_format($order->total, 2) }} Kč</td>
                           <td>
    <td>
    <span class="badge bg-{{
        [
            'new' => 'info',
            'processing' => 'warning',
            'shipped' => 'primary',
            'delivered' => 'success',
            'completed' => 'success',
            'cancelled' => 'danger'
        ][$order->status] ?? 'secondary'
    }}">
        @switch($order->status)
            @case('new') Nová @break
            @case('processing') Zpracovává se @break
            @case('shipped') Odesláno @break
            @case('delivered') Doručeno @break
            @case('completed') Dokončeno @break
            @case('cancelled') Zrušeno @break
            @default Neznámý stav
        @endswitch
    </span>
</td>
                            </td>
                            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                            <td>
    <div class="btn-group">
        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-edit"></i>
        </a>
        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Opravdu smazat?')">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </div>
</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $orders->links() }}
            </div>
        </div>
    @stop

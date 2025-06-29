<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Faktura č. {{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; }
        .header { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .logo { max-width: 150px; }
        .info { margin-bottom: 30px; }
        table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        table td, table th { padding: 8px; vertical-align: top; }
        table th { background: #eee; font-weight: bold; }
        .total { margin-top: 20px; font-size: 1.2em; font-weight: bold; }
        .footer { margin-top: 50px; font-size: 0.8em; text-align: center; color: #777; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <div>
                <h1>Faktura č. {{ $order->id }}</h1>
                <p>Datum vystavení: {{ $date }}</p>
                <p>Datum splatnosti: {{ $due_date }}</p>
            </div>
            <div>
                @if(file_exists(public_path('logo.png')))
    <img src="{{ storage_path('public\logo.png') }}" class="logo">
@endif
            </div>
        </div>

        <div class="info">
            <div>
                <strong>Dodavatel:</strong><br>
                {{ config('app.name') }}<br>
                Sulicka 42, Sulice, 25168 Praha-vychod<br>
                IČO: 17578981<br>
            </div>
            <div style="margin-top: 20px;">
                <strong>Odběratel:</strong><br>
                {{ $order->customer_name }}<br>
                {{ $order->address }}<br>
                Tel: {{ $order->phone }}<br>
                Email: {{ $order->email }}
            </div>
        </div>

        <div style="margin-top: 20px;">
        <strong>Způsob dopravy:</strong> {{ $order->delivery_method === 'courier' ? 'Pošta' : 'Osobní odběr' }}<br>
        @if($order->delivery_service)
            <strong>Služba:</strong> {{ $order->delivery_service }}<br>
        @endif
        @if($order->tracking_number)
            <strong>Sledovací číslo:</strong> {{ $order->tracking_number }}
        @endif
        </div>

        <table>
            <thead>
                <tr>
                    <th>Produkt</th>
                    <th>Varianta</th>
                    <th>Množství</th>
                    <th>Cena/ks</th>
                    <th>Celkem</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->variant->product->name }}</td>
                    <td>
                        @if($item->variant->volume) {{ $item->variant->volume }}L @endif
                        @if($item->variant->color) {{ $item->variant->color }} @endif
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }} Kč</td>
                    <td>{{ number_format($item->price * $item->quantity, 2) }} Kč</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            Celkem: {{ number_format($order->total, 2) }} Kč<br>
            @if($order->deposit_amount > 0)
                Záloha: {{ number_format($order->deposit_amount, 2) }} Kč<br>
                Zbývá doplatit: {{ number_format($order->total - $order->deposit_amount, 2) }} Kč
            @endif
        </div>

        <div class="footer">
            Děkujeme za vaši objednávku!<br>
            Platbu proveďte na účet: 753073093/0800<br>
            Variabilní symbol: {{ $order->variable_symbol }}
        </div>
    </div>
</body>
</html>

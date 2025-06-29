<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <title>Faktura #{{ $order->id }}</title>
    <style>
        @page { margin: 1.5cm; }
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 11px;
            line-height: 1.4;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .logo-container {
            width: 30%;
            text-align: right;
        }
        .logo {
            max-height: 50px;
            max-width: 150px;
        }
        .invoice-info {
            width: 65%;
        }
        .info-box {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .info-column {
            width: 48%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        th, td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-size: 9px;
            color: #777;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="invoice-info">
            <h2 style="margin: 0 0 5px 0;">Faktura #{{ $order->id }}</h2>
            <p style="margin: 2px 0;">Datum vystavení: {{ $date }}</p>
            <p style="margin: 2px 0;">Splatnost: {{ $due_date }}</p>
            <p style="margin: 2px 0;">Variabilní symbol: {{ $order->variable_symbol }}</p>
        </div>
        <div class="logo-container">
            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ public_path('images/logo.png') }}" class="logo">
            @endif
        </div>
    </div>

    <div class="info-box">
        <div class="info-column">
            <h3 style="margin: 0 0 5px 0;">Dodavatel</h3>
            <p style="margin: 2px 0;"><strong>{{ $company['name'] }}</strong></p>
            <p style="margin: 2px 0;">{{ $company['address'] }}</p>
            <p style="margin: 2px 0;">IČO: {{ $company['ico'] }}</p>
            <p style="margin: 2px 0;">Účet: {{ $company['account'] }}</p>
        </div>
        <div class="info-column">
            <h3 style="margin: 0 0 5px 0;">Odběratel</h3>
            <p style="margin: 2px 0;"><strong>{{ $order->customer_name }}</strong></p>
            <p style="margin: 2px 0;">{{ $order->address }}</p>
            <p style="margin: 2px 0;">Tel: {{ $order->phone }}</p>
            <p style="margin: 2px 0;">Email: {{ $order->email }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 40%;">Produkt</th>
                <th style="width: 20%;">Varianta</th>
                <th style="width: 10%;" class="text-center">Množství</th>
                <th style="width: 15%;" class="text-right">Cena/ks</th>
                <th style="width: 15%;" class="text-right">Celkem</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->variant->product->name }}</td>
                <td>
                    @if($item->variant->volume)
                        {{ $item->variant->volume }}L
                    @endif
                    @if($item->variant->color)
                        /{{ $item->variant->color }}
                    @endif
                </td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">{{ number_format($item->price, 2) }} Kč</td>
                <td class="text-right">{{ number_format($item->price * $item->quantity, 2) }} Kč</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">Mezisoučet:</td>
                <td class="text-right">{{ number_format($order->items->sum(function($item) { return $item->price * $item->quantity; }), 2) }} Kč</td>
            </tr>
            <tr class="total-row">
                <td colspan="4" class="text-right">Doprava:</td>
                <td class="text-right">{{ $order->delivery_method === 'courier' ? '200,00 Kč' : '0,00 Kč' }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="4" class="text-right">Celkem:</td>
                <td class="text-right">{{ number_format($order->total, 2) }} Kč</td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 15px;">
        <p><strong>Platební podmínky:</strong> Platba převodem na účet {{ $company['account'] }}</p>
        <p><strong>Způsob dopravy:</strong> {{ $order->delivery_method === 'courier' ? 'Doručení poštou' : 'Osobní odběr' }}</p>
        @if($order->delivery_method === 'pickup')
            <p><strong>Místo odběru:</strong> {{ config('app.pickup_address') }}</p>
        @endif
    </div>

    @if($order->seller_comment)
    <div style="margin-top: 10px; padding: 8px; background-color: #f8f9fa; border-radius: 4px;">
        <p style="margin: 0; font-weight: bold;">Poznámka:</p>
        <p style="margin: 0;">{{ $order->seller_comment }}</p>
    </div>
    @endif

    <div class="footer">
        <p style="margin: 2px 0;">Děkujeme za vaši objednávku!</p>
        <p style="margin: 2px 0;">{{ $company['name'] }} | {{ $company['address'] }} | IČO: {{ $company['ico'] }}</p>
        <p style="margin: 2px 0;">Tel: {{ config('app.company_phone') }} | Email: {{ config('mail.contact_email') }}</p>
    </div>
</body>
</html>

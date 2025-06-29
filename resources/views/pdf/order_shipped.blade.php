<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <title>Objednávka #{{ $order->id }} odeslána</title>
    <style>
        @page {
            margin: 1.5cm;
            size: A4;
        }
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
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
        }
        .logo-container {
            width: 30%;
            text-align: right;
        }
        .logo {
            max-height: 45px;
            max-width: 120px;
        }
        .invoice-info {
            width: 65%;
        }
        .info-box {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 3px;
            margin-bottom: 12px;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            page-break-inside: avoid;
            font-size: 10px;
        }
        th, td {
            padding: 5px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .tracking-info {
            margin: 10px 0;
            font-size: 10px;
        }
        .footer {
            margin-top: 15px;
            padding-top: 8px;
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
        h2 {
            font-size: 14px;
            margin: 5px 0;
        }
        h3 {
            font-size: 12px;
            margin: 8px 0 5px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="invoice-info">
            <h2>Objednávka #{{ $order->id }} odeslána</h2>
            <p style="margin: 3px 0;">Datum odeslání: {{ now()->format('d.m.Y') }}</p>
        </div>
        <div class="logo-container">
            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ public_path('images/logo.png') }}" class="logo">
            @endif
        </div>
    </div>

    <div class="info-box">
        <p style="margin: 3px 0;"><strong>Zákazník:</strong> {{ $order->customer_name }}</p>
        <p style="margin: 3px 0;"><strong>Způsob dopravy:</strong> {{ $order->delivery_method === 'courier' ? 'Doručení poštou' : 'Osobní odběr' }}</p>
        <p style="margin: 3px 0;"><strong>Dopravce:</strong> {{ $order->delivery_service ?? 'Nespecifikováno' }}</p>
    </div>

    <div class="tracking-info">
        <h3>Sledovací informace</h3>
        <p style="margin: 3px 0;"><strong>Sledovací číslo:</strong> {{ $order->tracking_number ?? '---' }}</p>
        <p style="margin: 3px 0;"><strong>Předpokládané doručení:</strong> {{ $order->estimated_delivery_date?->format('d.m.Y') ?? '---' }}</p>
        @if($order->tracking_number && $order->delivery_service)
        <p style="margin: 3px 0;"><strong>Sledovat zásilku:</strong> {{ $trackingUrl ?? '' }}</p>
        @endif
    </div>

    <div>
        <h3>Položky objednávky</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 50%;">Produkt</th>
                    <th style="width: 30%;">Varianta</th>
                    <th style="width: 20%;" class="text-right">Množství</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->variant->product->name }}</td>
                    <td>{{ $item->variant->formatted_dimensions }}</td>
                    <td class="text-right">{{ $item->quantity }} ks</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($order->seller_comment)
    <div style="margin-top: 10px;">
        <h3>Poznámka prodejce</h3>
        <p style="font-size: 10px; margin: 3px 0;">{{ $order->seller_comment }}</p>
    </div>
    @endif

    <div class="footer">
        <p>Děkujeme za nákup! V případě dotazů kontaktujte {{ config('mail.contact_email') }}</p>
        <p>{{ config('app.name') }} | {{ config('app.url') }} | Tel: {{ config('app.company_phone') }}</p>
    </div>
</body>
</html>

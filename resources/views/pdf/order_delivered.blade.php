<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <title>Potvrzení o doručení #{{ $order->id }}</title>
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
        .document-info {
            width: 65%;
        }
        .document-title {
            margin: 0 0 5px 0;
            font-size: 16px;
        }
        .document-number {
            margin: 0;
            color: #666;
        }
        .info-box {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .info-column {
            width: 48%;
        }
        .section-title {
            margin: 15px 0 8px 0;
            font-size: 13px;
            color: #444;
        }
        .delivery-details {
            background-color: #f8f9fa;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .detail-row {
            margin-bottom: 5px;
        }
        .detail-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        th, td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .signature-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .signature-line {
            width: 60%;
            margin: 30px auto 5px auto;
            border-top: 1px solid #333;
        }
        .signature-label {
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-size: 9px;
            color: #777;
            text-align: center;
        }
        .notes-section {
            margin-top: 15px;
            padding: 10px;
            background-color: #fff8e1;
            border-radius: 4px;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="document-info">
            <h1 class="document-title">Potvrzení o doručení</h1>
            <p class="document-number">Číslo objednávky: #{{ $order->id }}</p>
        </div>
        <div class="logo-container">
            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ public_path('images/logo.png') }}" class="logo">
            @endif
        </div>
    </div>

    <div class="info-box">
        <div class="info-column">
            <h3 class="section-title">Dodavatel</h3>
            <p><strong>{{ config('app.name') }}</strong></p>
            <p>{{ config('app.company_address') }}</p>
            <p>IČO: {{ config('app.company_ico') }}</p>
        </div>
        <div class="info-column">
            <h3 class="section-title">Odběratel</h3>
            <p><strong>{{ $order->customer_name }}</strong></p>
            <p>{{ $order->address }}</p>
            <p>Tel: {{ $order->phone }}</p>
            <p>Email: {{ $order->email }}</p>
        </div>
    </div>

    <div class="delivery-details">
        <h3 class="section-title" style="margin-top: 0;">Podrobnosti o doručení</h3>
        <div class="detail-row">
            <span class="detail-label">Datum doručení:</span>
            <span>{{ now()->format('d.m.Y H:i') }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Dopravce:</span>
            <span>{{ $order->delivery_service ?? 'Nespecifikováno' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Sledovací číslo:</span>
            <span>{{ $order->tracking_number ?? '---' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Místo doručení:</span>
            <span>{{ $order->delivery_method === 'courier' ? $order->address : config('app.pickup_address') }}</span>
        </div>
    </div>

    <h3 class="section-title">Doručené položky</h3>
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

    @if($order->seller_comment)
    <div class="notes-section">
        <h3 class="section-title" style="margin-top: 0;">Poznámka prodejce</h3>
        <p>{{ $order->seller_comment }}</p>
    </div>
    @endif

    <div class="signature-section">
        <p>Potvrzení o převzetí zboží v pořádku:</p>
        <div class="signature-line"></div>
        <p class="signature-label">Podpis příjemce</p>
    </div>

    <div class="footer">
        <p>Děkujeme za váš nákup! V případě reklamace kontaktujte nás do 14 dnů.</p>
        <p>{{ config('app.name') }} | {{ config('app.contact_email') }} | Tel: {{ config('app.company_phone') }}</p>
    </div>
</body>
</html>

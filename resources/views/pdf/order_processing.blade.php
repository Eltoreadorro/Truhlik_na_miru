<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <title>Objednávka #{{ $order->id }} ve výrobě</title>
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
        h2 {
            margin: 0 0 5px 0;
            font-size: 16px;
            color: #2c3e50;
        }
        h3 {
            margin: 5px 0 8px 0;
            font-size: 13px;
            color: #34495e;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 3px;
        }
        .info-box {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .info-column {
            width: 48%;
        }
        .customer-info p,
        .company-info p {
            margin: 4px 0;
        }
        .timeline {
            margin: 15px 0;
        }
        .timeline-item {
            display: flex;
            margin-bottom: 8px;
            page-break-inside: avoid;
        }
        .timeline-date {
            width: 120px;
            font-weight: bold;
        }
        .timeline-content {
            flex: 1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0 15px 0;
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
        .notes {
            margin-top: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
            page-break-inside: avoid;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-size: 9px;
            color: #777;
            text-align: center;
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
            <h2>Objednávka #{{ $order->id }} ve výrobě</h2>
            <p><strong>Datum přijetí:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
            <p><strong>Číslo objednávky:</strong> {{ $order->id }}</p>
        </div>
        <div class="logo-container">
            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ public_path('images/logo.png') }}" class="logo">
            @endif
        </div>
    </div>

    <div class="info-box">
        <div class="info-column customer-info">
            <h3>Zákazník</h3>
            <p><strong>{{ $order->customer_name }}</strong></p>
            <p>{{ $order->address }}</p>
            <p>Tel: {{ $order->phone }}</p>
            <p>Email: {{ $order->email }}</p>
        </div>
        <div class="info-column company-info">
            <h3>Výrobce</h3>
            <p><strong>{{ config('app.name') }}</strong></p>
            <p>{{ config('app.company_address') }}</p>
            <p>IČO: {{ config('app.company_ico') }}</p>
            <p>Tel: {{ config('app.company_phone') }}</p>
        </div>
    </div>

    <div class="timeline">
        <h3>Průběh výroby</h3>
        <div class="timeline-item">
            <div class="timeline-date">{{ $order->created_at->format('d.m.Y') }}</div>
            <div class="timeline-content">
                <strong>Objednávka přijata</strong><br>
                Zákazník potvrdil objednávku a platbu
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-date">{{ now()->format('d.m.Y') }}</div>
            <div class="timeline-content">
                <strong>Zahájení výroby</strong><br>
                Materiál připraven k výrobě
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-date">{{ now()->addDays(3)->format('d.m.Y') }}</div>
            <div class="timeline-content">
                <strong>Předpokládané dokončení</strong><br>
                Termín dokončení výrobního procesu
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-date">{{ now()->addDays(5)->format('d.m.Y') }}</div>
            <div class="timeline-content">
                <strong>Předpokládané odeslání</strong><br>
                Balení a předání dopravci
            </div>
        </div>
    </div>

    <div>
        <h3>Položky objednávky</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 50%;">Produkt</th>
                    <th style="width: 25%;">Varianta</th>
                    <th style="width: 25%;" class="text-right">Množství</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->variant->product->name }}</td>
                    <td>
                        {{ $item->variant->formatted_dimensions }}
                        @if($item->variant->color)
                            <br>Barva: {{ $item->variant->color }}
                        @endif
                    </td>
                    <td class="text-right">{{ $item->quantity }} ks</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($order->seller_comment)
    <div class="notes">
        <h3>Poznámka prodejce</h3>
        <p>{{ $order->seller_comment }}</p>
    </div>
    @endif

    <div class="footer">
        <p>{{ config('app.name') }} | {{ config('app.url') }} | {{ config('app.company_phone') }}</p>
        <p>Děkujeme za vaši objednávku! Průběh výroby můžete sledovat na našem webu.</p>
    </div>
</body>
</html>

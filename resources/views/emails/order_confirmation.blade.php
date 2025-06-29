@component('mail::message')
# Děkujeme za vaši objednávku #{{ $order->id }}

Vaše objednávka byla úspěšně přijata.

**Detaily objednávky:**
Zákazník: {{ $order->customer_name }}
Datum: {{ $order->created_at->format('d.m.Y H:i') }}
Celková částka: **{{ number_format($order->total, 2) }} Kč**
Variabilní symbol: **{{ $order->variable_symbol }}**

@if($order->payment_method === 'bank_transfer')
@component('mail::panel')
**Platební údaje:**
Číslo účtu: 4753073093/0800
Částka: {{ number_format($order->total, 2) }} Kč
Variabilní symbol: {{ $order->variable_symbol }}
Do zprávy pro příjemce: **Objednávka {{ $order->id }}**
@endcomponent
@endif


Děkujeme za váš nákup,
**{{ config('app.name') }}**
[{{ config('app.url') }}]({{ config('app.url') }})
@endcomponent

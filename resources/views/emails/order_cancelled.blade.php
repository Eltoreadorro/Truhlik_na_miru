@component('mail::message')
# Objednávka #{{ $order->id }} byla zrušena

**Důvod zrušení:**
{{ $reason ?? 'Technické důvody' }}

**Detaily objednávky:**
- Číslo: #{{ $order->id }}
- Částka: {{ number_format($order->total, 2) }} Kč
- Datum: {{ $order->created_at->format('d.m.Y H:i') }}

@if($order->payment_status === 'paid')
@component('mail::panel')
Vaše platba bude vrácena na váš účet do 7 pracovních dnů.
@endcomponent
@endif

@component('mail::button', ['url' => route('contacts'), 'color' => 'red'])
Kontaktovat podporu
@endcomponent

Děkujeme za pochopení,
**{{ config('app.name') }}**
@endcomponent

@component('mail::message')
# Vaše objednávka #{{ $order->id }} byla odeslána 🚛

**Dopravce:** {{ $order->delivery_service }}  
**Sledovací číslo:** {{ $order->tracking_number }}  
**Předpokládané doručení:** {{ $order->estimated_delivery_date->format('d.m.Y') }}

Děkujeme za nákup,  
**{{ config('app.name') }}**  
[{{ config('app.url') }}]({{ config('app.url') }})
@endcomponent

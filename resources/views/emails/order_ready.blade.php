@component('mail::message')
# Objednávka #{{ $order->id }} je připravena k odeslání

**Způsob dopravy:** {{ $order->delivery_method === 'courier' ? 'Poštovná služba' : 'Osobní odběr' }}
**Předpokládané odeslání:** {{ now()->addDays(1)->format('d.m.Y') }}

@if($order->delivery_method === 'pickup')
@component('mail::panel')
**Místo odběru:**
{{ config('app.pickup_address') }}
**Otevírací doba:** {{ config('app.pickup_hours') }}
@endcomponent
@endif


Těšíme se na vaši další návštěvu,
**{{ config('app.name') }}**
[{{ config('app.url') }}]({{ config('app.url') }})
@endcomponent

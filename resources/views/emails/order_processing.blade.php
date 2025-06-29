@component('mail::message')
# Vaše objednávka #{{ $order->id }} se připravuje

**Stav:** Ve výrobě  
**Předpokládané termíny:**  
- Dokončení výroby: {{ now()->addDays(3)->format('d.m.Y') }}  
- Odeslání: do {{ now()->addDays(5)->format('d.m.Y') }}

@component('mail::panel')
V případě dotazů nás kontaktujte na {{ config('mail.contact_email') }}
@endcomponent

Děkujeme za trpělivost,  
**{{ config('app.name') }}**  
[{{ config('app.url') }}]({{ config('app.url') }})
@endcomponent

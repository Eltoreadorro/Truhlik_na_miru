@component('mail::message')
# Vaše objednávka #{{ $order->id }} byla doručena! 🎁

**Datum doručení:** {{ now()->format('d.m.Y') }}  
**Adresa:** {{ $order->address }}  
**Dopravce:** {{ $order->delivery_service ?? 'Česká pošta' }}

@component('mail::panel')
Pokud máte s produktem jakékoliv problémy, neváhejte nás kontaktovat do 14 dnů od převzetí.
@endcomponent

Děkujeme za vaši důvěru,  
** {{ config('app.name') }}**  
[{{ config('app.url') }}]({{ config('app.url') }})
@endcomponent

@component('mail::message')
# Nový individuální požadavek

**Jméno:** {{ $data['name'] }}
**Email:** {{ $data['email'] }}
**Telefon:** {{ $data['phone'] ?? 'Nezadáno' }}

**Detaily požadavku:**
{{ $data['details'] }}

@component('mail::button', ['url' => 'mailto:'.$data['email']])
Odpovědět zákazníkovi
@endcomponent

Děkujeme,
{{ config('app.name') }}
@endcomponent

<!DOCTYPE html>
<html lang="cz">
<head>
    @include('layouts.meta')
    @stack('styles')
    @yield('styles')

    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="Truhlík na míru - kvalitní květináče a truhlíky na zakázku">
<meta name="keywords" content="truhlíky, květináče, zahrada, na míru">
<meta name="author" content="Truhlík na míru">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="@yield('title', 'Truhlík na míru')">
<meta property="og:description" content="Kvalitní květináče a truhlíky na zakázku">
<meta property="og:image" content="{{ asset('img/og-image.jpg') }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="@yield('title', 'Truhlík na míru')">
<meta property="twitter:description" content="Kvalitní květináče a truhlíky na zakázku">
<meta property="twitter:image" content="{{ asset('img/og-image.jpg') }}">

<title>@yield('title', 'Truhlík na míru') | truhlik-na-miru.cz</title>

<!-- Favicon -->
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
<link rel="apple-touch-icon" href="{{ asset('img/apple-touch-icon.png') }}">

<!-- Canonical URL -->
<link rel="canonical" href="{{ url()->current() }}" />
</head>
<body class="bg-white text-gray-900">
    <div class="min-h-screen flex flex-col">
        @include('layouts.header')

        <main class="flex-grow">
            @yield('content')
        </main>

        @include('layouts.footer')
    </div>

@include('components.cookie-consent')

    @include('layouts.scripts')
    @stack('scripts')
    @yield('scripts')
</body>
</html>

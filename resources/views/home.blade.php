@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gray-900 text-white py-20 mt-[-70px] pt-[70px]">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 mb-10 md:mb-0 animate__animated animate__fadeInLeft">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Truhlik na Miru</h1>
            <p class="text-xl mb-8">Ručně vyráběné výrobky z umělého ratanu jsou vždy skladem a na objednávku.</p>
            <div class="flex space-x-4">
                <a href="{{ route('products.index') }}"
                   class="btn-hover-anim bg-accent-green text-white px-6 py-3 rounded hover:bg-green-600 transition transform hover:scale-105">
                    Zobrazit katalog
                </a>
                <a href="{{ route('contacts') }}"
                   class="btn-hover-anim border border-white text-white px-6 py-3 rounded hover:bg-white hover:text-black transition transform hover:scale-105">
                    Kontakty
                </a>
            </div>
        </div>
        <div class="md:w-1/2 animate__animated animate__fadeInRight">
            <img src="{{ asset('storage/products/20240212_114733.jpg') }}" alt="Product"
                 class="rounded-lg shadow-xl transform hover:scale-105 transition duration-500">
        </div>
    </div>
</section>

<!-- Výhody -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 animate__animated animate__fadeIn">Naše výhody</h2>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Blok 1 -->
            <div class="bg-gray-50 p-6 rounded-lg text-center scroll-animate hover:shadow-lg transition duration-300">
                <div class="text-accent-blue text-4xl mb-4 animate__animated animate__bounceIn">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">On-line objednávka</h3>
                <p>Snadné a rychlé online objednání produktů z pohodlí domova.</p>
            </div>

            <!-- Blok 2 -->
            <div class="bg-gray-50 p-6 rounded-lg text-center scroll-animate hover:shadow-lg transition duration-300 delay-100">
                <div class="text-accent-green text-4xl mb-4 animate__animated animate__bounceIn">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Osobní předání</h3>
                <p>Osobní předání v Praze a okolí. Doprava po celé ČR.</p>
            </div>

            <!-- Blok 3 -->
            <div class="bg-gray-50 p-6 rounded-lg text-center scroll-animate hover:shadow-lg transition duration-300 delay-200">
                <div class="text-accent-yellow text-4xl mb-4 animate__animated animate__bounceIn">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h3 class="text-xl font-bold mb-3">Individuální přístup</h3>
                <p>Individuální přístup ke každému klientovi. Možnost výroby exkluzivních sad.</p>
            </div>
        </div>
    </div>
</section>

<!-- O produktech -->
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-8 md:mb-0 md:pr-8 scroll-animate">
                <h2 class="text-3xl font-bold mb-4">Kvalitní květináče pro vaše rostliny</h2>
                <p class="text-lg mb-4">Správně zvolené barvy ovlivňují vaši náladu a pohodu.</p>
                <p class="mb-6">Výrobky jsou vyrobeny kvalitně a pečlivě a budou vám sloužit velmi dlouho. Splníme každé vaše přání pro vaše pokojové rostliny, zahradu, terasy, balkony a další.</p>
                <a href="{{ route('products.index') }}"
                   class="btn-hover-anim inline-block bg-black text-white px-6 py-3 rounded hover:bg-gray-800 transition transform hover:scale-105">
                    Zobrazit katalog
                </a>
            </div>
            <div class="md:w-1/2 scroll-animate">
                <img src="/storage/products/20250528_063500.jpg"
                     alt="Příklad květináče"
                     class="rounded-lg shadow-lg transform hover:scale-105 transition duration-500">
            </div>
        </div>
    </div>
</section>

<!-- Velké květináče -->
<section class="py-16 bg-accent-green text-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-8 md:mb-0 scroll-animate">
                <img src="storage/products/20250510_165021.jpg"
                     alt="300L květináč"
                     class="rounded-lg shadow-lg transform hover:scale-105 transition duration-500">
            </div>
            <div class="md:w-1/2 md:pl-8 scroll-animate">
                <h2 class="text-3xl font-bold mb-4">Květináče velkých objemů</h2>
                <p class="text-xl mb-4">Až 300 litrů pro vaše rostliny</p>
                <p class="mb-6">Naše největší květináče jsou ideální pro velké rostliny a stromy. Pevná konstrukce a stylový design.</p>
                <a href="{{ route('contacts') }}"
                   class="btn-hover-anim inline-block bg-white text-black px-6 py-3 rounded hover:bg-gray-100 transition transform hover:scale-105">
                    Objednat konzultaci
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Doporučené produkty -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 scroll-animate">Doporučené produkty</h2>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
    @foreach($featuredProducts as $variant)
    <div class="product-card bg-gray-50 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition scroll-animate"
         style="animation-delay: {{ $loop->index * 100 }}ms">
        <a href="{{ route('products.show', $variant->product) }}" class="block overflow-hidden">
            <img src="{{ $variant->product->getFirstMediaUrl('main') ?? asset('img/no-image.png') }}"
                 alt="{{ $variant->product->name }}"
                 class="w-full h-48 object-cover transform hover:scale-110 transition duration-500">
        </a>
        <div class="p-4">
            <h3 class="font-bold text-lg mb-2">
                <a href="{{ route('products.show', $variant->product) }}" class="hover:text-accent-green transition">
                    {{ $variant->product->name }}
                </a>
            </h3>
            @if($variant->color)
                <p class="text-accent-green font-medium mb-2">
                    <span style="background:{{ $variant->colorData->hex_code }};
                          color:{{ $variant->colorData->contrast_color }};
                          padding:2px 5px; border-radius:3px">
                        {{ $variant->colorData->name }}
                    </span>
                </p>
            @endif
            <p class="text-gray-600 text-sm mb-3">{{ $variant->product->category->name }}</p>
            <div class="flex justify-between items-center">
                <span class="font-bold">{{ $variant->price }} Kč</span>
                <a href="{{ route('products.show', $variant->product) }}" class="text-accent-green hover:text-green-600 transition transform hover:translate-x-1">
                    Detail →
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

        <div class="text-center mt-10 scroll-animate">
            <a href="{{ route('products.index') }}"
               class="btn-hover-anim inline-block bg-black text-white px-8 py-3 rounded-lg hover:bg-gray-800 transition transform hover:scale-105">
                Celý katalog
            </a>
        </div>
    </div>
</section>
@endsection

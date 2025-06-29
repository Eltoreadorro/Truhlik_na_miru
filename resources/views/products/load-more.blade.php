@foreach($products as $product)
<div class="product-card bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 transform transition-all duration-500 hover:scale-[1.02] hover:shadow-lg">
    <a href="{{ route('products.show', $product) }}" class="block overflow-hidden h-48">
        @if ($product->getFirstMediaUrl('main'))
            <img src="{{ $product->getFirstMediaUrl('main') }}"
                 class="w-full h-full object-cover transition duration-500 hover:scale-110"
                 alt="{{ $product->name }}">
        @else
            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                <span class="text-gray-400">Bez obrázku</span>
            </div>
        @endif
    </a>
    <div class="p-4">
        <h3 class="font-bold text-lg mb-2">
            <a href="{{ route('products.show', $product) }}" class="hover:text-accent-green transition">
                {{ $product->name }}
            </a>
        </h3>
        <p class="text-gray-600 text-sm mb-3">{{ $product->category->name }}</p>

        @if($product->variants->isNotEmpty())
            <div class="flex items-center justify-between mb-3">
                <span class="font-bold text-gray-800">Od {{ number_format($product->variants->min('price'), 2) }} Kč</span>
            </div>
        @endif

        <a href="{{ route('products.show', $product) }}"
           class="block w-full bg-gray-100 hover:bg-gray-200 text-center text-gray-800 py-2 px-4 rounded transition text-sm">
            Detail
        </a>
    </div>
</div>
@endforeach

@if($products->hasMorePages())
<div class="col-span-full text-center mt-8" id="load-more-container">
    <button id="load-more-btn" class="bg-accent-green text-white px-6 py-3 rounded-md hover:bg-green-600 transition text-sm"
            data-url="{{ $products->nextPageUrl() }}"
            data-loading-text="<i class='fas fa-spinner fa-spin mr-2'></i> Načítání...">
        Načíst další
    </button>
</div>
@endif

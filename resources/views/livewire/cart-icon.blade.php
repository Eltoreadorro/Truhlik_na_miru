<div class="relative">
    <a href="{{ route('cart.index') }}" class="text-white hover:text-accent-green transition">
        <i class="fas fa-shopping-cart text-xl"></i>
        @if($cartCount > 0)
        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center animate-bounce">
            {{ $cartCount }}
        </span>
        @endif
    </a>
</div>

<div class="dropdown">
    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
        Корзина
        <span class="badge bg-primary">{{ $count }}</span>
        <span class="ms-2">{{ $total }} cz.</span>
    </a>

    <div class="dropdown-menu dropdown-menu-end p-3">
        @if ($count > 0)
            <a href="{{ route('cart.index') }}" class="btn btn-primary w-100">Перейти в корзину</a>
        @else
            <div class="text-muted">Корзина пуста</div>
        @endif
    </div>
</div>

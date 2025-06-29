<div class="dropdown">
    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
        Košik
        <span class="badge bg-primary">{{ $count }}</span>
        <span class="ms-2">{{ $total }} cz.</span>
    </a>

    <div class="dropdown-menu dropdown-menu-end p-3">
        @if ($count > 0)
            <a href="{{ route('cart.index') }}" class="btn btn-primary w-100"></a>
        @else
            <div class="text-muted">Vaš košík je prazdny.</div>
        @endif
    </div>
</div>

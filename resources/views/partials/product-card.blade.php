<div class="card">
    <div class="card-body">
        <h5>{{ $product->name }}</h5>
        <p class="text-muted">{{ $product->category->name }}</p>
        <p>{{ $product->price }} cz.</p>
        <button
            class="add-to-cart btn btn-primary "
            data-url="{{ route('cart.add', $product->id) }}"
        >
            Do košíku
        </button>
    </div>
</div>

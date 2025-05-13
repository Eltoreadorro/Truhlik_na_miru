@foreach ($products as $product)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <a href="{{ route('products.show', $product) }}">
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
            </a>
            <div class="card-body">
                <h5 class="card-title">
                    <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                        {{ $product->name }}
                    </a>
                </h5>
                <p class="text-muted">{{ $product->category->name }}</p>
                <p class="h5">От {{ $product->variants->min('price') }} Kč</p>
                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary w-100">
                    Подробнее
                </a>
            </div>
        </div>
    </div>
@endforeach

@if (!$products->hasMorePages())
    <script>
        document.getElementById('load-more-btn').remove();
    </script>
@endif

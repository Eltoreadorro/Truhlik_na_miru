@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Каталог товаров</h1>
    <div class="row" id="products-container">
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
    </div>

    <div class="text-center mt-4">
        <button id="load-more-btn" class="btn btn-primary"
                data-url="{{ $products->nextPageUrl() }}">
            Показать ещё
        </button>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('load-more-btn').addEventListener('click', function() {
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Загрузка...';

    fetch(btn.dataset.url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        if (html) {
            document.getElementById('products-container').insertAdjacentHTML('beforeend', html);
            const nextUrl = new URL(btn.dataset.url);
            nextUrl.searchParams.set('page', parseInt(nextUrl.searchParams.get('page') || 1) + 1);
            btn.dataset.url = nextUrl.toString();
        } else {
            btn.remove();
        }
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = 'Показать ещё';
    });
});
</script>
@endsection

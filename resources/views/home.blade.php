{{-- home.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Популярные товары</h1>
    <div class="row" id="products-container">
        @foreach ($featuredProducts as $product)
            <div class="col-md-3 mb-4">
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
</div>
@endsection

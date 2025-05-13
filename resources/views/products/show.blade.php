@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Основная информация о продукте -->
    <div class="row mb-5">
        <div class="col-md-6">
            <!-- Главное изображение -->
            <div class="mb-4">
                <img src="{{ asset('storage/' . $product->image) }}"
                     class="img-fluid rounded"
                     id="main-product-image"
                     alt="{{ $product->name }}">
            </div>

            <!-- Галерея вариантов -->
            <div class="d-flex flex-wrap gap-2">
                @foreach($product->variants as $variant)
                <a href="#"
                   class="variant-thumbnail"
                   data-variant-id="{{ $variant->id }}"
                   data-image="{{ asset('storage/' . ($variant->image ?? $product->image)) }}">
                    <img src="{{ asset('storage/' . ($variant->image ?? $product->image)) }}"
                         class="img-thumbnail"
                         style="width: 80px; height: 80px; object-fit: cover;"
                         alt="{{ $variant->color }}">
                </a>
                @endforeach
            </div>
        </div>

        <div class="col-md-6">
            <h1 class="mb-3">{{ $product->name }}</h1>
            <p class="text-muted mb-4">{{ $product->category->name }}</p>

            <div class="mb-4">
                <h4 id="selected-variant-price">{{ $product->variants->first()->price }} Kč</h4>
                <p id="selected-variant-info">
                    Объем: {{ $product->variants->first()->volume }} л<br>
                    Цвет: {{ $product->variants->first()->color }}
                </p>
            </div>

            <form action="{{ route('cart.add', $product->variants->first()->id) }}" method="POST" class="mb-4">
                @csrf
                <div class="input-group mb-3" style="max-width: 200px;">
                    <input type="number" name="quantity" value="1" min="1"
                           class="form-control" id="quantity-input">
                    <button type="submit" class="btn btn-primary">Купить</button>
                </div>
            </form>

            <div class="product-description">
                <h4>Описание</h4>
                <p>{{ $product->description }}</p>
            </div>
        </div>
    </div>

    <!-- Похожие товары -->
    @if($similarProducts->count() > 0)
    <div class="mb-5">
        <h3 class="mb-4">Похожие товары</h3>
        <div class="row">
            @foreach($similarProducts as $similar)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <a href="{{ route('products.show', $similar) }}">
                        <img src="{{ asset('storage/' . $similar->image) }}" class="card-img-top" alt="{{ $similar->name }}">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('products.show', $similar) }}" class="text-decoration-none">
                                {{ $similar->name }}
                            </a>
                        </h5>
                        <p class="text-muted">{{ $similar->category->name }}</p>
                        <p class="h5">От {{ $similar->variants->min('price') }} Kč</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Блок индивидуального заказа -->
    <div class="custom-order bg-light p-4 rounded">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3>Нужен горшок индивидуальных размеров?</h3>
                <p class="mb-0">Мы изготовим для вас горшок любых размеров и цветов по вашим пожеланиям.</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('contacts') }}#custom-order" class="btn btn-outline-primary">
                    Заказать индивидуально
                </a>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Переключение между вариантами
document.querySelectorAll('.variant-thumbnail').forEach(thumb => {
    thumb.addEventListener('click', function(e) {
        e.preventDefault();

        // Обновляем главное изображение
        document.getElementById('main-product-image').src = this.dataset.image;

        // Получаем данные о варианте через AJAX
        fetch(`/api/variants/${this.dataset.variantId}`)
            .then(response => response.json())
            .then(variant => {
                // Обновляем информацию
                document.getElementById('selected-variant-price').textContent = variant.price + ' Kč';
                document.getElementById('selected-variant-info').innerHTML = `
                    Объем: ${variant.volume} л<br>
                    Цвет: ${variant.color}
                `;

                // Обновляем форму добавления в корзину
                const form = document.querySelector('form');
                form.action = `/cart/add/${variant.id}`;
                document.getElementById('quantity-input').value = 1;
            });
    });
});
</script>
@endsection
@endsection

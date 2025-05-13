@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Корзина</h1>

    @if(count($cartItems) > 0)
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Товар</th>
                    <th>Вариант</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Сумма</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                <tr>
                    <td>
                        <a href="{{ route('products.show', $item['variant']->product) }}">
                            {{ $item['variant']->product->name }}
                        </a>
                    </td>
                    <td>
                        {{ $item['variant']->color }}, {{ $item['variant']->volume }}л
                    </td>
                    <td>{{ $item['variant']->price }} Kč</td>
                    <td>
                        <form action="{{ route('cart.update', $item['variant']) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="number"
                                   name="quantity"
                                   value="{{ $item['quantity'] }}"
                                   min="1"
                                   class="form-control"
                                   style="width: 80px;"
                                   onchange="this.form.submit()">
                        </form>
                    </td>
                    <td>{{ $item['variant']->price * $item['quantity'] }} Kč</td>
                    <td>
                        <form action="{{ route('cart.remove', $item['variant']) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                ×
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end"><strong>Итого:</strong></td>
                    <td colspan="2"><strong>{{ $total }} Kč</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
            ← Продолжить покупки
        </a>
        <a href="{{ route('checkout') }}" class="btn btn-primary">
            Оформить заказ →
        </a>
    </div>
    @else
    <div class="alert alert-info">
        Ваша корзина пуста. <a href="{{ route('products.index') }}">Начать покупки</a>
    </div>
    @endif
</div>
@endsection

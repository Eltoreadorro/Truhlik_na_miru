@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1>Оформление заказа</h1>
    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Имя</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Телефон</label>
            <input type="tel" name="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Адрес</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Подтвердить заказ</button>
    </form>
</div>
@endsection

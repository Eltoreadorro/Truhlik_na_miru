@extends('layouts.app')

@section('content')
@php
    use App\Models\Order;
@endphp
<div class="container-fluid pt-20   ">
    <h1 class="h3 mb-4">Dashboard</h1>

    <div class="row">
        <!-- Статистика -->
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Produkty</h5>
                    <p class="h2">{{ $stats['products'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Nové objednávky</h5>
                    <p class="h2">{{ $stats['new_orders'] }}</p>
                </div>
            </div>
        </div>
        <!-- Аналогично для категорий и продаж -->
    </div>

    <!-- Последние заказы -->
    <div class="card shadow mt-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold">Poslední objednávky</h6>
        </div>
        <div class="card-body">
            @php $orders = Order::latest()->take(5)->get(); @endphp
            <ul class="list-group">
                @foreach($orders as $order)
                <li class="list-group-item">
                    #{{ $order->id }} - {{ $order->customer_name }} ({{ number_format($order->total, 2) }} Kč)
                </li>
                @endforeach
            </ul>
            </div>
    </div>
</div>
@endsection

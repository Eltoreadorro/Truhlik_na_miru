@extends('admin.layout')

@section('title', 'Dashboard')

@section('content_header')
    @section('header_title', 'Přehled')
@stop

@section('admin_content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['products'] }}</h3>
                <p>Produktů</p>
            </div>
            <div class="icon">
                <i class="fas fa-box-open"></i>
            </div>
            <a href="{{ route('admin.products.index') }}" class="small-box-footer">
                Více info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
        <a href="{{ route('home') }}" class="btn btn-sm btn-primary mb-3 p-2">
        <i class="fas fa-store"></i> Otevrit obchod
    </a>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['orders'] }}</h3>
                <p>Nových objednávek</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="small-box-footer">
                Více info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['categories'] }}</h3>
                <p>Kategorií</p>
            </div>
            <div class="icon">
                <i class="fas fa-tags"></i>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="small-box-footer">
                Více info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ number_format($stats['revenue'], 2) }} Kč</h3>
                <p>Celkový obrat</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="small-box-footer">
                Více info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Poslední objednávky</h3>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    @foreach($recentOrders as $order)
                    <li class="item">
                        <div class="product-info">
                            <a href="{{ route('admin.orders.show', $order) }}" class="product-title">
                                Objednávka #{{ $order->id }}
                                <span class="badge badge-info float-right">{{ number_format($order->total, 2) }} Kč</span>
                            </a>
                            <span class="product-description">
                                {{ $order->customer_name }} | {{ $order->created_at->format('d.m.Y H:i') }}
                            </span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('admin.orders.index') }}" class="uppercase">Zobrazit všechny objednávky</a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Nedávno přidané produkty</h3>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    @foreach($recentProducts as $product)
                    <li class="item">
                        <div class="product-img">
                            @if($product->getFirstMediaUrl('products'))
                                <img src="{{ $product->getFirstMediaUrl('products') }}" alt="Product Image" class="img-size-50">
                            @else
                                <img src="https://via.placeholder.com/50" alt="Product Image" class="img-size-50">
                            @endif
                        </div>
                        <div class="product-info">
                            <a href="{{ route('admin.products.edit', $product) }}" class="product-title">
                                {{ $product->name }}
                                <span class="badge badge-warning float-right">{{ number_format($product->price, 2) }} Kč</span>
                            </a>
                            <span class="product-description">
                                {{ $product->category->name ?? 'Není přiřazena kategorie' }}
                            </span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('admin.products.index') }}" class="uppercase">Zobrazit všechny produkty</a>
            </div>
        </div>
    </div>
</div>
@stop

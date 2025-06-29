@extends('admin.layout')

@section('title', 'Variant Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Variant Details</h1>
        <div>
            <a href="{{ route('admin.products.variants.index', $product) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Variants
            </a>
        </div>
    </div>
@stop

@section('admin_content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Variant Information</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Product</th>
                            <td>{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <th>Color</th>
                            <td>
                                <span class="badge" style="background-color: {{ $variant->color }};">
                                    {{ $variant->color_name }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Dimensions</th>
                            <td>
                                @if($variant->height && $variant->width)
                                    {{ $variant->height }}×{{ $variant->width }} cm
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td>{{ number_format($variant->price, 2) }} Kč</td>
                        </tr>
                        <tr>
                            <th>Stock</th>
                            <td>{{ $variant->stock }}</td>
                        </tr>
                        <tr>
                            <th>SKU</th>
                            <td><code>{{ $variant->sku }}</code></td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.products.variants.edit', [$product, $variant]) }}"
                       class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Variant
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Variant Image</h3>
                </div>
                <div class="card-body text-center">
                    @if($variant->hasMedia('variants'))
                        <img src="{{ $variant->getFirstMediaUrl('variants') }}"
                             class="img-fluid rounded" alt="Variant image">
                    @else
                        <div class="alert alert-info">No image available</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    .badge {
        padding: 5px 10px;
        border-radius: 3px;
        font-size: 0.9rem;
    }
    code {
        padding: 2px 5px;
        background: #f8f9fa;
        border-radius: 3px;
        font-size: 0.9rem;
    }
    .img-fluid {
        max-height: 300px;
        width: auto;
    }
</style>
@stop

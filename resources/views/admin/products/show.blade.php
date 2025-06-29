@extends('admin.layout')

@section('title', $product->name)

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Product: {{ $product->name }}</h1>
    <div>
        <a href="{{ route('admin.products.variants.create', $product) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Variant
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>
    </div>
</div>
@stop

@section('admin_content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Basic Information</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Name</th>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{!! nl2br(e($product->description)) ?: '<span class="text-muted">No description</span>' !!}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $product->created_at->format('d.m.Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $product->updated_at->format('d.m.Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Product Gallery</h3>
            </div>
            <div class="card-body">
                @if($product->getMedia('gallery')->isEmpty())
                    <div class="alert alert-info">No gallery images</div>
                @else
                    <div class="row">
                        @foreach($product->getMedia('gallery') as $media)
                        <div class="col-6 col-md-3 mb-3">
                            <img src="{{ $media->getUrl('thumb') }}"
                                 class="img-fluid img-thumbnail">
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Main Image</h3>
            </div>
            <div class="card-body text-center">
                @if($product->hasMedia('main'))
                    <img src="{{ $product->getFirstMediaUrl('main', 'medium') }}"
                         class="img-fluid img-thumbnail">
                @else
                    <div class="alert alert-warning">No main image</div>
                @endif
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Variants Summary</h3>
            </div>
            <div class="card-body">
                @if($product->variants->isEmpty())
                    <div class="alert alert-info">No variants available</div>
                @else
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Variants
                            <span class="badge badge-primary">{{ $product->variants->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Lowest Price
                            <span class="badge badge-success">
                                {{ number_format($product->variants->min('price'), 2) }} Kč
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Highest Price
                            <span class="badge badge-danger">
                                {{ number_format($product->variants->max('price'), 2) }} Kč
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Stock
                            <span class="badge badge-info">{{ $product->variants->sum('stock') }}</span>
                        </li>
                    </ul>
                @endif
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('admin.products.variants.index', $product) }}"
                   class="btn btn-primary">
                    <i class="fas fa-list"></i> Manage Variants
                </a>
            </div>
        </div>
    </div>
</div>

@if($product->variants->isNotEmpty())
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Product Variants</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Color</th>
                        <th>Dimensions</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>SKU</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product->variants as $variant)
                    <tr>
                        <td>
                            <span class="badge" >
                                {{ $variant->color_name }}
                            </span>
                        </td>
                        <td>{{ $variant->formatted_dimensions }}</td>
                        <td>{{ $variant->formatted_price }}</td>
                        <td>{{ $variant->stock }}</td>
                        <td><code>{{ $variant->sku }}</code></td>
                        <td class="text-center">
                            @if($variant->hasMedia('variants'))
                                <img src="{{ $variant->thumb_url }}" class="img-thumbnail" width="50">
                            @else
                                <span class="badge badge-secondary">No image</span>
                            @endif
                        </td>
                        <td width="150">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.products.variants.show', [$product, $variant]) }}"
                                   class="btn btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.variants.edit', [$product, $variant]) }}"
                                   class="btn btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.variants.destroy', [$product, $variant]) }}"
                                      method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                            title="Delete" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@stop

@section('css')
<style>
    .img-thumbnail {
        object-fit: cover;
        height: 150px;
        width: 100%;
    }
    .badge {
        padding: 5px 10px;
        font-size: 0.9rem;
    }
</style>
@stop

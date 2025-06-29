@extends('admin.layout')

@section('title', 'Products')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Product
    </a>
</div>
@stop

@section('admin_content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price Range</th>
                        <th>Main Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                        <td>
                            @if($product->variants->isNotEmpty())
                                {{ number_format($product->variants->min('price'), 2) }} -
                                {{ number_format($product->variants->max('price'), 2) }} Kč
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="text-center">
                            @if($product->hasMedia('main'))
                                <img src="{{ $product->getFirstMediaUrl('main', 'thumb') }}"
                                     class="img-thumbnail" width="60" alt="Product image">
                            @else
                                <span class="badge badge-secondary">No image</span>
                            @endif
                        </td>
                        <td width="150">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="btn btn-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.products.show', $product) }}"
                                   class="btn btn-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}"
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
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No products found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $products->links() }}
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
    .img-thumbnail {
        object-fit: cover;
    }
    .table th {
        white-space: nowrap;
    }
</style>
@stop

@extends('admin.layout')

@section('title', 'Variants of '.$product->name)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Variants of: {{ $product->name }}</h1>
        <div>
            <a href="{{ route('admin.products.variants.create', $product) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Variant
            </a>
            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Product
            </a>
        </div>
    </div>
@stop

@section('admin_content')
    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

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
                        @forelse($variants as $variant)
                            <tr>
                                <td>
                                    <span class="badge" style="background-color: {{ $variant->color }};">
                                        {{ $variant->color_name }}
                                    </span>
                                </td>
                                <td>
                                    @if($variant->height && $variant->width)
                                        {{ $variant->height }}×{{ $variant->width }} cm
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ number_format($variant->price, 2) }} Kč</td>
                                <td>{{ $variant->stock }}</td>
                                <td><code>{{ $variant->sku }}</code></td>
                                <td class="text-center">
                                    @if($variant->hasMedia('variants'))
                                        <img src="{{ $variant->getFirstMediaUrl('variants', 'thumb') }}"
                                             class="img-thumbnail" width="50" alt="Variant image">
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
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No variants found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $variants->links() }}
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

    .pagination li {
    display: inline-block;
}
.pagination li a {
    padding: 5px 10px;
    font-size: 14px;
}
</style>
@stop

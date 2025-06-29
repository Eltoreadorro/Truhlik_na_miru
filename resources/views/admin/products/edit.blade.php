@extends('admin.layout')

@section('title', 'Edit Product: ' . $product->name)

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Edit Product: {{ $product->name }}</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>
@stop

@section('admin_content')
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Basic Information</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Product Name*</label>
                        <input type="text" name="name" id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="3"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="category_id">Category*</label>
                        <select name="category_id" id="category_id"
                                class="form-control select2 @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Media</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Main Image</label>
                        @if($product->hasMedia('main'))
                            <div class="mb-3 text-center">
                                <img src="{{ $product->getFirstMediaUrl('main', 'medium') }}"
                                     class="img-fluid rounded mb-2" style="max-height: 200px;">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                           id="delete_main_image" name="delete_main_image" value="1">
                                    <label class="custom-control-label text-danger" for="delete_main_image">
                                        Delete current image
                                    </label>
                                </div>
                            </div>
                        @endif
                        <div class="custom-file">
                            <input type="file" name="main_image" id="main_image"
                                   class="custom-file-input @error('main_image') is-invalid @enderror">
                            <label class="custom-file-label" for="main_image">
                                {{ $product->hasMedia('main') ? 'Replace image' : 'Choose file' }}
                            </label>
                            @error('main_image')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Gallery Images</label>
                        <div class="custom-file">
                            <input type="file" name="gallery_images[]" id="gallery_images"
                                   class="custom-file-input @error('gallery_images') is-invalid @enderror" multiple>
                            <label class="custom-file-label" for="gallery_images">Add more images</label>
                            @error('gallery_images')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @if($product->hasMedia('gallery'))
                        <div class="mt-4">
                            <h5>Current Gallery</h5>
                            <div class="row">
                                @foreach($product->getMedia('gallery') as $media)
                                <div class="col-4 col-md-3 mb-3">
                                    <div class="image-container position-relative">
                                        <img src="{{ $media->getUrl('thumb') }}"
                                             class="img-thumbnail w-100">
                                        <div class="custom-control custom-checkbox position-absolute"
                                             style="top: 5px; right: 5px;">
                                            <input type="checkbox" class="custom-control-input"
                                                   id="delete_media_{{ $media->id }}"
                                                   name="delete_media[]" value="{{ $media->id }}">
                                            <label class="custom-control-label" for="delete_media_{{ $media->id }}">
                                                <i class="fas fa-trash text-danger"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card card-success mt-3">
                <div class="card-body text-center">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Update Product
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="card card-primary mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Product Variants</h3>
        <a href="{{ route('admin.products.variants.create', $product) }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Add Variant
        </a>
    </div>
    <div class="card-body">
        @if($product->variants->isEmpty())
            <div class="alert alert-info">No variants found for this product</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Color</th>
                            <th>Dimensions</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->variants as $variant)
                        <tr>
                            <td>
                                <span class="badge" style="{{ $variant->color_style }}">
                                    {{ $variant->color_name }}
                                </span>
                            </td>
                            <td>{{ $variant->formatted_dimensions }}</td>
                            <td>{{ $variant->formatted_price }}</td>
                            <td>{{ $variant->stock }}</td>
                            <td class="text-center">
                                @if($variant->hasMedia('variants'))
                                    <img src="{{ $variant->thumb_url }}" class="img-thumbnail" width="50">
                                @else
                                    <span class="badge badge-secondary">No image</span>
                                @endif
                            </td>
                            <td width="150">
                                <div class="btn-group btn-group-sm">
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
        @endif
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            placeholder: "Select a category",
            allowClear: true
        });

        // File input labels
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });
    });
</script>
@stop

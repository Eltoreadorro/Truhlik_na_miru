@extends('admin.layout')

@section('title', 'Edit Variant')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Edit Variant for: {{ $product->name }}</h1>
        <a href="{{ route('admin.products.variants.index', $product) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Variants
        </a>
    </div>
@stop

@section('admin_content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.variants.update', [$product, $variant]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Variant Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="color">Color*</label>
                            <select name="color" id="color" class="form-control select2" required>
                                <option value="">Select Color</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color->hex_code }}"
                                        @selected(old('color', $variant->color) == $color->hex_code)>
                                        {{ $color->name }} ({{ $color->hex_code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('color')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="height">Height (cm)</label>
                                    <input type="number" step="0.1" name="height" id="height"
                                           class="form-control" value="{{ old('height', $variant->height) }}">
                                    @error('height')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="width">Width (cm)</label>
                                    <input type="number" step="0.1" name="width" id="width"
                                           class="form-control" value="{{ old('width', $variant->width) }}">
                                    @error('width')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="price">Price (Kč)*</label>
                            <input type="number" step="0.01" min="0" name="price" id="price"
                                   class="form-control" value="{{ old('price', $variant->price) }}" required>
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stock">Stock*</label>
                            <input type="number" min="0" name="stock" id="stock"
                                   class="form-control" value="{{ old('stock', $variant->stock) }}" required>
                            @error('stock')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Variant Image</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Current Image</label>
                            @if($variant->hasMedia('variants'))
                                <div class="text-center mb-3">
                                    <img src="{{ $variant->getFirstMediaUrl('variants') }}"
                                         class="img-fluid rounded" style="max-height: 300px;">
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                           id="delete_image" name="delete_image" value="1">
                                    <label class="custom-control-label text-danger" for="delete_image">
                                        Delete current image
                                    </label>
                                </div>
                            @else
                                <div class="alert alert-info">No image available</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="image">New Image</label>
                            <div class="custom-file">
                                <input type="file" name="image" id="image"
                                       class="custom-file-input @error('image') is-invalid @enderror"
                                       accept="image/jpeg,image/png,image/jpg,image/webp">
                                <label class="custom-file-label" for="image">Choose file</label>
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-3 text-center">
                                <img id="image-preview" src="{{ $variant->hasMedia('variants') ? $variant->getFirstMediaUrl('variants') : 'https://via.placeholder.com/300' }}"
                                     class="img-fluid rounded" style="max-height: 300px;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-success mt-3">
                    <div class="card-body text-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Update Variant
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            placeholder: "Select a color",
            allowClear: true
        });

        // Image preview
        $('#image').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
                $(this).next('.custom-file-label').html(file.name);
            }
        });
    });
</script>
@stop

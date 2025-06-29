@extends('admin.layout')

@section('title', 'Create Variant')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Create New Variant for: {{ $product->name }}</h1>
        <a href="{{ route('admin.products.variants.index', $product) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Variants
        </a>
    </div>
@stop

@section('admin_content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Validation errors:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.products.variants.store', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf

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
                                    <option value="{{ $color->hex_code }}" @selected(old('color') == $color->hex_code)>
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
                                           class="form-control" value="{{ old('height') }}">
                                    @error('height')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="width">Width (cm)</label>
                                    <input type="number" step="0.1" name="width" id="width"
                                           class="form-control" value="{{ old('width') }}">
                                    @error('width')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="price">Price (Kč)*</label>
                            <input type="number" step="0.01" min="0" name="price" id="price"
                                   class="form-control" value="{{ old('price') }}" required>
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stock">Stock*</label>
                            <input type="number" min="0" name="stock" id="stock"
                                   class="form-control" value="{{ old('stock', 0) }}" required>
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
                            <label for="image">Image*</label>
                            <div class="custom-file">
                                <input type="file" name="image" id="image"
                                       class="custom-file-input @error('image') is-invalid @enderror" required
                                       accept="image/jpeg,image/png,image/jpg,image/webp">
                                <label class="custom-file-label" for="image">Choose file</label>
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-3 text-center">
                                <img id="image-preview" src="https://via.placeholder.com/300"
                                     class="img-fluid rounded" style="max-height: 300px;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-success mt-3">
                    <div class="card-body text-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Create Variant
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

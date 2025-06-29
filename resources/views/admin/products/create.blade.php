@extends('admin.layout')

@section('title', 'Create Product')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Create New Product</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
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

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

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
                               value="{{ old('name') }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="3"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
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
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                        <label for="main_image">Main Image*</label>
                        <div class="custom-file">
                            <input type="file" name="main_image" id="main_image"
                                   class="custom-file-input @error('main_image') is-invalid @enderror" required
                                   accept="image/jpeg,image/png,image/jpg,image/webp">
                            <label class="custom-file-label" for="main_image">Choose file</label>
                            @error('main_image')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-3 text-center">
                            <img id="main_image_preview" src="https://via.placeholder.com/300"
                                 class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="gallery_images">Gallery Images</label>
                        <div class="custom-file">
                            <input type="file" name="gallery_images[]" id="gallery_images"
                                   class="custom-file-input @error('gallery_images') is-invalid @enderror" multiple
                                   accept="image/jpeg,image/png,image/jpg,image/webp">
                            <label class="custom-file-label" for="gallery_images">Choose files</label>
                            @error('gallery_images')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <small class="form-text text-muted">
                            You can upload multiple images (max 5)
                        </small>
                        <div id="gallery_preview" class="mt-2 row"></div>
                    </div>
                </div>
            </div>

            <div class="card card-success mt-3">
                <div class="card-body text-center">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Save Product
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            placeholder: "Select a category",
            allowClear: true
        });

        // Main image preview
        $('#main_image').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#main_image_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
                $(this).next('.custom-file-label').html(file.name);
            }
        });

        // Gallery images preview
        $('#gallery_images').change(function() {
            const files = this.files;
            const previewContainer = $('#gallery_preview');
            previewContainer.empty();

            if (files.length > 0) {
                const label = $(this).next('.custom-file-label');
                if (files.length > 1) {
                    label.html(files.length + ' files selected');
                } else {
                    label.html(files[0].name);
                }

                // Show preview for each selected file
                for (let i = 0; i < files.length; i++) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewContainer.append(`
                            <div class="col-6 col-md-4 mb-2">
                                <img src="${e.target.result}" class="img-thumbnail w-100" style="height: 100px; object-fit: cover;">
                            </div>
                        `);
                    }
                    reader.readAsDataURL(files[i]);
                }
            }
        });
    });
</script>
@stop

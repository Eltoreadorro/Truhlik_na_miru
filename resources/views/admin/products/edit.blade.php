@extends('adminlte::page')

@section('title', 'Редактировать товар')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Редактирование товара</h3>
        </div>
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Указываем метод PUT для обновления данных --}}
            <div class="card-body">
                <div class="form-group">
                    <label>Название</label>
                    <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                </div>
                <div class="form-group">
                    <label>Изображение</label>
                    <input type="file" name="image" class="form-control-file">
                </div>
                <div class="form-group">
                    <label>Описание</label>
                    <textarea name="description" class="form-control" rows="3">{{ $product->description }}</textarea>
                </div>
                <div class="form-group">
                    <label>Цена (грн.)</label>
                    <input type="number" name="price" class="form-control" step="0.01" value="{{ $product->price }}" required>
                </div>
                <div class="form-group">
                    <label>Категория</label>
                    <select name="category_id" class="form-control" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if($product->category_id == $category->id) selected @endif>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Обновить</button>
            </div>
        </form>
    </div>
</div>
@stop

@extends('adminlte::page')

@section('title', 'Добавить товар')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Новый товар</h3>
        </div>
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Название</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Описание</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Цена (руб.)</label>
                    <input type="number" name="price" class="form-control" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Категория</label>
                    <select name="category_id" class="form-control" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div>
</div>
@stop

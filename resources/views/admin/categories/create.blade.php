@extends('adminlte::page')

@section('content')
<div class="container">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Название</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Slug (URL)</label>
            <input type="text" name="slug" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
@endsection

@extends('admin.layout')

@section('title', 'Přidat kategorii')

@section('content_header')
    @section('header_title', 'Nová kategorie')
    @section('header_buttons')
        <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Zpět
        </a>
    @endsection
@stop

@section('admin_content')
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Název kategorie*</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Popis</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Vytvořit</button>
            </div>
        </div>
    </form>
@stop

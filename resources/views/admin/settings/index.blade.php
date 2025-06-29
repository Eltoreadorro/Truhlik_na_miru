@extends('admin.layout')

@section('title', 'Nastavení')

@section('content_header')
    @section('header_title', 'Nastavení e-shopu')
@stop

@section('admin_content')
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Název obchodu</label>
                    <input type="text" name="shop_name" class="form-control"
                           value="{{ $settings['shop_name'] }}" required>
                </div>

                <!-- Добавьте другие поля настроек -->

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Uložit změny</button>
            </div>
        </div>
    </form>
@stop

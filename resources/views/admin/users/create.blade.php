@extends('admin.layout')

@section('title', 'Přidat uživatele')

@section('content_header')
    @section('header_title', 'Nový uživatel')
    @section('header_buttons')
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Zpět
        </a>
    @endsection
@stop

@section('admin_content')
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Jméno*</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email*</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Heslo*</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Potvrzení hesla*</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Role*</label>
                    <select name="role" class="form-control" required>
                        <option value="admin">Admin</option>
                        <option value="user">Uživatel</option>
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Vytvořit</button>
            </div>
        </div>
    </form>
@stop

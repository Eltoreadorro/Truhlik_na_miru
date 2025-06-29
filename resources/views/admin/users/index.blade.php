@extends('admin.layout')

@section('title', 'Uživatelé')

@section('content_header')
    @section('header_title', 'Seznam uživatelů')
    @section('header_buttons')
        <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Přidat uživatele
        </a>
    @endsection
@stop

@section('admin_content')
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Jméno</th>
                <th>Email</th>
                <th>Role</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td width="120">
                    <div class="btn-group">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
@stop

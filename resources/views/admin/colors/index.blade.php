@extends('admin.layout')

@section('title', 'Barvy')

@section('content_header')
    @section('header_title', 'Seznam barev')
    @section('header_buttons')
        <a href="{{ route('admin.colors.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Přidat barvu
        </a>
    @endsection
@stop

@section('admin_content')
    <table class="table table-bordered table-striped">
        <a href="{{ route('admin.colors.create') }}" class="btn btn-sm btn-primary mb-3">
        <i class="fas fa-plus"></i> Přidat kategorii
    </a>
        <thead>
            <tr>
                <th>Název</th>
                <th>Barva</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
            @foreach($colors as $color)
            <tr>
                <td>{{ $color->name }}</td>
                <td>
                    <span class="badge" style="background:{{ $color->hex_code }}; color:white;">
                        {{ $color->hex_code }}
                    </span>
                </td>
                <td width="120">
                    <div class="btn-group">
                        <a href="{{ route('admin.colors.edit', $color) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.colors.destroy', $color) }}" method="POST">
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

    {{ $colors->links() }}
@endsection

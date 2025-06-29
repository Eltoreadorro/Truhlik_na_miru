@extends('admin.layout')

@section('title', 'Kategorie')

@section('content_header')
    @section('header_title', 'Seznam kategorií')
   
@stop

@section('admin_content')
    <table class="table table-bordered table-striped">

    <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary mb-3">
        <i class="fas fa-plus"></i> Přidat kategorii
    </a>

        <thead>
            <tr>
                <th>Název</th>
                <th>URL</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td width="120">
                    <div class="btn-group">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
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

    {{ $categories->links() }}
@stop

@extends('adminlte::page')

@section('title', 'Požadavky')

@section('content_header')
    <h1>Individuální požadavky</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jméno</th>
                        <th>Email</th>
                        <th>Datum</th>
                        <th>Akce</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                    <tr>
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->name }}</td>
                        <td>{{ $request->email }}</td>
                        <td>{{ $request->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.contact-requests.show', $request->id) }}"
                               class="btn btn-info btn-sm">Zobrazit</a>
                            <form action="{{ route('admin.contact-requests.destroy', $request->id) }}"
                                  method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Opravdu smazat?')">Smazat</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $requests->links() }}
        </div>
    </div>
@stop   

@extends('adminlte::page')

@section('title', 'Mail Logs')

@section('content_header')
    <h1>Mail Logs</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>To</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->to }}</td>
                        <td>{{ $log->subject }}</td>
                        <td>{{ $log->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <form action="{{ route('admin.mail-logs.destroy', $log->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $logs->links() }}
        </div>
    </div>
@stop

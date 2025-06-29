@extends('adminlte::page')

@section('title', 'Subscribers')

@section('content_header')
    <h1>Subscribers</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Subscribed At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscribers as $subscriber)
                    <tr>
                        <td>{{ $subscriber->id }}</td>
                        <td>{{ $subscriber->email }}</td>
                        <td>{{ $subscriber->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">
        <i class="fas fa-trash"></i>
    </button>
</form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $subscribers->links() }}
        </div>
    </div>
@stop

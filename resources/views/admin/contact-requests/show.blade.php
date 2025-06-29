@extends('adminlte::page')

@section('title', 'Detail požadavku')

@section('content_header')
    <h1>Požadavek #{{ $contactRequest->id }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>Jméno:</strong> {{ $contactRequest->name }}</p>
            <p><strong>Email:</strong> {{ $contactRequest->email }}</p>
            <p><strong>Telefon:</strong> {{ $contactRequest->phone ?? 'Nezadáno' }}</p>
            <p><strong>IP adresa:</strong> {{ $contactRequest->ip_address }}</p>
            <p><strong>Datum:</strong> {{ $contactRequest->created_at->format('d.m.Y H:i') }}</p>
            <hr>
            <h5>Detaily:</h5>
            <div class="border p-3 bg-light">{{ $contactRequest->details }}</div>
        </div>
    </div>
@stop

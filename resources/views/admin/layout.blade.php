@extends('adminlte::page')

@section('title', 'Admin | Truhlik na Miru')

@section('content_header')
    <h1>@yield('header_title', 'Dashboard')</h1>
    <div class="float-right">
        @yield('header_buttons')
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @yield('admin_content')
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop

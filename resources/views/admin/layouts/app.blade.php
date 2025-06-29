@extends('adminlte::page')

@section('title', 'Admin | Truhlik na Miru')

@section('content_header')
    <h1>@yield('header')</h1>
@stop

@section('content')
    @yield('admin_content')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('AdminLTE loaded!'); </script>
@stop

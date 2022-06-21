@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>@yield('title')</h1>
    @livewireStyles

@stop

@section('content')
   @yield('content')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    @livewireScripts
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
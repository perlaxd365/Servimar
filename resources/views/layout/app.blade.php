@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

    <div class="container">
        <div class="card text-white bg-@yield('color') mb-12" >
            <div class="card-header">@yield('title')</div>
            <div class="card-body">
                <h5 class="card-title">@yield('subtitulo')</h5>
                <p class="card-text">@yield('descripcion')</p>
            </div>
        </div>
    </div>
    
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
    <script>
        console.log('Hi!');
    </script>
@stop

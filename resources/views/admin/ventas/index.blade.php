@extends('layout.app')

@section('title', 'Ventas ')
@section('icon', 'fas fa-dollar-sign')
@section('subtitulo', 'Gestión de Ventas')
@section('descripcion', 'En este apartado se realizan las ventas')
@section('color', 'warning')

@section('content')

    <div class="container">
        @livewire('ventas.ventas-index')
    </div>

@endsection

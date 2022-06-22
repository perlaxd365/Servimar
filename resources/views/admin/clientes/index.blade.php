@extends('layout.app')

@section('title', 'Clientes')
@section('subtitulo', 'Mantenimiento de Clientes')
@section('descripcion', 'En este apartado podras agregar clientes con su respectiva embarcación')
@section('color', 'warning')

@section('content')

    <div class="container">
        @livewire('cliente.clientes-index')
    </div>

@endsection

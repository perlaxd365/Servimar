@extends('layout.app')

@section('title', 'Clientes')
@section('icon', 'far fa-address-card')
@section('subtitulo', 'Mantenimiento de Clientes')
@section('descripcion', 'En este apartado podras agregar clientes con su respectiva embarcación')
@section('color', 'primary')

@section('content')

    <div class="container">
        @livewire('cliente.clientes-index')
    </div>

@endsection

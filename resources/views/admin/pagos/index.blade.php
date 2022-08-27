@extends('layout.app')

@section('title', 'Pagos')
@section('icon', 'fas fa-money-bill-wave')
@section('subtitulo', 'Pagos de Clientes')
@section('descripcion', 'En este apartado podras ver los pagos de los clientes')
@section('color', 'primary')

@section('content')

    <div class="container">
        @livewire('pago.pago-index')
    </div>

@endsection

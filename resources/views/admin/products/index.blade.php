@extends('layout.app')

@section('title', 'Productos')
@section('icon', 'fas fa-gas-pump')
@section('subtitulo', 'Mantenimiento de Productos')
@section('descripcion', 'En este apartado podras agregar productos para realizar una venta')
@section('color', 'warning')

@section('content')

    <div class="container">
        @livewire('product.product-index')
    </div>

@endsection

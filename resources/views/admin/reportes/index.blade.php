@extends('layout.app')

@section('title', 'Reportes')
@section('icon', 'fas fa-file-import')
@section('subtitulo', 'Reporte de Ventas')
@section('descripcion', 'En este apartado podras ver los reportes de ventas')
@section('color', 'success')

@section('content')

    <div class="container">
        @livewire('reporte.reporte-index')
    </div>

@endsection

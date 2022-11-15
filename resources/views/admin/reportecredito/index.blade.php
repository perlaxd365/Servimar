@extends('layout.app')

@section('title', 'Reporte Créditos')
@section('icon', 'fas fa-file-import')
@section('subtitulo', 'Reporte de Créditos')
@section('descripcion', 'Sección de Reportes de Jornadas')
@section('color', 'warning')

@section('content')

    <div class="container">
        @livewire('reporte-credito.reporte-credito-index')
    </div>

@endsection

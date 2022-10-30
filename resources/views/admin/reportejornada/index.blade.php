@extends('layout.app')

@section('title', 'Reporte Jornada')
@section('icon', 'fas fa-file-import')
@section('subtitulo', 'Reporte de Jornadas')
@section('descripcion', 'Sección de Reportes de Jornadas')
@section('color', 'success')

@section('content')

    <div class="container">
        @livewire('reporte-jornada.reporte-jornada-index')
    </div>

@endsection

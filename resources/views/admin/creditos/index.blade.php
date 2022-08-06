@extends('layout.app')

@section('title', 'Créditos ')
@section('icon', 'fa fa-credit-card')
@section('subtitulo', 'Gestión de Créditos')
@section('descripcion', 'En este apartado se gestionarán los créditos de las embarcaciones')
@section('color', 'info')

@section('content')

    <div class="container">
        @livewire('credito.creditos-index')
    </div>

@endsection

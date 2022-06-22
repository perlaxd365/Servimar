@extends('layout.app')

@section('title', 'Usuarios')
@section('subtitulo', 'Mantenimiento de Usuarios')
@section('descripcion', 'En este apartado podras agregar usuarios que accederán al sistema')
@section('color', 'info')

@section('content')

    <div class="container">
        @livewire('admin.users-index')
    </div>

@endsection

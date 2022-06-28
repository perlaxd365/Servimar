@extends('layout.app')

@section('title', 'Usuarios')
@section('icon', 'fas fa-users fa-fw')
@section('subtitulo', 'Mantenimiento de Usuarios')
@section('descripcion', 'En este apartado podras agregar usuarios que accederán al sistema')
@section('color', 'success')

@section('content')

    <div class="container">
        @livewire('admin.users-index')
    </div>

@endsection

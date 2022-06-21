@extends('layout.app')

@section('title', 'Usuarios')

@section('content')

    <div class="container">
        @livewire('admin.users-index')
    </div>

@endsection

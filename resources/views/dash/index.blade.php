@extends('layout.app')

@section('title', 'Inicio')
@section('icon', 'fa fa-home')
@section('subtitulo',auth()->user()->name. ', Bienvenido a Servimar . ' )
@section('descripcion','Página de inicio'  )
@section('color', 'secondary')

@section('content')

@endsection
    
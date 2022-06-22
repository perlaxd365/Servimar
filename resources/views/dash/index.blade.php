@extends('layout.app')

@section('title', 'Inicio')
@section('subtitulo',auth()->user()->name. ', Bienvenido a Servimar . ' )
@section('descripcion','Página de inicio'  )
@section('color', 'secondary')

@section('content')

@endsection
    
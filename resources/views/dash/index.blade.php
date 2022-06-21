@extends('layout.app')

@section('title','Inicio')

@section('content')
    
    {{
        
        'Bienvenido '.auth()->user()->name
    }}

@endsection
    
@extends('layout.app')

@section('title', 'Editar Privilegios')
@section('subtitulo', 'Usuario:  '.$user->name)
@section('descripcion', 'En este apartado podras editar los privilegios de cada usuario del sistema')
@section('color', 'warning')

@section('content')

@if (session('info'))
    <div class="alert alert-success">
        <strong>{{session('info')}}</strong>
    </div>
@endif

<div class="container">
    <div class="card">
        <div class="card-body">
            <p class="h5">Nombre:</p>
            <p class="form-control">{{ $user->name }}</p>
            <div class="row">
                <div class="col">
                    <h4>Listado de Roles</h4>
                    {!! Form::model($user, ['route' => ['admin.users.update', $user], 'method' => 'put']) !!}
        
                    @foreach ($roles as $role)
                        <div>
        
                            <label for="">
                                {!! Form::checkbox('roles[]', $role->id, null, ['class' => 'mr-1']) !!}
                                {{ $role->name }}
                            </label>
                        </div>
                    @endforeach
                            
                    {!! Form::submit('Asignar Rol', ['class'=>'bt btn-primary btn-sm']) !!}
        
                    {!! Form::close() !!}
                </div>
                <div class="col">
                    <h4>Listado de Sedes</h4>
                    {!! Form::model($user, ['route' => ['admin.users.show', $user], 'method' => 'put']) !!}
        
                    @foreach ($sedes as $sede)
                        <div>
        
                            <label for="">
                                {!! Form::radio('sede', $sede->id_sede, $user->id_sede==$sede->id_sede  ? true:false , ['class' => 'mr-1']) !!}
                                {{ $sede->descripcion }}
                            </label>
                        </div>
                    @endforeach
                            
                    {!! Form::submit('Asignar Sede', ['class'=>'bt btn-primary btn-sm']) !!}
        
                    {!! Form::close() !!}
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection

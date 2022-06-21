@extends('layout.app')

@section('title', 'Editar Privilegios')

@section('content')

@if (session('info'))
    <div class="alert alert-success">
        <strong>{{session('info')}}</strong>
    </div>
@endif

    <div class="card">
        <div class="card-body">
            <p class="h5">Nombre:</p>
            <p class="form-control">{{ $user->name }}</p>
        </div>
        <div class="card-footer mb-4">
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
    </div>

@endsection

@extends('layout')

@section('title', "Crear usuario")


@section('content')
    <h1>Editar usuario</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <h6>Por favor corrige los errores debajo:</h6>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    <form method="POST" action="{{ url("usuarios/{$user->id}") }}">
        {{method_field('PUT')}}
        {{csrf_field()}}


        <label for="name">Nombre:</label>
        <input  type="text" name="name" id="name" placeholder="Pedro Perez" value="{{old('name', $user->name)}}">

        <br>

        <label for="email">Correo electronico:</label>
        <input  type="email" name="email" id="email" placeholder="pedro@example.com" value="{{old('email', $user->email)}}">
        <br>

        <label for="password">Contraseña:</label>
        <input  type="password" name="password" id="password" placeholder="The password must be at least 6 characters">
        @if($errors->has('password'))
            <p>{{ $errors->first('password') }}</p>
        @endif
        <br>


        <button type="submit">Actualizar usuario</button>
    </form>

    <p>
        <a href="{{ route('users.index') }}">Regresar al listado de usuarios</a>
    </p>
@endsection

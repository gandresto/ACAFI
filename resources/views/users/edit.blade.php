@extends('layouts.app')

@section('page-scripts')
    <script src="{{ asset('js/warn-exit.js') }}" defer></script>
@endsection

@section('title')
    Actualizar Usuario - {{$user->nombre_completo}}
@endsection

@section('content')
    <form class="form-horizontal" method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PATCH')
        <div class="form-group row">
            <label for="grado" class="col-md-4 col-form-label text-md-right">
                Grado Usuario
            </label>
            <div class="col-md-6">
                <select class="form-control @error('grado') is-invalid @enderror" name="grado" id="grado" required>
                    @foreach (App\Grado::all()->sortBy('id') as $grado)
                        <option value="{{$grado->id}}" @if ($grado->id == $user->grado) {{'selected'}} @endif>{{$grado->id}}</option>
                    @endforeach
                </select>
                @error('grado')
                    <span class="help-block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="nombre" class="col-md-4 col-form-label text-md-right">
                Nombre
            </label>
            <div class="col-md-6">
                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ $user->nombre }}" required autofocus>

                @error('nombre')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="apellido_paterno" class="col-md-4 control-label text-md-right">Apellido Paterno</label>

            <div class="col-md-6">
                <input id="apellido_paterno" type="text" class="form-control @error('apellido_paterno') is-invalid @enderror" name="apellido_paterno" value="{{ $user->apellido_paterno }}" required>

                @error('apellido_paterno')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="apellido_materno" class="col-md-4 control-label text-md-right">Apellido Materno</label>

            <div class="col-md-6">
                <input id="apellido_materno" type="text" class="form-control @error('apellido_materno') is-invalid @enderror" name="apellido_materno" value="{{  $user->apellido_materno }}" required>

                @error('apellido_materno')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">
                Correo
            </label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user->email}}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4 text-md-right">
                <a class="btn btn-danger" role="button" href="{{route('users.index')}}">
                    <i class="fa fa-undo" aria-hidden="true"></i>
                    Regresar
                </a>
                <button type="submit" class="btn btn-primary">
                    Actualizar Usuario
                </button>
            </div>
        </div>
    </form>
@endsection

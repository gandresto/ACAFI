@extends('layouts.app')

@section('title')
    Actualizar Académico - {{$academico->nombreCompleto()}}
@endsection

@section('content')
    <form class="form-horizontal" method="POST" action="{{ route('academicos.update', $academico->id) }}">
        @csrf
        @method('PATCH')
        <div class="form-group row">
            <label for="grado_id" class="col-md-4 col-form-label text-md-right">
                Grado Académico
            </label>
            <div class="col-md-6">
                <select class="form-control @error('grado_id') is-invalid @enderror" name="grado_id" id="grado_id" required>
                    @foreach (App\Grado::all()->sortBy('id') as $grado)
                        <option value="{{$grado->id}}" @if ($grado->id == $academico->grado_id) {{'selected'}} @endif>{{$grado->id}}</option>
                    @endforeach
                </select>
                @error('grado_id')
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
                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ $academico->nombre }}" required autofocus>

                @error('nombre')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="apellido_pat" class="col-md-4 control-label text-md-right">Apellido Paterno</label>

            <div class="col-md-6">
                <input id="apellido_pat" type="text" class="form-control @error('apellido_pat') is-invalid @enderror" name="apellido_pat" value="{{ $academico->apellido_pat }}" required>

                @error('apellido_pat')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="apellido_mat" class="col-md-4 control-label text-md-right">Apellido Materno</label>

            <div class="col-md-6">
                <input id="apellido_mat" type="text" class="form-control @error('apellido_mat') is-invalid @enderror" name="apellido_mat" value="{{  $academico->apellido_mat }}" required>

                @error('apellido_mat')
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
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$academico->user->email}}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4 text-md-right">
                <a class="btn btn-danger" role="button" href="{{route('academicos.index')}}">
                    <i class="fa fa-undo" aria-hidden="true"></i>
                    Regresar
                </a>
                <button type="submit" class="btn btn-primary">
                    Actualizar Académico
                </button>
            </div>
        </div>
    </form>
@endsection

@extends('layouts.app')

@section('title')
    Agregar División
@endsection

@section('content')
    <form class="form-horizontal" method="POST" action="{{route('divisions.update', $division->id)}}">
        @csrf
        @method('PATCH')

        <div class="form-group row">
            <label for="siglas" class="col-md-4 col-form-label text-md-right">Siglas</label>

            <div class="col-md-6">
                <input id="siglas" type="text" class="form-control  @error('siglas') is-invalid @enderror" name="siglas" value="{{ $division->siglas }}" required>

                @error('siglas')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre Completo</label>

            <div class="col-md-6">
                <input id="nombre" type="text" class="form-control  @error('nombre') is-invalid @enderror" name="nombre" value="{{ $division->nombre }}" required>

                @error('nombre')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <buscar-usuario
            tiene-errores="{{$errors->has('id_jefe_div')}}"
            errores="{{$errors->has('id_jefe_div') ? $errors->first('id_jefe_div') : ''}}"
            busqueda-inicial="{{ $division->jefe->nombreCompleto() }}"
            input-tag-name="id_jefe_div">
        </buscar-usuario>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4 text-md-right">
                <a class="btn btn-danger" role="button" href="{{route('divisions.index')}}">
                    <i class="fa fa-undo" aria-hidden="true"></i>
                    Regresar
                </a>
                <button type="submit" class="btn btn-primary">
                    Actualizar División
                </button>
            </div>
        </div>
    </form>
@endsection

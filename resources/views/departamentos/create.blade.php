@extends('layouts.app')

@section('title')
    Agregar Departamento
@endsection

@section('content')
    <form class="form-horizontal" method="POST" action="{{route('departamentos.index')}}">
        @csrf

        <div class="form-group row">
            <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre del Departamento</label>

            <div class="col-md-6">
                <input id="nombre" type="text" class="form-control  @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required>

                @error('nombre')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <buscar-usuario
            tiene-errores="{{$errors->has('id_jefe_dpto')}}"
            errores="{{$errors->has('id_jefe_dpto') ? $errors->first('id_jefe_dpto') : ''}}"
            busqueda-inicial=""
            input-tag-name="id_jefe_dpto"
            label-inicial="Jefe de departamento">
        </buscar-usuario>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Añadir departamento
                </button>
            </div>
        </div>
    </form>
@endsection

@extends('layouts.app')

@section('title')
    Agregar Departamento
@endsection

@section('content')
    <form class="form-horizontal" method="POST" action="{{route('departamentos.update', $departamento->id)}}">
        @csrf
        @method('PATCH')

        <div style="@cannot('create', App\Departamento::class) {{'display: none'}} @endcannot">
            <buscar-division
                tiene-errores="{{$errors->has('division_id')}}"
                errores="{{$errors->has('division_id') ? $errors->first('division_id') : ''}}"
                busqueda-inicial="{{ $departamento->division->siglas }}"
                input-tag-name="division_id"
                label-inicial="División de procedencia">
            </buscar-division>
        </div>

        <div class="form-group row">
            <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre Completo</label>

            <div class="col-md-6">
                <input id="nombre" type="text" class="form-control  @error('nombre') is-invalid @enderror" name="nombre" value="{{ $departamento->nombre }}" required>

                @error('nombre')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div style="@cannot('create', App\Departamento::class) {{'display: none'}} @endcannot">
            <buscar-usuario
                tiene-errores="{{$errors->has('id_jefe_dpto')}}"
                errores="{{$errors->has('id_jefe_dpto') ? $errors->first('id_jefe_dpto') : ''}}"
                busqueda-inicial="{{ $departamento->jefe->nombreCompleto() }}"
                input-tag-name="id_jefe_dpto"
                label-inicial="Jefe de Departamento">
            </buscar-usuario>
        </div>
        
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4 text-md-right">
                <a class="btn btn-danger" role="button" href="{{route('departamentos.index')}}">
                    <i class="fa fa-undo" aria-hidden="true"></i>
                    Regresar
                </a>
                <button type="submit" class="btn btn-primary">
                    Actualizar Departamento
                </button>
            </div>
        </div>
    </form>
@endsection

@extends('layouts.app')

@section('title')
    Agregar Academia para el Departamento de {{$departamento->nombre}}
@endsection

@section('content')
    <form class="form-horizontal" method="POST" action="{{route('divisions.departamentos.academias.index', compact('departamento', 'division'))}}">
        @csrf

        <div class="form-group row">
            <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre del Academia</label>

            <div class="col-md-6">
                <input id="nombre" type="text" class="form-control  @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required>

                @error('nombre')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <hr>

        <buscar-usuario
            tiene-errores="{{$errors->has('presidente_id')}}"
            errores="{{$errors->has('presidente_id') ? $errors->first('presidente_id') : ''}}"
            busqueda-inicial=""
            input-tag-name="presidente_id"
            label-inicial="Presidente de academia">
        </buscar-usuario>

        <div class="form-group row">
            <label for="fecha_ingreso" class="col-md-4 col-form-label text-md-right">Fecha de inicio de su cargo</label>
            <div class="col-md-6">
                <input id="fecha_ingreso" type="date" class="form-control  @error('fecha_ingreso') is-invalid @enderror" name="fecha_ingreso" value="{{ old('fecha_ingreso') }}" required>

                @error('fecha_ingreso')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Añadir academia
                </button>
            </div>
        </div>
    </form>
@endsection

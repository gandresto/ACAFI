@extends('layouts.app')

@section('page-scripts')
    <script src="{{ asset('js/warn-exit.js') }}" defer></script>
@endsection

@section('title')
    Agregar División
@endsection

@section('content')
    <form class="form-horizontal" method="POST" action="{{route('divisions.index')}}">
        @csrf

        <div class="form-group row">
            <label for="siglas" class="col-md-4 col-form-label text-md-right">Siglas</label>

            <div class="col-md-6">
                <input id="siglas" type="text" class="form-control  @error('siglas') is-invalid @enderror" name="siglas" value="{{ old('siglas') }}" required>

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
                <input 
                    id="nombre" 
                    type="text" 
                    class="form-control  
                    @error('nombre') is-invalid @enderror" 
                    name="nombre" 
                    value="División de " 
                    placeholder="División de..."
                    required
                />

                @error('nombre')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="url" class="col-md-4 col-form-label text-md-right">Página web</label>

            <div class="col-md-6">
                <input id="url" type="text" class="form-control  @error('url') is-invalid @enderror" name="url" value="{{ old('url') }}" required>

                @error('url')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </div>

        <hr>

        <buscar-usuario
            tiene-errores="{{$errors->has('id_jefe_div')}}"
            errores="{{$errors->has('id_jefe_div') ? $errors->first('id_jefe_div') : ''}}"
            busqueda-inicial=""
            input-tag-name="id_jefe_div"
            label-inicial="Jefe de división">
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
                    Añadir división
                </button>
            </div>
        </div>
    </form>
@endsection

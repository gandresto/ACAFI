@extends('layouts.app')

@section('title')
    Agregar División
@endsection

@section('content')
    <form class="form-horizontal" method="POST" action="/division">
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
                <input id="nombre" type="text" class="form-control  @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required>

                @error('nombre')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <buscar-usuario tieneerrores="{{$errors->has('jefeDeDivision')}}" errores="{{$errors->has('jefeDeDivision') ? $errors->first('jefeDeDivision') : ''}}"></buscar-usuario>



        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Añadir división
                </button>
            </div>
        </div>
    </form>
@endsection

@extends('layouts.app')

@section('title')
    Agregar Académico
@endsection

@section('content')
    <form class="form-horizontal" method="POST" action="/academicos">
        @csrf
        <div class="form-group row">
            <label for="grado_id" class="col-md-4 col-form-label text-md-right">
                Grado Académico
            </label>
            <div class="col-md-6">
                <select class="form-control @error('grado_id') is-invalid @enderror" name="grado_id" id="grado_id" required>
                        <option value="null">Selecciona Uno</option>
                    @foreach (App\Grado::all()->sortBy('id') as $grado)
                        <option value="{{$grado->id}}">{{$grado->id}}</option>
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
                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autofocus>

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
                <input id="apellido_pat" type="text" class="form-control @error('apellido_pat') is-invalid @enderror" name="apellido_pat" value="{{ old('apellido_pat') }}" required>

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
                <input id="apellido_mat" type="text" class="form-control @error('apellido_mat') is-invalid @enderror" name="apellido_mat" value="{{ old('apellido_mat') }}" required>

                @error('apellido_mat')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Agregar Académico
                </button>
            </div>
        </div>
    </form>
@endsection

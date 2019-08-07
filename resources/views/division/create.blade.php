@extends('layouts.app')

@section('title')
    Agregar División
@endsection

@section('content')
    <form class="form-horizontal" method="POST" action="/division">
        {{ csrf_field() }}
                            
        <div class="form-group{{ $errors->has('siglas') ? ' has-error' : '' }}">
            <label for="siglas" class="col-md-4 control-label">Siglas</label>

            <div class="col-md-6">
                <input id="siglas" type="text" class="form-control" name="siglas" value="{{ old('siglas') }}" required>

                @if ($errors->has('siglas'))
                    <span class="help-block">
                        <strong>{{ $errors->first('siglas') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
            <label for="nombre" class="col-md-4 control-label">Nombre Completo</label>

            <div class="col-md-6">
                <input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" required>

                @if ($errors->has('nombre'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nombre') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <buscar-usuario tieneerrores="{{$errors->has('jefeDeDivision')}}" errores="{{$errors->has('jefeDeDivision') ? $errors->first('jefeDeDivision') : ''}}"></buscar-usuario>
        


        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Añadir división
                </button>
            </div>
        </div>
    </form>
@endsection

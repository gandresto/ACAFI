@extends('layouts.app')

@section('page-scripts')
    <script src="{{ asset('js/warn-exit.js') }}" defer></script>
@endsection

@section('title')
    Registrar Usuario
@endsection

@section('content')
    <form class="form-horizontal" method="POST" action="{{ route('users.index') }}">
        @csrf
        <div class="form-group row">
            <label for="grado" class="col-md-4 col-form-label text-md-right">
                Grado Usuario
            </label>
            <div class="col-md-6">
                <select class="form-control @error('grado') is-invalid @enderror" name="grado" id="grado" required>
                        <option value="" disabled selected>Selecciona Uno</option>
                    @foreach (App\Grado::all()->sortBy('id') as $grado)
                        <option value="{{$grado->id}}">{{$grado->id}}</option>
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

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">
                Correo
            </label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="helpId" class="col-md-4 col-form-label text-md-right">Contraseña recomendada</label>
                <div class="col-md-6">
                    <strong> {{random_str()}}</strong>
                </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">@lang('strings.pass_confirm')</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Registrar Usuario
                </button>
            </div>
        </div>
    </form>
@endsection

@extends('layouts.app')

@section('title')
    Enviar comentarios
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                </div>
            @endif
        </div>
    </div>
    <form id="feedback-form" class="form-horizontal" method="POST" action="{{route('feedback.store')}}">
        @csrf
        <div class="form-group row">
            <label for="categoria" class="col-md-4 col-form-label text-md-right">Categoría</label>
            <div class="col-md-6">
                <select class="form-control @error('categoria') is-invalid @enderror" 
                    name="categoria" 
                    id="categoria"
                    required
                >   
                    @foreach ($categorias as $categoria)
                        <option
                            value="{{ $categoria->id }}"
                            {{ old('categoria') == $categoria->id ? 'selected' : '' }}
                        >{{ $categoria->descripcion }}</option>
                    @endforeach
                </select>
                @error('categoria')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="mensaje" class="col-md-4 col-form-label text-md-right">Mensaje</label>
            <div class="col-md-6">
                <textarea class="form-control @error('mensaje') is-invalid @enderror"
                    name="mensaje" 
                    id="mensaje"
                    required 
                    rows="5"
                >{{ old('mensaje') }}</textarea>
                <small id="help-mensaje" class="form-text text-muted">
                    Ingrese un mensaje entre 10 y 500 caracteres. Los comentarios se enviarán directamente al desarrollador.
                </small>
                @error('mensaje')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button 
                    id="submit-feedback-btn" 
                    type="submit" 
                    class="btn btn-primary" 
                    onclick="event.preventDefault(); 
                            $('#submit-feedback-btn').attr('disabled', true); 
                            $('#feedback-form').submit()">
                    {{-- onclick="$('#submit-feedback-btn').attr('disabled', true); 
                            return true"> --}}
                    Enviar comentarios
                </button>
            </div>
        </div>
    </form>
@endsection

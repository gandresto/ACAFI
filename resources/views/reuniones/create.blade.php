@extends('layouts.app')

@section('title')
    Crear Reunión
@endsection

@section('content')

{{-- <div class="row">
    <div class="col-sm-12">
        @include('flash-message')
    </div>
</div> --}}

<crear-reunion></crear-reunion>


{{-- <form class="form-horizontal" method="POST">
    <div class="form-group row">
        <label for="academia" class="col-md-4 col-form-label text-md-right">Academia</label>
        <div class="col-md-6">
            <select class="custom-select" name="academia" id="academia">
                <option selected>Acad 1</option>
                <option value="2">Acad 2</option>
                <option value="3">Acad 3</option>
                <option value="4">Acad 4</option>
            </select>
            <span class="invalid-feedback" role="alert">
                <strong>Error</strong>
            </span>
        </div>
    </div>
    <div class="form-group row">
        <label for="academia" class="col-md-4 col-form-label text-md-right">Fecha y hora de inicio</label>
        <div class="col-md-6">
            <input type="datetime-local" class="form-control" name="fecha_inicio" id="fechainicio">
            <span class="invalid-feedback" role="alert">
                <strong>Error</strong>
            </span>
        </div>
    </div>
    <div class="form-group row">
        <label for="lugar" class="col-md-4 col-form-label text-md-right">Lugar</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="lugar" id="lugar">
        </div>
    </div>

</form> --}}

{{-- <div class="row">
    <div class="col-sm-12">
        {{$divisiones->links()}}
    </div>
</div> --}}

@endsection

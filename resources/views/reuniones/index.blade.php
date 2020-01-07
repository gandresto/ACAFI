@extends('layouts.app')

@section('title')
    Reuniones
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        @include('flash-message')
    </div>
</div>

@can('create', App\Reunion::class)
    <div class="row">
        <div class="col-md-12 py-2">
        <a class="btn btn-primary" href="#{{' '/*route('divisions.create')*/}}" role="button">
                <i class="fa fa-calendar-plus" aria-hidden="true"></i>
                <span class="ml-2">Agendar reunión</span>
            </a>
        </div>
    </div>
@endcan

{{-- Barra de búsqueda próximamente aquí --}}

<hr>

<div class="row">
    <div class="col-md-12">
        Lista de reuniones
    </div>
</div>

{{-- <div class="row">
    <div class="col-sm-12">
        {{$divisiones->links()}}
    </div>
</div> --}}

@endsection

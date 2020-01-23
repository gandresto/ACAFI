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
        <a class="btn btn-primary" href="{{route('reuniones.create')}}" role="button">
                <i class="fa fa-calendar-plus" aria-hidden="true"></i>
                <span class="ml-2">Agendar reunión</span>
            </a>
        </div>
    </div>
    <hr>
@endcan

{{-- Filtrado de reuniones --}}
{{-- <div class="row my-2">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form class="form-inline" action="{{url('/reuniones')}}" method="get">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="minuta" id="check-minuta" value="1"> Con minuta
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
        </form>
    </div>
</div> --}}


@if ($reuniones->isNotEmpty())
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h4>Reuniones</h4>
    </div>
    @foreach ($reuniones as $reunion)
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
        <div class="card reunion-convocado my-2">
            <div class="card-body">
                @php
                    $inicio = Carbon\Carbon::parse($reunion->inicio);
                    $fin = Carbon\Carbon::parse($reunion->fin);
                @endphp
                <p class="card-text"><strong>{{$inicio->format('d/m/Y')}}</strong></p>
                <p class="card-text">Inicia: {{$inicio->format('h:i A')}}</p>
                <p class="card-text">Finaliza: {{$fin->format('h:i A')}}</p>
                <p class="card-text">Lugar: {{$reunion->lugar}} </p>
                <p class="card-text">Academia: {{$reunion->academia->nombre}}</p>
                <p class="card-text">
                    <a name="" id="ver-reunion-{{$reunion->id}}" class="btn btn-success" href="{{route('reuniones.show', $reunion->id)}}" role="button">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        <span class="ml-1">Ver detalles</span>
                    </a>
                </p>
                @if ($reunion->orden_del_dia)
                <p class="card-text">
                    <a name="" id="descargar-od-{{$reunion->id}}" class="btn btn-danger" href="{{route('reuniones.ordendeldia.descargar', $reunion->id)}}" role="button" target="__blank">
                        <i class="fas fa-file-pdf"></i>
                        <span class="ml-1">Orden del Día</span>
                    </a>
                </p>
                @endif
                @if ($reunion->minuta)
                <p class="card-text">
                    <a name="" id="descargar-minuta-{{$reunion->id}}" class="btn btn-danger" href="#" role="button" target="__blank">
                        <i class="fas fa-file-pdf"></i>
                        <span class="ml-1">Minuta</span>
                    </a>
                </p>
                <p class="card-text">
                    {{$reunion->minuta}}
                </p>
                @else
                <p class="card-text">
                    <a name="" id="crear-minuta-{{$reunion->id}}" class="btn btn-primary" href="#" role="button">
                        <i class="fas fa-file-pdf"></i>
                        <span class="ml-1">Crear minuta</span>
                    </a>
                </p>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- <div class="row">
    <div class="col-sm-12">
        {{$reuniones->links()}}
    </div>
</div> --}}

@else

@endif
@endsection
{{-- @push('estilos')
<style>
    
</style>
@endpush --}}

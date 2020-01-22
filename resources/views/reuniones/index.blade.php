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
@endcan

<hr>

@if ($reunionesComoConvocado->isNotEmpty())
<div class="row mb-2">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h4>Reuniones como miembro de academia</h4>
    </div>
    @foreach ($reunionesComoConvocado as $reunion)
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
                <p class="card-text">Academia:  {{$reunion->academia->nombre}}</p>
                @if ($reunion->orden_del_dia)
                    <a name="" id="descargar-od-{{$reunion->id}}" class="btn btn-danger" href="{{route('reuniones.ordendeldia.descargar', $reunion->id)}}" role="button" target="__blank">
                        <i class="fas fa-file-pdf"></i>
                        <span class="ml-1">Orden del Día</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

@if ($reunionesComoPresidente->isNotEmpty())
<div class="row mb-2">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h4>Reuniones como presidente de academia</h4>
    </div>
    @foreach ($reunionesComoPresidente as $reunion)
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
        <div class="card reunion-presidente my-2">
            <div class="card-body">
                @php
                    $inicio = Carbon\Carbon::parse($reunion->inicio);
                    $fin = Carbon\Carbon::parse($reunion->fin);
                @endphp
                <p class="card-text"><strong>{{$inicio->format('d/m/Y')}}</strong></p>
                <p class="card-text">Inicia: {{$inicio->format('h:i A')}}</p>
                <p class="card-text">Finaliza: {{$fin->format('h:i A')}}</p>
                <p class="card-text">Lugar: {{$reunion->lugar}} </p>
                <p class="card-text">Academia:  {{$reunion->academia->nombre}}</p>
                @if ($reunion->orden_del_dia)
                    <a name="" id="descargar-od-{{$reunion->id}}" class="btn btn-danger" href="{{route('reuniones.ordendeldia.descargar', $reunion->id)}}" role="button" target="__blank">
                        <i class="fas fa-file-pdf"></i>
                        <span class="ml-1">Orden del Día</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

@if ($reunionesComoInvitadoExterno->isNotEmpty())
<div class="row mb-2">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h4>Reuniones como invitado externo</h4>
    </div>
    @foreach ($reunionesComoInvitadoExterno as $reunion)
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
        <div class="card reunion-invitado my-2">
            <div class="card-body">
                @php
                    $inicio = Carbon\Carbon::parse($reunion->inicio);
                    $fin = Carbon\Carbon::parse($reunion->fin);
                @endphp
                <p class="card-text"><strong>{{$inicio->format('d/m/Y')}}</strong></p>
                <p class="card-text">Inicia: {{$inicio->format('h:i A')}}</p>
                <p class="card-text">Finaliza: {{$fin->format('h:i A')}}</p>
                <p class="card-text">Lugar: {{$reunion->lugar}} </p>
                <p class="card-text">Academia:  {{$reunion->academia->nombre}}</p>
                @if ($reunion->orden_del_dia)
                    <a name="" id="descargar-od-{{$reunion->id}}" class="btn btn-danger" href="{{route('reuniones.ordendeldia.descargar', $reunion->id)}}" role="button" target="__blank">
                        <i class="fas fa-file-pdf"></i>
                        <span class="ml-1">Orden del Día</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
{{-- @push('estilos')
<style>
    
</style>
@endpush --}}

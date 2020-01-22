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

@if ($reunionesComoConvocado)
<div class="row">
    <div class="col-md-12">
        <h4>Reuniones como miembro de academia</h4>
        @foreach ($reunionesComoConvocado as $reunion)
        <div class="card my-2">
            <div class="card-body">
                @php
                    $inicio = Carbon\Carbon::parse($reunion->inicio);
                    $fin = Carbon\Carbon::parse($reunion->fin);
                @endphp
                <h5 class="card-title">{{$inicio->format('d/m/Y')}}. Academia de {{$reunion->academia->nombre}}</h5>
                {{-- <p class="card-text">Fecha {{$reunion->inicio}}</p> --}}
                <p class="card-text"></p>
                <p class="card-text">Inicia {{$inicio->format('h:i A')}}</p>
                <p class="card-text">Finaliza {{$fin->format('h:i A')}}</p>
                @if ($reunion->orden_del_dia)
                    <a name="" id="descargar-od-{{$reunion->id}}" class="btn btn-primary" href="{{route('reuniones.ordendeldia.descargar', $reunion->id)}}" role="button" target="__blank">
                        <i class="fas fa-file-pdf"></i>
                        <span class="ml-1">Orden del Día</span>
                    </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

@if ($reunionesComoPresidente)
<div class="row">
    <div class="col-md-12">
        <h4>Reuniones como presidente de academia</h4>
        @foreach ($reunionesComoPresidente as $reunion)
        <div class="card my-2">
            <div class="card-body">
                @php
                    $inicio = Carbon\Carbon::parse($reunion->inicio);
                    $fin = Carbon\Carbon::parse($reunion->fin);
                @endphp
                <h5 class="card-title">{{$inicio->format('d/m/Y')}}. Academia de {{$reunion->academia->nombre}}</h5>
                {{-- <p class="card-text">Fecha {{$reunion->inicio}}</p> --}}
                <p class="card-text"></p>
                <p class="card-text">Inicia {{$inicio->format('h:i A')}}</p>
                <p class="card-text">Finaliza {{$fin->format('h:i A')}}</p>
                @if ($reunion->orden_del_dia)
                    <a name="" id="descargar-od-{{$reunion->id}}" class="btn btn-primary" href="{{route('reuniones.ordendeldia.descargar', $reunion->id)}}" role="button" target="__blank">
                        <i class="fas fa-file-pdf"></i>
                        <span class="ml-1">Orden del Día</span>
                    </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

@if ($reunionesComoInvitadoExterno)
<div class="row">
    <div class="col-md-12">
        <h4>Reuniones como invitado externo</h4>
        @foreach ($reunionesComoInvitadoExterno as $reunion)
        <div class="card my-2">
            <div class="card-body">
                @php
                    $inicio = Carbon\Carbon::parse($reunion->inicio);
                    $fin = Carbon\Carbon::parse($reunion->fin);
                @endphp
                <h5 class="card-title">{{$inicio->format('d/m/Y')}}. Academia de {{$reunion->academia->nombre}}</h5>
                {{-- <p class="card-text">Fecha {{$reunion->inicio}}</p> --}}
                <p class="card-text">Format {{$reunion->fin}}</p>
                <p class="card-text">Inicia {{$inicio->format('h:i A')}}</p>
                <p class="card-text">Finaliza {{$fin->format('h:i A')}}</p>
                @if ($reunion->orden_del_dia)
                    <a name="" id="descargar-od-{{$reunion->id}}" class="btn btn-primary" href="{{route('reuniones.ordendeldia.descargar', $reunion->id)}}" role="button" target="__blank">
                        <i class="fas fa-file-pdf"></i>
                        <span class="ml-1">Orden del Día</span>
                    </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection

@extends('layouts.app')

@section('title')
    Reunión {{$reunion->id}}
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        @include('flash-message')
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-5">
        <div class="table-responsive-sm">
            <table class="table table-striped">
                <thead class="thead-default">
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">Inicio</td>
                            <td>{{$reunion->inicio->format('d/m/Y h:i A')}}</td>
                        </tr>
                        <tr>
                            <td scope="row">Fin</td>
                            <td>{{$reunion->fin->format('d/m/Y h:i A')}}</td>
                        </tr>
                        <tr>
                            <td scope="row">Academia</td>
                            <td>{{$reunion->academia->nombre}}</td>
                        </tr>
                        <tr>
                            <td scope="row">Lugar</td>
                            <td>{{$reunion->lugar}}</td>
                        </tr>
                    </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-12 col-md-5">
        <strong>Documentos</strong>
        <br>
        <br>
        @if ($reunion->orden_del_dia)
        <a name="" id="" class="btn btn-danger" href="{{route('reuniones.ordendeldia.descargar', $reunion->id)}}" role="button">
            <i class="fas fa-file-pdf"></i>
            <span class="ml-1">Orden del Día</span>
        </a>
        @endif
        <br>
        @if ($reunion->minuta)
        <a name="" id="" class="btn btn-danger" href="#" role="button">
            <i class="fas fa-file-pdf"></i>
            <span class="ml-1">Minuta</span>
        </a>
        @else

        @can('update', $reunion)
            @if ($reunion->minutaPendiente())
            <a name="" id="crear-minuta-{{$reunion->id}}" class="btn btn-primary" href="{{route('reuniones.minuta.create', $reunion->id)}}" role="button">
                <i class="fas fa-file"></i>
                <span class="ml-1">Crear minuta</span>
            </a>
            @endif
        @endcan

        @endif
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <strong>Convocados</strong>
    </div>
    <div class="col-sm-12">
        <div class="table-responsive-sm">  
            <table class="table table-striped">
                <thead class="thead-default">
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($reunion->convocados as $convocado)
                            <tr>
                                <td scope="row">{{$convocado->gradoNombreCompleto}}</td>
                                <td>{{$convocado->email}}</td>
                            </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
</div>

@if ($reunion->convocados->isNotEmpty())
<div class="row">
    <div class="col-sm-12">
        <strong>Invitados Externos</strong>
    </div>
    <div class="col-sm-12">
        <div class="table-responsive-sm">  
            <table class="table table-striped">
                <thead class="thead-default">
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($reunion->invitadosExternos as $convocado)
                            <tr>
                                <td scope="row">{{$convocado->gradoNombreCompleto}}</td>
                                <td>{{$convocado->email}}</td>
                            </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-sm-12">
        <strong>Orden del día:</strong>
    </div>
    <div class="col-sm-12">
        <ol>
            @foreach ($reunion->temas as $tema)
                <li>{{$tema->descripcion}}</li>
            @endforeach

            @if ($reunion->acuerdosARevision->isNotEmpty())
                <li>
                    Seguimiento a acuerdos
                    <ol>
                        @foreach ($reunion->acuerdosARevision as $acuerdo)
                        <li>{{$acuerdo->descripcion}}</li>
                        @endforeach
                    </ol>
                </li>
            @endif
        </ol>
    </div>
</div>

@endsection
{{-- @push('estilos')
<style>
    
</style>
@endpush --}}

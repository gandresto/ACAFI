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
                {{-- <thead class="thead-default">
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                </thead> --}}
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
        <div class="mb-1">
            <strong>Documentos</strong>
        </div>
        <div>
            @if ($reunion->orden_del_dia)
            <a name="btn-orden-del-dia" 
                id="btn-orden-del-dia" 
                class="btn btn-danger my-1" 
                href="{{route('reuniones.ordendeldia.descargar', $reunion->id)}}" 
                role="button"
            >
                <i class="fas fa-file-pdf mr-1"></i>
                Orden del día
            </a>
            @endif
            <br>
            {{-- Condiciones para botones de minuta --}}
            @if ($reunion->minuta)
                <a name="descargar-minuta-{{$reunion->id}}" 
                    id="descargar-minuta-{{$reunion->id}}" 
                    class="btn btn-danger my-1" 
                    href="{{route('reuniones.minuta.index', $reunion->id)}}" 
                    role="button"
                >
                    <i class="fas fa-file-pdf mr-1"></i>
                    Minuta
                </a>
            @else
                @can('crearMinuta', $reunion)
                    <a name="crear-minuta-{{$reunion->id}}" 
                        id="crear-minuta-{{$reunion->id}}" 
                        class="btn btn-primary my-1" 
                        href="{{route('reuniones.minuta.create', $reunion->id)}}" 
                        role="button"
                    >
                        <i class="fas fa-file mr-1"></i>
                        Crear minuta
                    </a>
                @endcan
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 py-1">
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
    <div class="col-sm-12 py-1">
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
    <div class="col-sm-12 col-md-6">
        <div>
            <strong>Temas por revisar:</strong>
        </div>
        <ol>
            @foreach ($reunion->temas as $tema)
                <li>{{$tema->descripcion}}</li>
            @endforeach

        </ol>
    </div>
    <div class="col-sm-12 col-md-6">
        @if ($reunion->acuerdosASeguimiento->isNotEmpty())
        <div>
            <strong>Acuerdos a seguimiento:</strong>
        </div>
        <div>
            <ol>
                @foreach ($reunion->acuerdosASeguimiento as $acuerdo)
                <li>
                    {{ $acuerdo->descripcion }} <br>
                    Responsable: {{ $acuerdo->responsable->gradoNombreCompleto }} <br>
                    Fecha compromiso de resolución: {{ formato_fecha_esp($acuerdo->fecha_compromiso) }} <br>
                    Producto/Resultado esperado: {{ $acuerdo->producto_esperado }}
                </li>
                @endforeach
            </ol>
        </div>
        @endif
    </div>
</div>

@endsection
{{-- @push('estilos')
<style>
    
</style>
@endpush --}}

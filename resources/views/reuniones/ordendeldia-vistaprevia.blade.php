@php
    $academia = App\Academia::find($academia_id);
@endphp

@extends('layouts.pdf')

@section('nombre_archivo')
    Orden del día
@endsection

@section('academia_division')
    {{$academia->departamento->division->nombre}} <br>
    <strong>Academia de {{$academia->nombre}}</strong><br>
@endsection

@section('contenido_encabezado')
    Reunión del día {{formato_dia_y_fecha_esp($inicio)}} <br>
    {{-- Reunión del día {{$inicio->locale('es')->dayName}}, {{$inicio->formatLocalized('%d de %B de %Y')}} <br> --}}
    {{$lugar}}  <br>
    Inicia: {{$inicio->format('h:i A')}}  <br>
    Finaliza: {{$fin->format('h:i A')}}  <br>
@endsection

@section('marca-de-agua')
    <div class="text-center">VISTA PREVIA</div>
@endsection

@section('contenido_documento')
<div class="row">
    <div class="col-xs-12">
        <p><strong>Presidente: </strong>{{$academia->presidente->gradoNombreCompleto}}</p>
    </div>
</div>
    <div class="row">
        <div class="col-xs-6 col-md-6">
            <strong>Miembros convocados</strong>
            <div>
                <p>
                    @foreach ($convocados as $convocado)
                        {{"{$convocado['grado']} {$convocado['nombre']} {$convocado['apellido_paterno']} {$convocado['apellido_materno']}"}} <br>
                    @endforeach
                </p>
            </div>
        </div>
        <div class="col-xs-6 col-md-6">
            @if ($invitados)
                <strong>Invitados</strong>
                <div>
                    <p>
                        @foreach ($invitados as $invitado)
                        {{"{$invitado['grado']} {$invitado['nombre']} {$invitado['apellido_paterno']} {$invitado['apellido_materno']}"}}<br>
                        @endforeach
                    </p>
                </div>
            @endif
        </div>
    </div>
    <div id="temas-orden" class="row">
        <div class="col-xs-12">
            <div class="text-center">
                <p><strong>Orden del día:</strong></p>
            </div>
            <ol>
                @foreach ($temas as $tema)
                    <li>{{$tema['descripcion']}}</li>
                @endforeach

                @if ($acuerdosASeguimiento)
                    <li>
                        Seguimiento a acuerdos
                        <ol style="margin-top:1.2mm">
                            @foreach ($acuerdosASeguimiento as $acuerdo)
                            <li>{{$acuerdo['descripcion']}}</li>
                            @endforeach
                        </ol>
                    </li>
                @endif
            </ol>
        </div>
    </div>
@endsection

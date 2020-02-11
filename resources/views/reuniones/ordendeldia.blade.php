@extends('layouts.pdf')

@section('nombre_archivo')
    Orden del día
@endsection

@section('academia_division')
    {{$reunion->academia->departamento->division->nombre}} <br>
    <strong>Academia de {{$reunion->academia->nombre}}</strong><br>
@endsection

@section('contenido_encabezado')
    Reunión del día {{$reunion->inicio->formatLocalized('%A, %d de %B de %Y')}} <br>
    {{$reunion->lugar}}  <br>
    Inicia: {{$reunion->inicio->format('h:i A')}}  <br>
    Finaliza: {{$reunion->fin->format('h:i A')}}  <br>
@endsection

@section('contenido_documento')
<div class="row">
    <div class="col-xs-12">
        <p><strong>Presidente: </strong>{{$reunion->academia->presidente->gradoNombreCompleto}}</p>
    </div>
</div>
    <div class="row">
        <div class="col-xs-6 col-md-6">
            <strong>Miembros convocados</strong>
            <div>
                <p>
                    @foreach ($reunion->convocados as $convocado)
                        {{$convocado->gradoNombreCompleto}} <br>
                    @endforeach
                </p>
            </div>
        </div>
        @if ($reunion->invitadosExternos->isNotEmpty())
            <div class="col-xs-6 col-md-6">
                @if ($reunion->invitadosExternos)
                    <strong>Invitados</strong>
                    <div>
                        <p>
                            @foreach ($reunion->invitadosExternos as $invitado)
                            {{$invitado->gradoNombreCompleto}}<br>
                            @endforeach
                        </p>
                    </div>
                @endif
            </div>
        @endif
    </div>
    <div id="temas-orden" class="row">
        <div class="col-xs-12">
            <div class="text-center">
                <p><strong>Orden del día:</strong></p>
            </div>
            <ol>
                <li>Bienvenida y apertura de la sesión</li>
                <li>Lista de asistencia</li>
                <li>
                    Revisión de temas o asuntos
                    <ol type="a" style="margin-top:1.2mm; padding-left:0.6cm">
                        @foreach ($reunion->temas as $tema)
                        <li>{{$tema->descripcion}}</li>
                        @endforeach
                    </ol>
                </li>
                @if ($reunion->acuerdosASeguimiento->isNotEmpty())
                    <li>
                        Seguimiento a acuerdos
                        <ol type="a" style="margin-top:1.2mm; padding-left:0.6cm">
                            @foreach ($reunion->acuerdosASeguimiento as $acuerdo)
                            <li>{{$acuerdo->descripcion}}</li>
                            @endforeach
                        </ol>
                    </li>
                @endif
            </ol>
        </div>
        {{-- <p style="page-break-after: always;">
            Content Page 1
        </p>
        <p style="page-break-after: never;">
            Content Page 2
        </p> --}}
    </div>
@endsection

@section('footer-content')
<div class="text-center">
    Última actualización {{$reunion->updated_at->format('d/m/y h:i A')}}
</div>    
@endsection


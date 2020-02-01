@extends('layouts.pdf')

@section('nombre_archivo')
    Orden del día
@endsection

@section('academia_division')
    {{$reunion->academia->departamento->division->nombre}} <br>
    <strong>Academia de {{$reunion->academia->nombre}}</strong><br>
@endsection

@section('contenido_encabezado')
    Reunión del {{$reunion->inicio->format('d/m/y')}} <br>
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
    </div>
    <div id="temas-orden" class="row">
        <div class="col-xs-12">
            <div class="text-center">
                <p><strong>Orden del día:</strong></p>
            </div>
            <ol>
                @foreach ($reunion->temas as $tema)
                    <li>{{$tema->descripcion}}</li>
                @endforeach

                @if ($reunion->acuerdosARevision->isNotEmpty())
                    <li>
                        Seguimiento a acuerdos
                        <ol style="margin-top:1.2mm">
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


@extends('layouts.pdf')

@section('nombre_archivo')
    Minuta
@endsection

@section('academia_division')
    {{$reunion->academia->departamento->division->nombre}} <br>
    <strong>Academia de {{$reunion->academia->nombre}}</strong><br>
@endsection

@section('contenido_encabezado')
    Minuta de la reunión del día <br>{{$reunion->inicio->formatLocalized('%A, %d de %B de %Y')}} <br>
@endsection

@section('contenido_documento')
    <div class="row" style="margin-top: -10mm">
        <div class="col-xs-12">
            <p><strong>Presidente: </strong>{{$reunion->academia->presidente->gradoNombreCompleto}}</p>
        </div>
    </div>
    <div class="row">
        <div class="text-center">
            <p><strong>Asistentes</strong></p>
        </div>
        <div class="col-xs-6 col-md-6">
            <strong>Miembros de la academia</strong>
            <div>
                <p>
                    @foreach ($reunion->convocadosQueAsistieron as $convocado)
                        {{$convocado->gradoNombreCompleto}} <br>
                    @endforeach
                </p>
            </div>
        </div>
        @if ($reunion->invitadosExternosQueAsistieron->isNotEmpty())
            <div class="col-xs-6 col-md-6">
                <strong>Invitados externos</strong>
                <div>
                    <p>
                        @foreach ($reunion->invitadosExternosQueAsistieron as $invitado)
                        {{$invitado->gradoNombreCompleto}}<br>
                        @endforeach
                    </p>
                </div>
            </div>
        @endif
    </div>
    <div id="temas-orden" class="row">
        <div class="col-xs-12">
            <div class="">
                <p><strong>Temas revisados</strong></p>
            </div>
            <ol class="lista">
                @foreach ($reunion->temas as $tema)
                    <li class="pb-5mm">
                        {{$tema->descripcion}}
                        <p><b><i>Comentarios generales</i></b></p>
                        <p class="sangria">{{$tema->comentario}}</p>
                        @if ($tema->acuerdos->isNotEmpty())
                            <p><b><i>Acuerdos generados a partir del tema</i></b></p>
                            <ol>
                                @foreach ($tema->acuerdos as $acuerdo)
                                    <li class="pb-5mm">
                                        {{$acuerdo->descripcion}}
                                        <br>
                                        <i>Responsable:</i> {{$acuerdo->responsable->gradoNombreCompleto}}.
                                        <br>
                                        <i>Producto/resultado esperado:</i> {{$acuerdo->producto_esperado}}
                                        <br>
                                        <i>Fecha compromiso de resolución:</i> {{formato_fecha_esp($acuerdo->fecha_compromiso)}}.
                                    </li>
                                @endforeach
                            </ol>
                        @endif
                    </li>
                @endforeach

                @if ($reunion->acuerdosASeguimiento->isNotEmpty())
                    <li>
                        Seguimiento a acuerdos
                        <ol style="margin-top:1.2mm">
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


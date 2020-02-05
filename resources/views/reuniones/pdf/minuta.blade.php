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
        @if ($reunion->invitadosExternos->isNotEmpty())
            <div class="col-xs-6 col-md-6">
                @if ($reunion->invitadosExternos)
                    <strong>Invitados externos</strong>
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
            <div class="">
                <p><strong>Temas revisados</strong></p>
            </div>
            <ol>
                @foreach ($reunion->temas as $tema)
                    <li class="mb-5mm">
                        {{$tema->descripcion}}
                        <p><b><i>Comentarios generales</i></b></p>
                        <p class="pl-10mm">{{$tema->comentario}}</p>
                        @if ($tema->acuerdos->isNotEmpty())
                            <p><b><i>Acuerdos generados a partir del tema</i></b></p>
                            <ol>
                                @foreach ($tema->acuerdos as $acuerdo)
                                    <li>
                                        {{$acuerdo->descripcion}}
                                        <p class="pl-5mm" style="margin-top: 1mm">
                                            <i>Responsable:</i> {{$acuerdo->responsable->gradoNombreCompleto}}
                                            <br>
                                            <i>Producto/resultado esperado:</i> {{$acuerdo->producto_esperado}}
                                            <br>
                                            <i>Fecha compromiso de resolución:</i> {{formato_fecha_esp($acuerdo->fecha_compromiso)}}
                                        </p>
                                    </li>
                                @endforeach
                            </ol>
                            {{-- <div class="pl-10mm">
                                <table class="table">
                                    <thead class="text-center">
                                        <tr>
                                            <th>Acuerdo</th>
                                            <th>Resultado/Producto esperado</th>
                                            <th>Fecha compromiso de resolución</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tema->acuerdos as $acuerdo)
                                        <tr scope="row">
                                            <td>{{$acuerdo->descripcion}}</td>
                                            <td>{{$acuerdo->producto_esperado}}</td>
                                            <td>{{formato_fecha_esp($acuerdo->fecha_compromiso)}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> --}}
                        @endif
                    </li>
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


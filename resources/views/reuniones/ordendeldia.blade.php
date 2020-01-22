@extends('layouts.pdf')

@section('nombre_archivo')
    Orden del día
@endsection

@section('academia_division')
    {{App\Academia::find($academia_id)->departamento->division->nombre}} <br>
    <strong>Academia de {{App\Academia::find($academia_id)->nombre}}</strong><br>
@endsection

@section('contenido_encabezado')
    Reunión del {{$fechaInicio->format('d/m/y')}} <br>
    {{$lugar}}  <br>
    Inicia: {{$fechaInicio->format('h:i A')}}  <br>
    Finaliza: {{$fechaFin->format('h:i A')}}  <br>
@endsection

@section('contenido_documento')    
    <div class="row">
        <div class="col-xs-6 col-md-6">
            <strong>Miembros convocados</strong>
            <div>
                <ul>
                    @foreach ($convocados as $convocado)
                        <li>{{"{$convocado['grado']} {$convocado['nombre']} {$convocado['apellido_paterno']} {$convocado['apellido_materno']}"}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-xs-6 col-md-6">
            <strong>Invitados</strong>
            <div>
                <ul>
                    @foreach ($invitados as $invitado)
                    <li> {{"{$invitado['grado']} {$invitado['nombre']} {$invitado['apellido_paterno']} {$invitado['apellido_materno']}"}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div id="temas-orden" class="row">
        <div class="col-xs-12">
            <div class="text-center"><strong>Orden del día:</strong></div>
            <ol>
                @foreach ($temas as $tema)
                    <li>{{$tema['descripcion']}}</li>
                @endforeach

                @if ($acuerdosARevision)
                    <li>
                        Seguimiento a acuerdos
                        <ol>
                            @foreach ($acuerdosARevision as $acuerdo)
                            <li>{{$acuerdo['descripcion']}}</li>
                            @endforeach
                        </ol>
                    </li>
                @endif
            </ol>
        </div>
    </div>
@endsection


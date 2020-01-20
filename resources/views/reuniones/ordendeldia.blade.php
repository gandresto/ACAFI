<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    {{-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-grid-only@1.0.0/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>Orden del Día</title>
</head>
<body>
    <div class="container">
        <div id="header" class="row">
            <div class="logo col-xs-2 col-md-2 text-center">
                <div class="mx-auto">
                    <img src="https://picsum.photos/140" alt="Logo FI" srcset="">
                </div>
            </div>
            <div class="col-xs-8 col-md-8 text-center">
                Universidad Nacional Autónoma de México <br>
                Facultad de Ingeniería <br>
                {{App\Academia::find(1)->departamento->division->nombre}} <br>
                <strong>Academia de {{App\Academia::find(1)->nombre}}</strong><br>
                <br>
                Reunión del {{$fechaInicio->format('d/m/y')}} <br>
                {{$lugar}}  <br>
                Inicia: {{$fechaInicio->format('h:i A')}}  <br>
                Finaliza: {{$fechaFin->format('h:i A')}}  <br>
            </div>
            <div class="logo col-xs-2 col-md-2 text-center">
                <div class="mx-auto">
                    <img src="https://picsum.photos/140" alt="Logo Academia" srcset="">
                </div>
            </div>
            <div class="col-xs-12 col-md-12 text-center">
            </div>
        </div>
        <hr>
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
        <div id="temas-orden text-center" class="row">
            <div class="col-xs-12">
                <div><strong>Orden del día:</strong></div>
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
    </div>
</body>
<style>
    @page { 
        size: letter
    }
    #header{
        height: 170px;
    }
    /* body, html, #pdf{
        width: 8.5in;
    } */
    .text-center{
        text-align: center;
    }
    .mx-auto {
        margin-right: auto !important;
        margin-left: auto !important;
    }
    .row{
        margin-top: 2mm;
        margin-bottom: 2mm;
    }
</style>
</html>

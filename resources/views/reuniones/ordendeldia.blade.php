<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    {{-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orden del Día</title>
</head>
<body>
    <h1>
        Orden del día
    </h1>
    <div>
        <strong>Lugar:</strong> {{$lugar}}
    </div>
    <div>
        <strong>Inicia:</strong> {{$fechaInicio->format('d/m/y h:i A')}}
    </div>
    <div>
        <strong>Finaliza:</strong> {{$fechaFin->format('d/m/y h:i A')}}
    </div>
    <h2>
        Miembros de la academia convocados
    </h2>
    <table>
        <thead>
            <tr>
                <th>
                    Nombre
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($convocados as $convocado)
            <tr>
                <td>
                    {{"{$convocado['nombre']} {$convocado['apellido_paterno']} {$convocado['apellido_materno']}"}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if ($invitados)
        <h2>
            Invitados externos
        </h2>
        <table>
            <thead>
                <tr>
                    <th>
                        Nombre
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invitados as $invitado)
                <tr>
                    <td>
                        {{"{$invitado['nombre']} {$invitado['apellido_paterno']} {$invitado['apellido_materno']}"}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <h2>Temas por revisar</h2>
    <ol>
        @foreach ($temas as $tema)
            <li>{{$tema['descripcion']}}</li>
        @endforeach
    </ol>
</body>
<style>
    body, html{
        width: 85%;
    }
</style>
</html>

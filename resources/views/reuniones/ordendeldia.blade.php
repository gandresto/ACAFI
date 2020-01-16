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
    @if ($convocados)
        {{-- {{var_dump($convocados)}} --}}
        {{-- {{var_dump($keys)}} --}}
        {{-- {{$convocados}} --}}
        {{-- {{json_decode($convocados)}} --}}
        {{-- {{count($convocados)}} --}}
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
                {{-- @for ($i = 0; $i < count($convocados); $i++)
                <tr>
                    <td>
                        {{$convocados[$i]}}
                    </td>
                </tr>
                @endfor --}}
            </tbody>
        </table>
    @endif
    {{-- @if ($invitados)
        {{$invitados}}
        @endif --}}
    @if ($lugar)
        {{$lugar}}
    @endif
    @if ($fechaInicio)
        {{$fechaInicio}}
    @endif
</body>
</html>

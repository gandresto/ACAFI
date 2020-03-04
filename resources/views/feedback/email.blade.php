<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet">
</head>
<style>
    body {
        font-family: 'Roboto', monospace;
        font-size: 14px;
    }
    th, td {
        padding: 5px;
        border-bottom: 1px solid #ddd;
    }
    h1{
        font-size: 16px;
    }
</style>
<body>
    <div>
        <h1>Reporte de retroalimentación</h1>
    </div>
    <div>
        <table class="table">
            <tbody>
                <tr>
                    <td scope="row">ID de reporte</td>
                    <td>{{ $feedback->id }}</td>
                </tr>
                <tr>
                    <td scope="row">Categoría</td>
                    <td>{{ $feedback->categoria->descripcion }}</td>
                </tr>
                <tr>
                    <td scope="row">ID de usuario</td>
                    <td>{{ $feedback->user->id }}</td>
                </tr>
                <tr>
                    <td scope="row">Nombre de usuario</td>
                    <td>{{ $feedback->user->nombrecompleto }}</td>
                </tr>
                <tr>
                    <td scope="row">Email</td>
                    <td>
                        <a href="mailto:{{ $feedback->user->email }}">{{ $feedback->user->email }}</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        <p><strong>Mensaje:</strong></p>
        <p style="padding-left:10px">{{ $feedback->mensaje }}</p>
    </div>
</body>
</html>
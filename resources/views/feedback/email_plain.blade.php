Reporte de retroalimentación #{{ $feedback->id }} <br>
Categoría: {{ $feedback->categoria->descripcion }} <br>

Usuario #{{ $feedback->user->id }} <br>
Nombre: {{ $feedback->user->nombrecompleto }} <br>
Email: {{ $feedback->user->email }} <br>

Mensaje: <br>
{{ $feedback->mensaje }} <br>
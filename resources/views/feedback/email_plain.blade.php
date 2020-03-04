Reporte de retroalimentación #{{ $feedback->id }}
Categoría: {{ $feedback->categoria->descripcion }}

Usuario #{{ $feedback->user->id }}
Nombre: {{ $feedback->user->nombrecompleto }}
Email: {{ $feedback->user->email }}

Mensaje:
{{ $feedback->mensaje }}
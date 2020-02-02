<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Correo del administrador del sistema
    |--------------------------------------------------------------------------
    |
    | Es el dato que se verificará para 
    |
    */
    'email' => env('ADMIN_EMAIL', 'administrador@agendav2.com'),
    'password' => env('ADMIN_PASSWORD', 'secret'),
    'grado' => env('ADMIN_GRADO', 'C.'),
    'nombre' => env('ADMIN_NOMBRE', 'Administración'),
    'apellido_pat' => env('ADMIN_APELLIDO_PATERNO', 'Agenda'),
    'apellido_mat' => env('ADMIN_APELLIDO_MATERNO', 'V2'),
];

?>

# Agenda V2

Agenda para las academias de la FI. Hecho sobre el framework de Laravel 5.8 con PHP 7.3.

## Instrucciones de instalación

Requerimientos:
- Laravel 5.8
- Composer
- npm

**Pasos**

1. Instalar las dependencias necesarias usando, dentro de la carpeta del proyecto, el comando:

    ```$ composer install```

2. Instalar las dependencias de npm usando el comando:

    ```$ npm install```

3. Editar el archivo .env.example para adecuarlo a tu entorno y renombrarlo como .env
4. Editar el archivo config/admin.example.php, en él podrás editar los datos del administrador del sistema de agendas. Renombrarlo como admin.php
5. Mapear las clases del proyecto usando el comando: 

    ```$ composer dumpautoload```

6. Generar clave de aplicación con el comando: 

    ```$ php artisan key:generate```

7. Correr las migraciones con el comando: 

    ```$ php artisan migrate```
    
8. ¡Listo!

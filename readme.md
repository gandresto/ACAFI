# Agenda V2

Agenda para las academias de la FI. Hecho sobre el framework de Laravel 5.8 con PHP 7.3.

## Requisitos

- PHP >= 7.1.3
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Composer
- npm

## Instrucciones de instalación

1. Instalar las dependencias necesarias usando, dentro de la carpeta del proyecto, el comando:

    ```shell
    $ composer install
    ```

2. Instalar las dependencias de npm:

    ```shell
    $ npm install
    ```

3. Editar el archivo .env.example para adecuarlo a tu entorno y renombrarlo como .env

4. Generar clave de aplicación: 

    ```shell
    $ php artisan key:generate
    ```

5. Generar la caché de los archivos de configuración:

    ```shell
    $ php artisan config:cache
    ```

6. Correr las migraciones:

    ```shell
    $ php artisan migrate
    ```
    
7. Compilar assets de la aplicación:

    ```shell
    $ npm run dev|prod|watch
    ```

8. Publicar assets de telescope (en caso de necesitarlos):

    ```shell
    $ php artisan telescope:publish
    ```
    
9. ¡Listo!

<!-- ## Manual de usuario -->

<!-- Link al manual de usuario -->
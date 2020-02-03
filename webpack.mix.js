const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.autoload({
    'moment': ['moment','window.moment'],   
  });

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/warn-exit.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/pdf.scss', 'public/css');

// mix.js('resources/js/warn-exit.js', 'public/js');

// En producción, descomentar esta línea
/* module.exports = {
    mode: 'production'
} */

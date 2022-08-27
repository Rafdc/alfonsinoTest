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

mix.js('resources/js/app.js', 'public/js')
    .js('node_modules/datatables.net/js/jquery.dataTables.min.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .copy('resources/css/custom.css', 'public/css')
    .postCss('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css', 'public/css')
    .postCss('node_modules/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css', 'public/css')
    
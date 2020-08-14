const mix = require('laravel-mix');
const glob = require('glob');

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

mix.copyDirectory('resources/images', 'public/images');
mix.copyDirectory('resources/fonts', 'public/fonts');

mix.sass('resources/sass/admin/admin.scss', 'public/css')
    .js('resources/js/admin/admin.js', 'public/js')
    .copy('resources/vendor/js/vendor.min.js', 'public/js/vendor.js')
    .copy('resources/vendor/css/vendor.min.css', 'public/css/vendor.css')
    .version();

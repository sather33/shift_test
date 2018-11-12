let mix = require('laravel-mix');

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

mix// .js('resources/assets/js/*.js', 'public/assets/js/app.js') // single file
   .combine(['resources/assets/js/*.js'], 'public/assets/js/app.js')
   // .js('resources/assets/js/back/backend.js', 'public/assets/js/backend.js')
   .sass('resources/assets/sass/app.sass', 'public/assets/css/app.css')
   .sass('resources/assets/sass/laravel.sass', 'public/assets/css/laravel.css')
   // .sass('resources/assets/sass/back/backend.sass', 'public/assets/css/backend.css')
   .version()
   .copyDirectory('resources/assets/img', 'public/assets/img')
   .copyDirectory('resources/assets/fonts', 'public/assets/fonts')
   .copyDirectory('resources/assets/vendor', 'public/assets/vendor')
   ;


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
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    // .postCss('resources/css/css/*.css', 'public/css/app.css')
    .postCss('resources/css/css/animate.min.css', 'public/css/app.css')
    .postCss('resources/css/css/style.css', 'public/css/app.css')
    .postCss('resources/css/css/owl.carousel.css', 'public/css/app.css')
    .postCss('resources/css/css/font-awesome.min.css', 'public/css/app.css')
    .postCss('resources/css/css/style-color.css', 'public/css/app.css')
    .postCss('resources/css/css/bootstrap.css', 'public/css/app.css')
    .postCss('resources/css/css/bootstrap.min.css', 'public/css/app.css')

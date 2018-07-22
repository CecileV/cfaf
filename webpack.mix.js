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
mix.js([
	'resources/assets/js/app.js',
	'resources/assets/js/fontawesome-all.js'
	], 'public/js/app.js')
	.js([
	'resources/assets/js/app.js',
	'resources/assets/js/fontawesome-all.js',
	'resources/assets/js/selectize.js',
	'resources/assets/js/admin.js'
	], 'public/js/admin.js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .sass('resources/assets/sass/filemanager.scss', 'public/css');

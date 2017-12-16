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

// mix.js('resources/assets/js/app.js', 'public/js')
//    .sass('resources/assets/sass/app.scss', 'public/css');


mix.combine([
			'resources/assets/js/jquery-3.2.1.min.js',
			'resources/assets/js/semantic.min.js',
			 ], 'public/js/app.js')

	.combine([ 
			'resources/assets/css/semantic.min.css',
			], 'public/css/app.css');


// mix.js('resources/assets/js/app.js', 'public/js')
//    .sass('resources/assets/sass/app.scss', 'public/css')
//    .copy('node_modules/semantic-ui/dist/semantic.min.css','public/css/semantic.min.css')
//    .copy('node_modules/semantic-ui/dist/semantic.min.js','public/js/semantic.min.js');
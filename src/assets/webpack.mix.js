const mix = require('laravel-mix');
require('laravel-mix-polyfill');
mix.setPublicPath('/');



// apply sass
mix.sass('src/scss/themes/dt-purple/theme.scss', 'dist/css/dt-purple.min.css');

mix.js('src/js/dt.js', 'dist/js/dt.min.js');


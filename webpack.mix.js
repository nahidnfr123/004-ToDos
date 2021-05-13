const mix = require('laravel-mix');


mix.js('resources/assets/js/app.js', 'public/dist/js')
    .postCss('resources/assets/css/app.css', 'public/dist/css', [
        require("tailwindcss"),
    ]);
//.browserSync('127.0.0.1:8000');

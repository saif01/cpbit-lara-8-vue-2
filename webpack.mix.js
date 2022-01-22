const mix = require('laravel-mix');

// const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin');
// var webpackConfig = {
//     plugins: [
//         new VuetifyLoaderPlugin()
//     ],
// }

// mix.webpackConfig(webpackConfig);

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
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();

//auth JS 
mix.js('resources/js/auth/js/app.js', 'public/js/auth/app.js')
    .vue();
    
//auth CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/auth/style.css',
    ], 'public/css/auth/app.css');



// //Login JS 
// mix.js('resources/js/login/js/app.js', 'public/js/login/app.js')
//     .vue();
    
// //Login CSS 
// mix.styles([
//         'resources/css/common/preloader.css',
//         'resources/css/login/style.css',
//     ], 'public/css/login/app.css');


// //Register JS 
// mix.js('resources/js/register/js/app.js', 'public/js/register/app.js')
//     .vue();
    
// //Register CSS 
// mix.styles([
//         'resources/css/common/preloader.css',
//         'resources/css/register/style.css',
//     ], 'public/css/register/app.css');


//dashboard JS 
mix.js('resources/js/dashboard/js/app.js', 'public/js/dashboard/app.js')
    .vue();
    
//dashboard CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/dashboard/style.css',
    ], 'public/css/dashboard/app.css');


//super_admin JS 
mix.js('resources/js/super_admin/js/app.js', 'public/js/super_admin/app.js')
    .vue();
    
//super_admin CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/super_admin/style.css',
    ], 'public/css/super_admin/app.css');



//room admin JS 
mix.js('resources/js/room/admin/js/app.js', 'public/js/room/admin/app.js')
    .vue();
    
//room admin CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/room/admin/style.css',
    ], 'public/css/room/admin/app.css');


//room user JS 
mix.js('resources/js/room/user/js/app.js', 'public/js/room/user/app.js')
    .vue();
    
//room user CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/room/user/style.css',
    ], 'public/css/room/user/app.css');

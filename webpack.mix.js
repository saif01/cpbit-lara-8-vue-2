const mix = require('laravel-mix');


// Main CSS
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



//dashboard JS 
mix.js('resources/js/dashboard/js/app.js', 'public/js/dashboard/app.js')
    .vue();
//dashboard CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/dashboard/style.css',
    ], 'public/css/dashboard/app.css');

//*********Start super_admin *********Start
//super_admin JS 
mix.js('resources/js/super_admin/js/app.js', 'public/js/super_admin/app.js')
    .vue();
//super_admin CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/super_admin/style.css',
    ], 'public/css/super_admin/app.css');

//*********End super_admin *********End


// *********Start Room *********Start

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

// *********End Room *********End





// *********Start SMS *********Start

//sms admin JS 
mix.js('resources/js/sms/admin/js/app.js', 'public/js/sms/admin/app.js')
    .vue(); 
//sms admin CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/sms/admin/style.css',
    ], 'public/css/sms/admin/app.css');


//sms user JS 
mix.js('resources/js/sms/user/js/app.js', 'public/js/sms/user/app.js')
    .vue();
//sms user CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/sms/user/style.css',
    ], 'public/css/sms/user/app.css');

// *********End SMS *********End

    
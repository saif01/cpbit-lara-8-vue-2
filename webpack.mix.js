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



// *********Start carpool *********Start

//carpool admin JS 
mix.js('resources/js/carpool/admin/js/app.js', 'public/js/carpool/admin/app.js')
    .vue();
    
//carpool admin CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/carpool/admin/style.css',
], 'public/css/carpool/admin/app.css');


//carpool user JS 
mix.js('resources/js/carpool/user/js/app.js', 'public/js/carpool/user/app.js')
    .vue();
    
//carpool user CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/carpool/user/style.css',
    ], 'public/css/carpool/user/app.css');

// *********End carpool *********End



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




// *********Start ivca *********Start

//ivca admin JS 
mix.js('resources/js/ivca/admin/js/app.js', 'public/js/ivca/admin/app.js')
    .vue();
    
//ivca admin CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/ivca/admin/style.css',
    ], 'public/css/ivca/admin/app.css');
    


//ivca user JS 
mix.js('resources/js/ivca/user/js/app.js', 'public/js/ivca/user/app.js')
    .vue();
    
//ivca user CSS 
mix.styles([
        'resources/css/common/preloader.css',
        'resources/css/ivca/user/style.css',
    ], 'public/css/ivca/user/app.css');


// *********End ivca *********End




// *********Start cms *********Start

//cms admin_application JS 
mix.js('resources/js/cms/admin_application/js/app.js', 'public/js/cms/admin_application/app.js')
    .vue();
    
//cms admin_application CSS 
mix.styles([
       'resources/css/common/preloader.css',
    ], 'public/css/cms/admin_application/app.css');
    

//cms admin_hardware JS 
mix.js('resources/js/cms/admin_hardware/js/app.js', 'public/js/cms/admin_hardware/app.js')
    .vue();
    
//cms admin_hardware CSS 
mix.styles([
       'resources/css/common/preloader.css',
    ], 'public/css/cms/admin_hardware/app.css');
    


//cms user JS 
mix.js('resources/js/cms/user/js/app.js', 'public/js/cms/user/app.js')
    .vue();
    
//cms user CSS 
mix.styles([
        'resources/css/common/preloader.css',
    ], 'public/css/cms/user/app.css');


// *********End cms *********End



// *********Start Inventory *********Start

//inventory admin JS 
mix.js('resources/js/inventory/admin/js/app.js', 'public/js/inventory/admin/app.js')
    .vue(); 
//inventory admin CSS 
mix.styles([
        'resources/css/common/preloader.css',
    ], 'public/css/inventory/admin/app.css');


//inventory user JS 
mix.js('resources/js/inventory/user/js/app.js', 'public/js/inventory/user/app.js')
    .vue();
//inventory user CSS 
mix.styles([
        'resources/css/common/preloader.css',
    ], 'public/css/inventory/user/app.css');

// *********End Inventory *********End


    
<?php


// return array(
//     'pdf' => array(
//     'enabled' => true,
//     'binary' => base_path('vendor\wemersonjanuario\wkhtmltopdf-windows\bin\64bit\wkhtmltopdf'),
//     'timeout' => false,
//     'options' => array(),
//     'env' => array(),
//     ),
//     'image' => array(
//     'enabled' => true,
//     'binary' => base_path('vendor\wemersonjanuario\wkhtmltopdf-windows\bin\64bit\wkhtmltopdf'),
//     'timeout' => false,
//     'options' => array(),
//     'env' => array(),
//     )
//     );


return [

    /*
    |--------------------------------------------------------------------------
    | Snappy PDF / Image Configuration
    |--------------------------------------------------------------------------
    |
    | This option contains settings for PDF generation.
    |
    | Enabled:
    |    
    |    Whether to load PDF / Image generation.
    |
    | Binary:
    |    
    |    The file path of the wkhtmltopdf / wkhtmltoimage executable.
    |
    | Timout:
    |    
    |    The amount of time to wait (in seconds) before PDF / Image generation is stopped.
    |    Setting this to false disables the timeout (unlimited processing time).
    |
    | Options:
    |
    |    The wkhtmltopdf command options. These are passed directly to wkhtmltopdf.
    |    See https://wkhtmltopdf.org/usage/wkhtmltopdf.txt for all options.
    |
    | Env:
    |
    |    The environment variables to set while running the wkhtmltopdf process.
    |
    */
    
    'pdf' => [
        'enabled' => true,
        'binary'  => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf"',
        //'binary'  => base_path('vendor\h4cc\wkhtmltopdf-amd64\bin\wkhtmltopdf-amd64'),
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],
    
    'image' => [
        'enabled' => true,
        'binary'  => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltoimage --viewport-size 1024x768"',
        //'binary'  => 'vendor\wemersonjanuario\wkhtmltopdf-windows\bin\64bit\wkhtmltoimage',
        'timeout' => false,
        'options' => [],
        'options' => array(
            //'page-size' => 'A4',
            //'margin-top' => 5,
            //'margin-right' => 5,
            //'margin-left' => 5,
            //'margin-bottom' => 6,
            //'orientation' => 'Landscape',
            //'footer-center' => 'Page [page] of [toPage]',
            //'footer-font-size' => 5,
            //'footer-left' => 'Confidential'
        ),
        'env'     => [],
    ],

];

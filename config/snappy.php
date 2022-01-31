<?php

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
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],
    
    'image' => [
        'enabled' => true,
        'binary'  => "C:\Program Files\wkhtmltopdf\bin\wkhtmltoimage --viewport-size 1024x768",
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

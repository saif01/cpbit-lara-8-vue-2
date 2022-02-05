<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('all-assets\common\bootstrap-4.0\css\bootstrap.min.css') }}" />

    <style>
        .cpb_logo {
            height: 50px;
            width: 50px;
        }

        .food_logo {
            height: 50px;
            width: 50px;
        }
    </style>
    @stack('styles')
</head>
<body>
    @yield('content')

    <div class="mt-4">
        <span class="text-muted float-left small">{{ date("j-M-Y, g:i A", time()) }}</span>
        <span class="text-muted float-right small">Copyright © Powered By CPB-IT</span>
    </div>
</body>
</html>
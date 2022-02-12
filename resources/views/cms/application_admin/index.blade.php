<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('common.cpbd-icon')
    <title>CPB-IT Application Admin</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cms/admin_application/app.css') }}">
</head>
<body>
    <div id="app">
        <div v-if="preloader" class="loader">
            <div class="loader-icon">Loading...</div>
        </div>
        <index-component authuser="{{ Auth::user() }}" permission="{{ $roles }}"></index-component>
    </div>
    <script src="{{ asset('js/cms/admin_application/app.js') }}"></script>
</body>

</html>

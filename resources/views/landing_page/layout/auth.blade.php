<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#06aa5e">
    <meta name="msapplication-navbutton-color" content="#06aa5e">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>@yield('title')</title>
    {{-- <link rel="shortcut icon" href="./assets/images/favicon.png" type="image/x-icon"> --}}
    <link rel="stylesheet" href="{{ asset('landing_page/css/auth/styles.css') }}">
    {{-- <script src="{{ asset('landing_page/js/auth/script.js') }}" defer></script> --}}
</head>

<body>
    @yield('content')
</body>

</html>

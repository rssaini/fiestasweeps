<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Fiesta Sweeps</title>
    <link rel="stylesheet" href="/css/app.css" />
    <link rel="icon" type="image/png" href="{{ asset('assets/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="Fiesta Sweeps" />
    <link rel="manifest" href="{{ asset('assets/site.webmanifest') }}" />
</head>
<body>
    <div class="container">
        @include('layouts.navigation')

        @yield('content')


        @include('layouts.footer')
    </div>
</body>
</html>
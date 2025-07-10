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
    <style>
          .sweepstakes-footer {
            background-color: #f8f9fa;
            padding: 15px 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            margin-top: auto;
        }

        .sweepstakes-notice {
            font-size: 12px;
            color: #6c757d;
            line-height: 1.4;
            margin: 0;
        }

        .sweepstakes-notice a {
            color: #007bff;
            text-decoration: underline;
            font-weight: 500;
        }

        .sweepstakes-notice a:hover {
            color: #0056b3;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        @include('layouts.navigation')

        @yield('content')
    </div>
    @include('layouts.footer')
    <footer class="sweepstakes-footer">
        <p class="sweepstakes-notice">
            No purchase necessary. AMOE available via mail or email.
            <a href="/official-rules" aria-label="View official sweepstakes rules and free entry details">
                Click here for official rules & free entry details.
            </a>
        </p>
    </footer>
</body>
</html>

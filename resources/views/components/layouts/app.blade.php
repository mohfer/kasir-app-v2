<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" value="{{ csrf_token() }}"/>

    <title>{{ $title ?? 'Kasir App' }} | Kasir App</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        #nprogress .bar {
            background: #0D6EFD !important;
        }
    </style>
    @livewireStyles

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</head>

<body>
    @if (request()->routeIs('auth.login') === false)
        <div>
            @livewire('navbar')
        </div>
    @endif

    <div class="mb-5">
        {{ $slot }}
    </div>
</body>

</html>

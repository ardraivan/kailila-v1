<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.3.1/css/hover-min.css">
    <link rel="icon" href="{{ asset('images/logokailila.png') }}">

</head>

<body>

    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>

    @yield('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>

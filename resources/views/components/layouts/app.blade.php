<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config(app . name) }}</title>

    @include('components.layouts.partials.styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        @include('components.layouts.partials.navigation')

        @include('components.layouts.partials.sidebar')

        <div class="content-wrapper">

            @include('components.layouts.partials.content-header')

            <section class="content">
                <div class="container-fluid">

                    {{ $slot }}
                </div>
            </section>

        </div>

        @include('components.layouts.partials.footer')

        @include('components.layouts.partials.scripts')
</body>
</html>

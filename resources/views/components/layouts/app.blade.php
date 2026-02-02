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

        <script>
            document.addEventListener('livewire:init', () => {

                Livewire.on('close-modal', (idModal) => {
                    $('#' + idModal).modal('hide');
                })
                Livewire.on('open-modal', (idModal) => {
                    $('#' + idModal).modal('show');
                })

                // Emitir evento eliminar al componente
                Livewire.on('delete', (e) => {
                    // alert(e.id+'-'+e.eventName)
                    Swal.fire({
                        title: "Estas seguro?",
                        text: "No podras revertir esto!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si, Eliminar!",
                        cancelButtonText: "Cancelar",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch(e.eventName, {
                                id: e.id
                            })
                        }
                    });
                })

                Livewire.on('swal', data => {
                    Swal.fire(data[0]);
                });
            })
        </script>
</body>

</html>

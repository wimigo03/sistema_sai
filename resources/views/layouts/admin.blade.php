<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="robots" content="noindex,nofollow">
    <title>G.A.R.G.CH. | S.A.I.</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/monster-admin-lite/" />
    <link rel="icon" type="image/png" sizes="18x18" href="{{ asset('logos/logo2.png') }}">
    {{--<link href="{{ asset('admin_assets/css/style.min.css') }}" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/slim-select/slimselect.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dataTable_1.10.22/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dataTable_1.10.22/css/responsive.dataTables.min.css') }}">
    <link href="{{ asset('dashboard/css/select2.min.css') }}" rel="stylesheet">
    {{--<link rel="stylesheet" href="{{ asset('plugins2/datatables/dataTables.css') }}" />--}}
    <link href="{{ asset('dashboard/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/fonts/roboto.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/fonts/poppins.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/fonts/sourceserif.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome_6.0/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('datepicker/datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/tooltips.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/notificaciones/Lobibox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/notificaciones/notifications.css') }}" rel="stylesheet">
    <style>
        #customers-table tbody td.details-control {
            background-image: url('{{ asset('admin_assets/images/details_open.png') }}');
            cursor: pointer;
            background-repeat: no-repeat;
            background-position: center;
            background-origin: content-box;
            background-size: 20px;
            padding: 7px;
        }
        #customers-table tbody tr.shown td.details-control {
            background-image: url('{{ asset('admin_assets/images/details_close.png') }}');
            cursor: pointer;
            background-repeat: no-repeat;
            background-position: center;
            background-origin: content-box;
            background-size: 20px;
            padding: 7px;
        }
        .hrrr {
            border: rgb(102, 100, 100) solid 1px;
            padding: 0px;
        }
    </style>
    @include('layouts.modal.alerta')
    @include('layouts.modal.confirmar')
     @include('layouts.modal.no-confirmar')
    @include('layouts.modal.confirmar_compra') 
    @yield('styles')
</head>
<body style="background-color: #fafafa;" {{--onLoad="document.getElementById('alx').click();"--}}>
{{--<body style="background-color: #f8f8f8;">--}}
    @include('partial.admin.dashboard')
    <main>
        {{--<div class="site-section">--}}
            <div class="container-xl">
                <br>
                <br>
                {{--@include('components.flash_alerts')--}}
                @yield('content')
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                </form>
            </div>
        {{--</div>
             //url: "{{ route('pregunta/id') }}",
            --}}
    </main>
    <script src="{{ asset('admin_assets/plugins/slim-select/slimselect.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/handlebars.js') }}"></script>
    <script src="{{ asset('dataTable_1.10.22/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('dataTable_1.10.22/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dataTable_1.10.22/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/select2.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/main.js') }}"></script>
    <script src="{{ asset('datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('datepicker/datepicker.es.js') }}"></script>
    <script src="{{ asset('js/notificaciones/Lobibox.js') }}"></script>
    <script src="{{ asset('js/notificaciones/notification-active.js') }}"></script>
    <script src="{{ asset('js/auxiliares.js') }}"></script>

    @include('layouts.modal.notificaciones')

    <script>
      //
    </script>
@yield('scripts')
</body>
{{--<footer class="text-center">
    © 2022 Gobierno Autonomo Regional del Gran Chaco <a href="https://granchaco.gob.bo/">Pagina Web</a>
</footer>--}}
</html>

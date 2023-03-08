<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="robots" content="noindex,nofollow">
    <title>G.A.R.G.CH. | S.A.I.</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/monster-admin-lite/" />
    <!-- Favicon icon -->
    {{--<link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">--}}
    <link rel="icon" type="image/png" sizes="18x18" href="{{ asset('logos/logo2.png') }}">
    <!-- Custom CSS -->
    <link href="{{ asset('admin_assets/css/style.min.css') }}" rel="stylesheet">
    <!-- slim select -->
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/slim-select/slimselect.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins2/datatables/dataTables.css') }}" />
    {{--<link rel="stylesheet" href="{{ asset('dataTable_1.10.22/css/jquery.dataTables.min.css') }}" />--}}

    <link href="{{ asset('dashboard/css/fonts/roboto.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/fonts/poppins.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/fonts/sourceserif.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">
    <style>
        .btn {
            margin: 2.5px;
        }
        .card-header {
            background: #D3D7DC !important;
            color: #fff !important;
        }
        .hoverTable tr:hover {
            background-color: #F2F7F8;

        }
        .scrollme {
            overflow-x: auto;
        }
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
        #customers-table tbody tr .rowDetails p {
            font-size: 14px;
            font-weight: 800;
            float: left;
            margin-right: 10px;
            padding: 1px;
            margin-bottom: 0;
        }

        #customers-table tbody tr .rowDetails a {}
        #customers-table tbody tr .rowDetails td {
            padding: 5px;
        }
        .m-r-10 {
            margin-right: 10px !important;
        }
        .responsive {
            width: 100%;
            height: auto;
        }
    </style>
    <style>
        .bg-gradient-warning {background-color: #f6c23e;background-image: linear-gradient(180deg,#f6c23e 10%,#dda20a 100%);background-size: cover;}
        .bg-gradient-secondary {background-color: #6c757d;background-image: linear-gradient(180deg,#6c757d 10%,#807e7e 100%);background-size: cover;}
        .row-reverse{flex-direction: row-reverse;}
        .font-verdana-xs {font-size: 10px; font-family: verdana,arial,helvetica;}
        .font-verdana {font-size: 11px; font-family: verdana,arial,helvetica;}
        .font-verdana-bg {font-size: 15px; font-family: verdana,arial,helvetica;}
        .font-courier{font-size:12;font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;}
        .btn-color-primary{background:#2962FF;}
        .btn-color-success{background:#28a745;}
    </style>
    @yield('styles')
</head>
<body>
    @include('partial.admin.dashboard')
    <main>
        {{--<div class="site-section">--}}
            <div class="container">
                <br>
                <br>
                @yield('content')
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                </form>
            </div>
        {{--</div>--}}  
    </main>
    {{--<div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>--}}

    <script src="{{ asset('admin_assets/plugins/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->

    <script src="{{ asset('admin_assets/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/app-style-switcher.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('admin_assets/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('admin_assets/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('admin_assets/js/custom.js') }}"></script>
    <!--This page JavaScript -->
    <!--flot chart-->
    <script src="{{ asset('admin_assets/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/pages/dashboards/dashboard1.js') }}"></script>

    <!-- slim-select -->
    <script src="{{ asset('admin_assets/plugins/slim-select/slimselect.min.js') }}"></script>
    {{--<script src="{{ asset('dataTable_1.10.22/js/jquery.dataTables.min.js') }}"></script>--}}
    <script src="{{ asset('admin_assets/js/handlebars.js') }}"></script>

    <script src="{{ asset('plugins2/datatables/datatables.min.js') }}"></script>

    <script src="{{ asset('dashboard/js/main.js') }}"></script>

    @yield('scripts')
</body>
{{--<footer class="text-center">
    © 2022 Gobierno Autonomo Regional del Gran Chaco <a href="https://granchaco.gob.bo/">Pagina Web</a>
</footer>--}}
</html>
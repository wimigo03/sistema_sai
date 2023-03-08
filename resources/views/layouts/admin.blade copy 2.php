<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('dashboard/css/fonts/roboto.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/fonts/poppins.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/fonts/sourceserif.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700" rel="stylesheet">
    {{--Previus--}}
    <title>S.A.I. - G.A.R.G.CH.</title>
    <style>
        table tbody tr:hover{background:#F4F4F4!important;}
        .bg-gradient-warning {background-color: #f6c23e;background-image: lin
            ear-gradient(180deg,#f6c23e 10%,#dda20a 100%);background-size: cover;}
        .bg-gradient-secondary {background-color: #6c757d;background-image: linear-gradient(180deg,#6c757d 10%,#807e7e 100%);background-size: cover;}
        .font-verdana-sm {font-size: 11px; font-family: verdana,arial,helvetica;}
        .font-verdana {font-size: 12px; font-family: verdana,arial,helvetica;}
        .font-verdana-bg {font-size: 14px; font-family: verdana,arial,helvetica;}
        .abs-center {display: flex;justify-content: center;align-items: center;}
    </style>
    @yield('styles')
  </head>
  <body>
    @include('partial.admin.dashboard')
    {{--@include('partial.admin.sidebar')--}}
    <main>
        <div class="container">
            @if(Session::has('status-success'))
                <div class="alert alert-success">
                    {{Session::get('status-success')}}
                </div>
            @endif

            @if(Session::has('status-info'))
                <div class="alert alert-info">
                    {{Session::get('status-info')}}
                </div>
            @endif

            @if(Session::has('status-warning'))
                <div class="alert alert-warning">
                    {{Session::get('status-warning')}}
                </div>
            @endif

            @if(Session::has('status-danger'))
                <div class="alert alert-danger">
                    {{Session::get('status-danger')}}
                </div>
            @endif
            @yield('content')
        </div>
    </main>
    <script src="{{ asset('dashboard/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/main.js') }}"></script>

    {{--Previus--}}
    {{--<script src="{{ asset('admin_assets/plugins/jquery/dist/jquery.min.js') }}"></script>--}}
    <!-- Bootstrap tether Core JavaScript -->
    {{--<script src="{{ asset('admin_assets/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>--}}
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
    @yield('scripts')
  </body>
</html>
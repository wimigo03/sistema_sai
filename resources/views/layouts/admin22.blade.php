<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Laravel 8 | Roles and Permissions Manager</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/monster-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <!-- Custom CSS -->
    <link href="{{ asset('admin_assets/css/style.min.css') }}" rel="stylesheet">
    <!-- slim select -->
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/slim-select/slimselect.min.css') }}">

<link rel="stylesheet" href="{{ asset('dataTable_1.10.22/css/jquery.dataTables.min.css') }}"/>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
        <style>
            .btn{
                margin: 2.5px;
            }
            .card-header{
            background: #B9BEC8 !important;
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
            background-repeat:  no-repeat;
            background-position: center;
            background-origin: content-box;
            background-size:20px;
            padding: 7px;
        }
        #customers-table tbody tr.shown td.details-control {
            background-image: url('{{ asset('admin_assets/images/details_close.png') }}');
            cursor: pointer;
            background-repeat:  no-repeat;
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
        #customers-table tbody tr .rowDetails a{

        }
        #customers-table tbody tr .rowDetails td{
            padding: 5px;
        }
        .m-r-10{
            margin-right: 10px !important;
        }
    



        </style>
        @yield('styles')
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand justify-content-center">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->

                                <img src="{{ asset('logos/logo.png') }}" class="dark-logo" width="158px" alt="Laravel Roles & Permissions Manager">


                        </b>
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none"
                        href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav d-none d-md-block d-lg-none">
                        <li class="nav-item">
                            <a class="nav-toggler nav-link waves-effect waves-light text-white"
                                href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav">
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                        <font size="2" face="Courier New" >
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" style="color:white;font-size:18px;" href="" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                   Bienvenido:  {{ Auth()->user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                               <a href="javascript:void(0)" onclick="$('#logout-form').submit();" class="dropdown-item">
                                    <i class="fa fa-sign-out-alt mr-3"></i>
                                    Cerrar sesión
                               </a>
                            </div>
                        </font>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        @include('partial.admin.sidebar')
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper" style="min-height:100vh;">

            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid" >

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

                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                </form>

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="text-center">
                © 2022 Gobierno Autonomo Regional del Gran Chaco  <a href="https://granchaco.gob.bo/">Pagina Web</a>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
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
    <script src="{{ asset('dataTable_1.10.22/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/handlebars.js') }}"></script>

    

    <script src="{{ asset('plugins2/datatables/datatables.min.js') }}"></script>


    @yield('scripts')
</body>

</html>

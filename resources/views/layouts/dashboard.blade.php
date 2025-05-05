<!DOCTYPE html>
<html lang="es">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="msapplication-TileImage" content="{{ asset('images/favicon.png') }}" />
        <title>G.A.R.G.CH. | Home</title>
        <link rel="icon" type="image/png" sizes="18x18" href="{{ asset('logos/logo2.png') }}">
        <link rel="stylesheet" href="{{ asset('fonts/poppins.css') }}">
        <link rel="stylesheet" href="{{ asset('dataTable/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dataTable/css/responsive.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/font-awesome_6.0/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.css') }}">
        <link rel="stylesheet" href="{{ asset('css/styles/font-verdana.css') }}">
        <link rel="stylesheet" href="{{ asset('css/select2/select2.css') }}">
        <link rel="stylesheet" href="{{ asset('css/select2/select2-bootstrap4.css') }}">
        <link rel="stylesheet" href="{{ asset('css/treeview/style.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/lobibox/lobibox.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datepicker/datepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/tooltips/tooltips.min.css') }}">
        <link rel="stylesheet" href="{{ asset('js/datepicker/themes/jquery-ui.css') }}">
        <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
        <style>
            body, .form-control, .form-label, textarea, button {
                font-family: 'Poppins', sans-serif;
                font-size: 14px;
            }

            .btn-size {
                font-size: 14px;
            }

            .title-size {
                font-size: 12px;
            }

            .form-label{
                font-weight: 500 !important;
            }

            .row-btn-verification, .form-verification {
                display: none;
            }
        </style>
        @yield('styles')
    </head>
    @include('layouts.modal.alerta')
    @include('layouts.modal.confirmar')
    @include('layouts.modal.no-confirmar')
    @include('layouts.modal.confirmar_compra')
    <body class="sidebar-mini layout-fixed layout-navbar-fixed sidebar-collapse">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-widget="pushmenu"><i class="fa fa-bars"></i></a>
                    </li>
                    {{-- Aqui se puede aumentar aparece al lado del ___Menu--}}
                </ul>
                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Notifications Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            {{-- ucwords(strtolower(Auth::user()->username)) }} - {{ ucwords(strtolower(Auth::user()->name)) --}} &nbsp;&nbsp;<i class="fa fa-cog fa-fw mr-2"></i>
                            dilson
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('logout') }}" class="dropdown-item btn-size" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out mr-1"></i>Cerrar Sesión
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="{{--route('dashboard')--}}" class="brand-link">
                    <span style="opacity: .8">
                        &nbsp;&nbsp;&nbsp;<i class="fa fa-user fa-fw"></i>
                    <span>
                    <span class="brand-text font-weight-light title-size">{{ Auth()->user()->nombre_completo }}</span>
                </a>
                <div class="sidebar">
                    <div class="user-panel mt-2 pb-2 mb-2 d-flex justify-content-center align-items-center">
                        <div class="info btn-block text-center">
                            <a href="#" class="d-block text-uppercase">
                                <span class="">
                                    <i class="fa fa-briefcase"></i>&nbsp;{{ auth()->user()->name }}
                                </span>
                            </a>
                        </div>
                    </div>
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item has-treeview">
                                <a href="{{ route('empleado.mi.perfil') }}" class="nav-link">
                                    <i class="nav-icon fas fa-users-cog fa-fw"></i>&nbsp;<p>Mi Perfil</p>
                                </a>
                            </li>

                            @can('agenda.ejecutiva.index')
                                <li class="nav-item has-treeview">
                                    <a href="{{ route('agenda.ejecutiva.index') }}" class="nav-link">
                                        <i class="nav-icon fa-sharp fa-solid fa-calendar fa-fw"></i>&nbsp;<p>Agenda ejecutiva</p>
                                    </a>
                                </li>
                            @endcan

                            @canany(['users.index','roles.index','permissions.index'])
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa-solid fa-gear fa-fw"></i><p>Configuracion<i class="right fa fa-angle-left"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('users.index')
                                            <li class="nav-item">
                                                <a href="{{ route('users.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa fa-users fa-fw"></i> <p>Usuarios</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('roles.index')
                                            <li class="nav-item">
                                                <a href="{{ route('roles.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-list fa-fw"></i> <p>Roles</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('permissions.index')
                                            <li class="nav-item">
                                                <a href="{{ route('permissions.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-layer-group fa-fw"></i> <p>Permisos</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany

                            @canany(['control.interno.index','mantenimientos.index','facebook.index','archivos.index.general'])
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa-solid fa-gear fa-fw"></i><p>Unidad de Sistemas<i class="right fa fa-angle-left"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('control.interno.index')
                                            <li class="nav-item">
                                                <a href="{{ route('control.interno.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa fa-envelope fa-fw"></i> <p>Control Interno</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('mantenimientos.index')
                                            <li class="nav-item">
                                                <a href="{{ route('mantenimientos.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-tools fa-fw"></i> <p>Mantenimientos</p>
                                                </a>
                                            </li>
                                        @endcan
                                        {{--@can('archivos.index.general')
                                            <li class="nav-item">
                                                <a href="{{ route('archivos.index.general') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-file fa-fw"></i> <p>Archivos Digitales</p>
                                                </a>
                                            </li>
                                        @endcan--}}
                                        @can('facebook.index')
                                            <li class="nav-item">
                                                <a href="{{ route('facebook.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-brands fa-twitter fa-fw"></i> <p>Redes Sociales</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany

                            @canany(['canasta.paquetes.index','canasta.beneficiarios.index','canasta.entregas.beneficiario.index','canasta.distritos.index','canasta.barrios.index','canasta.beneficiarios.brigadista.index'])
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa-solid fa-gift fa-fw"></i><p>Tercera Edad<i class="right fa fa-angle-left"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('reportes.canasta.index')
                                            <li class="nav-item">
                                                <a href="{{ route('reportes.canasta.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa fa-envelope fa-fw"></i> <p>Reportes</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('canasta.paquetes.index')
                                            <li class="nav-item">
                                                <a href="{{ route('paquetes.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-shopping-bag fa-fw"></i> <p>Paquetes</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('canasta.beneficiarios.index')
                                            <li class="nav-item">
                                                <a href="{{ route('beneficiarios.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fas fa-user-friends fa-fw"></i> <p>Beneficiarios</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('canasta.beneficiarios.brigadista.index')
                                            <li class="nav-item">
                                                <a href="{{ route('beneficiarios.brigadista.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fas fa-user-friends fa-fw"></i> <p>*Beneficiarios</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('canasta.entregas.beneficiario.index')
                                            <li class="nav-item">
                                                <a href="{{ route('entrega.beneficiario.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-search fa-fw"></i> <p>Buscar Entrega</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('canasta.distritos.index')
                                            <li class="nav-item">
                                                <a href="{{ route('distritos.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-house fa-fw"></i> <p>Distritos</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('canasta.barrios.index')
                                            <li class="nav-item">
                                                <a href="{{ route('barrios.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-house-crack fa-fw"></i> <p>Barrios</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('canasta.barrios.index')
                                            <li class="nav-item">
                                                <a href="{{ route('ocupacion.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-briefcase fa-fw"></i> <p>Profesion/Ocupacion</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany

                            @canany(['canastadisc.paquetes.index','salida.almacen.index','canasta.entregas.beneficiario.index'])
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa fa-wheelchair fa-fw"></i><p>Discapacidad<i class="right fa fa-angle-left"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('canastadisc.paquetes.index')
                                            <li class="nav-item">
                                                <a href="{{ route('paquetesdisc.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-shopping-bag fa-fw"></i> <p>Paquetes</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('canastadisc.beneficiarios.index')
                                            <li class="nav-item">
                                                <a href="{{ route('beneficiariosdisc.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fas fa-user-friends fa-fw"></i> <p>Beneficiarios</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('canasta.entregas.beneficiario.index')
                                            <li class="nav-item">
                                                <a href="{{ route('entrega.beneficiario.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-search fa-fw"></i> <p>Buscar</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany

                            {{-- SOLICITUD DE MATERIALES --}}
                            {{--@can('solicitud.compra.index')
                                <li class="font-verdana-13 counter">
                                    <a href="{{ route('solicitud.compra.index') }}">
                                        <i class="fas fa-shopping-basket fa-fw"></i>&nbsp;Solicitud de Compra
                                    </a>
                                </li>
                            @endcan
                            @can('orden.compra.index')
                                <li class="font-verdana-13 counter">
                                    <a href="{{ route('orden.compra.index') }}">
                                        <i class="fas fa-shopping-cart fa-fw"></i>&nbsp;Ordenes de compra
                                    </a>
                                </li>
                            @endcan
                            @can('solicitud.material.index')
                                <li class="font-verdana-13 counter">
                                    <a href="{{ route('solicitud.material.index') }}">
                                        <i class="fa-solid fa-marker fa-fw"></i>&nbsp;Solicitud de Materiales
                                    </a>
                                </li>
                            @endcan--}}

                            @canany(['almacen.index','ingreso.compra.index','salida.almacen.index','inventario.index','categoria.programatica.index','partida.presupuestaria.index','item.index','unidad.medida.index','proveedor.index'])
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa fa-shop fa-fw"></i><p>Almacenes<i class="right fa fa-angle-left"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('ingreso.compra.index')
                                            <li class="nav-item">
                                                <a href="{{ route('ingreso.compra.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-file-lines fa-fw"></i> <p>Ingreso de Materiales</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('salida.almacen.index')
                                            <li class="nav-item">
                                                <a href="{{ route('salida.almacen.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-hdd fa-fw"></i> <p>Salida de Materiales</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('inventario.index')
                                            <li class="nav-item">
                                                <a href="{{ route('inventario.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fas fa-warehouse fa-fw"></i> <p>Inventario</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('categoria.programatica.index')
                                            <li class="nav-item">
                                                <a href="{{ route('categoria.programatica.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-bars-staggered fa-fw"></i> <p>Categorias Programaticas</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('almacen.index')
                                            <li class="nav-item">
                                                <a href="{{ route('almacen.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-list-alt fa-fw"></i> <p>Gestionar</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('partida.presupuestaria.index')
                                            <li class="nav-item">
                                                <a href="{{ route('partida.presupuestaria.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-list-ul fa-fw"></i> <p>Partidas Presupuestarias</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('item.index')
                                            <li class="nav-item">
                                                <a href="{{ route('item.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-list-check fa-fw"></i> <p>Items</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('unidad.medida.index')
                                            <li class="nav-item">
                                                <a href="{{ route('unidad.medida.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fas fa-balance-scale fa-fw"></i> <p>Unidades de Medida</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('proveedor.index')
                                            <li class="nav-item">
                                                <a href="{{ route('proveedor.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-users fa-fw"></i> <p>Proveedores</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany

                            @can('personerias.index')
                                <li class="nav-item has-treeview">
                                    <a href="{{ route('personerias.index') }}" class="nav-link">
                                        <i class="nav-icon fa-duotone fa-book-user fa-fw"></i>&nbsp;<p>SI.RE.PE.JU.</p>
                                    </a>
                                </li>
                            @endcan

                            @canany(['sereges.registro_index'])
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa-duotone fa-book-user fa-fw"></i><p>SEREGES<i class="right fa fa-angle-left"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('sereges.registro_index')
                                            <li class="nav-item">
                                                <a href="{{ route('sereges.registro_index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-file-lines fa-fw"></i> <p>Registro</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('sereges.registro_index')
                                            <li class="nav-item">
                                                <a href="{{ route('sereges.albergue_index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-hdd fa-fw"></i> <p>Albergue-Hogar</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany

                            @can('informatica.registro_index')
                                <li class="nav-item has-treeview">
                                    <a href="{{ route('informatica.registro_index') }}" class="nav-link">
                                        <i class="nav-icon fa-duotone fa-book-user fa-fw"></i>&nbsp;<p>Registro</p>
                                    </a>
                                </li>
                            @endcan

                            @canany(['agenda.ej.index'])
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa-solid fa-calendar fa-fw"></i><p>Agenda<i class="right fa fa-angle-left"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('agenda.ej.index')
                                            <li class="nav-item">
                                                <a href="{{ route('agenda.ej.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-file-lines fa-fw"></i> <p>Ejecutivo</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('agenda.ej.index')
                                            <li class="nav-item">
                                                <a href="{{ asset('/Evento2/index/') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-file-lines fa-fw"></i> <p>Institucional</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('agenda.ej.index')
                                            <li class="nav-item">
                                                <a href="{{ asset('facebook') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-file-lines fa-fw"></i> <p>Facebook</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany

                            {{--@can('combustibles.pedidoparcial.index')
                                <li class="font-verdana-13">
                                    <a href="" data-toggle="collapse" data-target="#dashboard_combustiblescomb" class="active collapsed" aria-expanded="false">
                                        <i class="fa fa-shopping-cart" style="color:green"></i>
                                        <span class="nav-label mr-3">COMBUSTIBLES</span>
                                        <span class="fa fa-arrow-circle-left float-right"></span>
                                    </a>
                                    <ul class="sub-menu collapse" id="dashboard_combustiblescomb">
                                        <li>
                                            <a href="{{ route('combustibles.pedidoparcial.index') }}">
                                                &nbsp; &nbsp; &nbsp;
                                                <span class="nav-label mr-4">Solicitud de Combustible</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('combustibles.pedido.index') }}">
                                                &nbsp; &nbsp; &nbsp;
                                                <span class="nav-label mr-4">Combustible Solicitados</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('partidacomb.index') }}">
                                                &nbsp; &nbsp; &nbsp;
                                                <span class="nav-label mr-4">Partidas</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('producto.index') }}">
                                                &nbsp; &nbsp; &nbsp;
                                                <span class="nav-label mr-4">Productos-Items</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('proveedor.index') }}">
                                                &nbsp; &nbsp; &nbsp;
                                                <span class="nav-label mr-4">Proveedores</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('catprogcomb.index') }}">
                                                &nbsp; &nbsp; &nbsp;
                                                <span class="nav-label mr-4">Categ. Programaticas</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('combustibles.pedido.index2') }}">
                                                &nbsp; &nbsp; &nbsp;
                                                <span class="nav-label mr-4">Compras Aprovadas</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <hr style="margin-top:0; margin-bottom:0;">
                            @endcan--}}

                            {{--@can('almacenes.ingreso.index')
                                <li class="font-verdana-13">
                                    <a href="" data-toggle="collapse" data-target="#dashboard_almacen"
                                        class="active collapsed" aria-expanded="false">
                                        <i class="fa fa-th-list" style="color:green"></i>
                                        <span class="nav-label mr-3">ALMACEN</span>
                                        <span class="fa fa-arrow-circle-left float-right"></span>
                                    </a>
                                    <ul class="sub-menu collapse" id="dashboard_almacen">
                                        <li>
                                            <a href="{{ route('almacenes.ingreso.index') }}">
                                                &nbsp; &nbsp; &nbsp;
                                                <span class="nav-label mr-4">Ingreso.</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="sub-menu collapse" id="dashboard_almacen">
                                        <li>
                                            <a href="{{ route('almacenes.ingreso.grafico') }}">
                                                &nbsp; &nbsp; &nbsp;
                                                <span class="nav-label mr-4">Grafico.</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="sub-menu collapse" id="dashboard_almacen">
                                        <li>
                                            <a href="{{ route('almacenes.pedido.index') }}">
                                                &nbsp; &nbsp; &nbsp;
                                                <span class="nav-label mr-4">Solicitudes Pend.</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="sub-menu collapse" id="dashboard_almacen">
                                        <li>
                                            <a href="{{ route('almacenes.reporte.index') }}">
                                                &nbsp; &nbsp; &nbsp;
                                                <span class="nav-label mr-4">Reporte.</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="sub-menu collapse" id="dashboard_almacen">
                                        <li>
                                            <a href="{{ route('almacenes.reporte.index2') }}">
                                                &nbsp; &nbsp; &nbsp;
                                                <span class="nav-label mr-4">Reporte por fecha.</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="sub-menu collapse" id="dashboard_almacen">
                                        <li>
                                            <a href="{{ route('localidad.index') }}">
                                                &nbsp; &nbsp; &nbsp;
                                                <span class="nav-label mr-4">Localidad</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <hr style="margin-top:0; margin-bottom:0;">
                            @endcan--}}

                            {{--@can('transportes.pedidoparcial.index')
                                <li class="font-verdana-13">
                                    <a href="" data-toggle="collapse" data-target="#dashboard_transportes" class="active collapsed" aria-expanded="false">
                                        <i class="fa fa-th-list" style="color:green"></i>
                                        <span class="nav-label mr-3">Transporte</span>
                                        <span class="fa fa-arrow-circle-left float-right"></span>
                                    </a>
                                    <ul class="sub-menu collapse" id="dashboard_transportes">
                                        <li>
                                            <a href="{{ route('transportes.pedidoparcial.index') }}">
                                                &nbsp;<i class="fa fa-data base"></i>
                                                <span class="nav-label mr-4">Solicitud</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('transportes.pedido.index3') }}">
                                                &nbsp;<i class="fa fa-data base"></i>
                                                <span class="nav-label mr-4">Por aprovar</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('transportes.pedido.index') }}">
                                                &nbsp;<i class="fa fa-data base"></i>
                                                <span class="nav-label mr-4">Pendientes</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('transportes.uconsumo.index') }}">
                                                &nbsp;<i class="fa fa-data base"></i>
                                                <span class="nav-label mr-4">vehiculo</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('tipo.index') }}">
                                                &nbsp;<i class="fa fa-data base"></i>
                                                <span class="nav-label mr-4">Tipo</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <hr style="margin-top:0; margin-bottom:0;">
                            @endcan--}}

                            @canany(['correspondencia_local.index','correspondencia_local.remitente.index','correspondencia_local.unidad.index','correspondencia.index'])
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa-solid fa-gift fa-fw"></i><p>Correspondencia<i class="right fa fa-angle-left"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('correspondencia_local.index')
                                            <li class="nav-item">
                                                <a href="{{ route('correspondencia.local.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-shopping-bag fa-fw"></i> <p>Ventanilla</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('correspondencia_local.index')
                                            <li class="nav-item">
                                                <a href="{{ route('correspondencia.derivada.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-file-lines fa-fw"></i> <p>Corresp. Derivada</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('correspondencia_local.remitente.index')
                                            <li class="nav-item">
                                                <a href="{{ route('correspondencia.local.remitente.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa-solid fa-users fa-fw"></i> <p>Remitentes</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('correspondencia_local.unidad.index')
                                            <li class="nav-item">
                                                <a href="{{ route('correspondencia.local.unidadIndex') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fas fa-house-damage fa-fw"></i> <p>Areas</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('correspondencia.index')
                                            <li class="nav-item">
                                                <a href="{{ route('correspondencia.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fa fa-folder fa-fw"></i> <p>Correspondencia Anterior</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany

                            {{-- @canany(['correspondencia_local.index','correspondencia_local.remitente.index','correspondencia_local.unidad.index','correspondencia.index'])
                                <li class="font-verdana-13 counter">
                                    <a href="" data-toggle="collapse" data-target="#dashboard_correspondencia" class="active collapsed" aria-expanded="false">
                                        <i class="fa-solid fa-gift fa-fw"></i>&nbsp;Correspondencia
                                        <span class="fa-solid fa-chevron-left float-right fa-fw"></span>
                                    </a>
                                    <ul class="sub-menu collapse" id="dashboard_correspondencia">
                                        @can('correspondencia_local.index')
                                            <li>
                                                <a href="{{ route('correspondencia.local.index') }}">
                                                    &nbsp;&nbsp;<i class="fa-solid fa-shopping-bag fa-fw"></i>&nbsp;Ventanilla
                                                </a>
                                            </li>
                                        @endcan
                                        @can('correspondencia_local.remitente.index')
                                            <li>
                                                <a href="{{ route('correspondencia.local.remitente.index') }}">
                                                    &nbsp;&nbsp;<i class="fa-solid fa-users fa-fw"></i>&nbsp;Remitentes
                                                </a>
                                            </li>
                                        @endcan
                                        @can('correspondencia_local.unidad.index')
                                            <li>
                                                <a href="{{ route('correspondencia.local.unidadIndex') }}">
                                                    &nbsp;&nbsp;<i class="fas fa-house-damage fa-fw"></i>&nbsp;Areas
                                                </a>
                                            </li>
                                        @endcan
                                        @can('correspondencia.index')
                                            <li>
                                                <a href="{{ route('correspondencia.index') }}">
                                                    &nbsp;&nbsp;<i class="fa fa-folder fa-fw"></i>&nbsp;Correspondencia Anterior
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany --}}

                            @can('derivacion.index')
                                <li class="nav-item has-treeview">
                                    <a href="{{ route('derivacion.index') }}" class="nav-link">
                                        <i class="nav-icon fa-duotone fa-book-user fa-fw"></i>&nbsp;<p>Acceder</p>
                                    </a>
                                </li>
                            @endcan

                            @canany(['archivos.index','tipos.archivos.index','archivos.index.general'])
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-file fa-fw"></i><p>Archivos Digitales<i class="right fa fa-angle-left"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('archivos.index')
                                            <li class="nav-item">
                                                <a href="{{ route('archivos.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fas fa-file fa-fw"></i> <p>Listar</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('tipos.archivos.index')
                                            <li class="nav-item">
                                                <a href="{{ route('tipos.archivos.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fas fa-file fa-fw"></i> <p>Tipos</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany

                            @canany(['empleados.index','areas.index'])
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-users fa-fw"></i><p>Recursos Humanos<i class="right fa fa-angle-left"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('empleados.index')
                                            <li class="nav-item">
                                                <a href="{{ route('empleado.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fas fa-user-friends fa-fw"></i> <p>Personal</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('files.index')
                                            <li class="nav-item">
                                                <a href="{{ route('file.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fas fa-id-card fa-fw"></i> <p>Cargos</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('areas.index')
                                            <li class="nav-item">
                                                <a href="{{ route('area.index') }}" class="nav-link pl-4">&nbsp;
                                                    <i class="fas fa-sitemap fa-fw"></i> <p>Organigrama</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany

                            {{--@can('activos.index')
                                <li class="font-verdana-13">
                                    <a href="" data-toggle="collapse" data-target="#dashboard_personeria" class="active collapsed" aria-expanded="false">
                                        <i class="fa fa-file-text" style="color:green"></i>
                                        <span class="nav-label mr-3">PERSONERIAS</span>
                                        <span class="fa fa-arrow-circle-left float-right"></span>
                                    </a>
                                    <ul class="sub-menu collapse" id="dashboard_personeria"
                                        @if (request()->is('users') || request()->is('users/*')) in @endif>
                                        <li>
                                            <a href="{{ route('activos.index') }}">
                                                &nbsp; &nbsp; &nbsp;
                                                <span class="nav-label mr-4">Personerias</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <hr style="margin-top:0; margin-bottom:0;">
                            @endcan--}}

                            {{--@can('unidadadmin_access')
                                <li class="font-verdana-13">
                                    <a href="" data-toggle="collapse" data-target="#dashboard_activos_fijos" class="active collapsed" aria-expanded="false">
                                        <i class="fa fa-users" style="color:green"></i>
                                        <span class="nav-label mr-3">ACTIVOS FIJOS</span>
                                        <span class="fa fa-arrow-circle-left float-right"></span>
                                    </a>
                                    <ul class="sub-menu collapse" id="dashboard_activos_fijos"
                                        @if (request()->is('admin/users') || request()->is('admin/users/*')) in @endif>
                                        <a href="" data-toggle="collapse" data-target="#activos__fijjos" class="active collapsed" aria-expanded="false">
                                            <i class="fa fa-users"></i>
                                            <span class="nav-label mr-3">Gestiónar</span>
                                            <span class="fa fa-arrow-circle-left float-right"></span>
                                        </a>
                                        <ul class="sub-menu collapse" id="activos__fijjos">
                                            @can('unidadadmin_access')
                                                <li>
                                                    <a href="{{ route('activo.unidadadmin.index') }}">
                                                        &nbsp;<i class="fa fa-building"></i>
                                                        <span class="nav-label mr-4"> unidad administrativa</span>
                                                    </a>

                                                </li>
                                            @endcan
                                            @can('organismo_access')
                                                <li>
                                                    <a href="{{ route('activo.organismo.index') }}">
                                                        &nbsp;<i class="fa fa-building"></i>
                                                        <span class="nav-label mr-4"> Organismo Financiero</span>
                                                    </a>
                                                </li>
                                            @endcan
                                                <li>
                                                    <a href="{{ route('activo.codcont.index') }}">
                                                        &nbsp;<i class="fas fa-money-check-alt"></i>
                                                        <span class="nav-label mr-4"> Grupo Contable</span>
                                                    </a>

                                                </li>


                                                <li>
                                                    <a href="{{ route('activo.gestionactivo.index') }}">
                                                        &nbsp;<i class="fa fa-database"></i>
                                                        <span class="nav-label mr-4"> Listado </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('oficina.index') }}">
                                                        &nbsp;<i class="fa fa-building"></i>
                                                        <span class="nav-label mr-4"> Oficinas y Responsables</span>
                                                    </a>
                                                </li>
                                        </ul>
                                        <li>
                                            <a href="{{ route('activo.vehiculo.index') }}">
                                                &nbsp;<i class="fa fa-database"></i>
                                                <span class="nav-label mr-4">Parque Automotor</span>
                                            </a>
                                        </li>
                                        <a href="" data-toggle="collapse" data-target="#sub_reportes" class="active collapsed" aria-expanded="false">
                                            <i class="fa fa-users"></i>
                                            <span class="nav-label mr-3">Reportes</span>
                                            <span class="fa fa-arrow-circle-left float-right"></span>
                                        </a>
                                        <ul class="sub-menu collapse" id="sub_reportes">
                                            <li>
                                                <li>
                                                    <a href="{{ route('activo.formulario.index') }}">
                                                        &nbsp;<i class="fa fa-database"></i>
                                                        <span class="nav-label mr-4">Formulario de Inventario Físico</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('activo.adeudo.index') }}">
                                                        &nbsp;<i class="fa fa-database"></i>
                                                        <span class="nav-label mr-4">No Adeudo</span>
                                                    </a>
                                                </li>
                                            </li>
                                            <a href="javascript:void(0)" onclick="$('#logout-form').submit();" class="dropdown-item">
                                                <i class="fa fa-sign-out" aria-hidden="true" style="color:red"></i>
                                                <span class="font-verdana-13" style="color:red;">Cerrar Sesion</span>
                                            </a>
                                        </ul>
                                    </ul>
                                </li>
                            @endcan--}}
                        </ul>
                    </nav>
                </div>
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row">
                            {{--<div class="col-sm-6">
                                <h4 class="m-0 text-dark">
                                    @yield('page_title')
                                </h4>
                            </div>--}}
                            <div class="col-sm-12">
                                <ol class="breadcrumb float-sm-right">
                                    @section('breadcrumb')
                                    @show
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        @if(View::hasSection('content'))
                            @yield('content')
                        @else
                            @if (!auth()->user()->hasRole('verificador'))
                                @include('layouts.content.index')
                            @endif
                        @endif
                    </div><!-- /.container-fluid -->
                </div>
            </div>
            <!-- /.content-wrapper -->
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
                <div class="p-3">
                    <form action="{{route('logout')}}" method="POST" id="form_id">
                        @csrf
                        <button class="btn btn-danger" type="submit">Cerrar sesión</button>
                    </form>
                </div>
            </aside>
            <!-- /.control-sidebar -->

            <!-- Main Footer -->
            <footer class="main-footer ">
                <!-- To the right -->
                <div class="float-right d-none d-sm-inline">
                    cc
                </div>
                <!-- Default to the left -->
                <strong>Copyright &copy; {{ date('Y') }} <a href="https://vacapurpura.com" target="_blank">vacapurpura.com</a>.</strong> Todos los derechos reservados.
            </footer>
        </div>

        <script src="{{ asset('dataTable/js/jquery-3.5.1.js') }}"></script>
        <script src="{{ asset('dataTable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('dataTable/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('dataTable/js/datatable-language.js') }}"></script>
        <script src="{{ asset('js/toastr.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('js/lobibox/lobibox.js') }}"></script>
        <script src="{{ asset('js/datepicker/datepicker.min.js') }}"></script>
        <script src="{{ asset('js/datepicker/datepicker.es.js') }}"></script>
        <script src="{{ asset('js/cleave/cleave.min.js') }}"></script>
        <script src="{{ asset('js/cleave/addons/cleave-phone.us.js') }}"></script>
        <script src="{{ asset('js/sweetalert2@9.js') }}"></script>
        <script src="{{ asset('js/chart.js') }}"></script>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.7.5/proj4.js"></script>

        @yield('scripts')

        <script src="{{ asset('js/select2/select2.min.js') }}"></script>
        <script src="{{ asset('js/treeview/jstree.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('#menu_dashboard').select2({
                    theme: "bootstrap4",
                    placeholder: "--Seleccionar--",
                    width: '100%'
                });
            });

            function obtenerMontoCleave(montoString) {
                if(montoString == ""){
                    return 0;
                }else{
                    var re = /,/g;
                    var resultado = montoString.replace(re, '');
                    monto = parseFloat(resultado);
                }
                return monto;
            }
        </script>
    </body>
</html>

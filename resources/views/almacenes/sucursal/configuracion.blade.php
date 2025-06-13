@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Configuracion de datos de almacen</li>
@endsection
@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <div class="row d-flex align-items-center">
                <i class="fa-solid fa-gear fa-fw"></i>&nbsp;<b class="title-size fs-4">CONFIGURACION ALMACENES</b>
            </div>
        </div>

        <div class="card-body">
            <div class="container my-4">
                <div class="d-flex flex-column gap-4">
                    {{--@can('sucursal.index')
                        <button type="button"
                                class="btn btn-outline-dark mb-1 d-flex justify-content-between align-items-center fs-5 py-1 rounded shadow-sm"
                                onclick="window.location.href='{{ route('sucursal.index') }}'">
                            Sucursales
                            <span class="badge bg-dark text-primary rounded-pill fs-5 p-3">
                                <i class="fa-solid fa-house fa-fw"></i>
                            </span>
                        </button>
                    @endcan--}}

                    @can('partida.presupuestaria.index')
                        <button type="button"
                                class="btn btn-outline-dark mb-1 d-flex justify-content-between align-items-center fs-5 py-1 rounded shadow-sm"
                                onclick="window.location.href='{{ route('partida.presupuestaria.index') }}'">
                            Partidas Presupuestarias
                            <span class="badge bg-dark text-primary rounded-pill fs-5 p-3">
                                <i class="fa-solid fa-list-ul fa-fw"></i>
                            </span>
                        </button>
                    @endcan

                    @can('producto.index')
                        <button type="button"
                                class="btn btn-outline-dark mb-1 d-flex justify-content-between align-items-center fs-5 py-1 rounded shadow-sm"
                                onclick="window.location.href='{{ route('producto.index') }}'">
                            Materiales
                            <span class="badge bg-dark text-primary rounded-pill fs-5 p-3">
                                <i class="fas fa-tags fa-fw"></i>
                            </span>
                        </button>
                    @endcan

                    @can('unidad.medida.index')
                        <button type="button"
                                class="btn btn-outline-dark mb-1 d-flex justify-content-between align-items-center fs-5 py-1 rounded shadow-sm"
                                onclick="window.location.href='{{ route('unidad.medida.index') }}'">
                            Unidades de medida
                            <span class="badge bg-dark text-primary rounded-pill fs-5 p-3">
                                <i class="fas fa-balance-scale fa-fw"></i>
                            </span>
                        </button>
                    @endcan

                    {{--@can('proveedor.index')
                        <button type="button"
                                class="btn btn-outline-dark mb-1 d-flex justify-content-between align-items-center fs-5 py-1 rounded shadow-sm"
                                onclick="window.location.href='{{ route('proveedor.index') }}'">
                            Proveedores
                            <span class="badge bg-dark text-primary rounded-pill fs-5 p-3">
                                <i class="fa-solid fa-users fa-fw"></i>
                            </span>
                        </button>
                    @endcan--}}

                    {{--@can('categoria.programatica.index')
                        <button type="button"
                                class="btn btn-outline-dark mb-1 d-flex justify-content-between align-items-center fs-5 py-1 rounded shadow-sm"
                                onclick="window.location.href='{{ route('categoria.programatica.index') }}'">
                            Categorias Programaticas
                            <span class="badge bg-dark text-primary rounded-pill fs-5 p-3">
                                <i class="fa-solid fa-bars-staggered fa-fw"></i>
                            </span>
                        </button>
                    @endcan--}}
                </div>
            </div>
        </div>
    </div>
@endsection

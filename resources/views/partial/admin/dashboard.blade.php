<aside class="sidebar">
    <div class="toggle">
        <a href="#" class="burger js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
            <span></span>
        </a>
    </div>
    <div class="side-inner">
        <div class="profile">
            <img src="{{ asset('logos/logo2.png') }}" alt="Image" class="img-fluid"/>
            <span class="name font-verdana" style="color:green">S.A.I. - G.A.R.G.CH.</span>
            {{--<span class="country" style="color:green">Yacuiba - Carapari - Villamontes</span>--}}
            <a href="javascript:void(0)" onclick="$('#logout-form').submit();" class="dropdown-item">
                <i class="fa fa-sign-out" aria-hidden="true" style="color:red"></i>
                <span class="font-verdana-bg" style="color:red;">Cerrar Sesion</span>
            </a>
        </div>
        <div class="nav-menu">
            <div class="sidebar left">
                <ul class="list-sidebar bg-defoult">
                    {{--COMPRAS--}}
                    @canany(['compras_panel_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_compras" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="nav-label mr-3">Compras</span>
                                <span class="fa fa-chevron-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_compras">
                                @can('compras_panel_access')
                                    <li>
                                        <a href="{{ route('compras.pedidoparcial.index') }}">
                                            &nbsp;<i class="fa fa-list" aria-hidden="true"></i>
                                            <span class="nav-label mr-4">Solicitudes de Compra</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('compras_panel_access')
                                    <li>
                                        <a href="{{ route('compras.pedido.index') }}">
                                            &nbsp;<i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                            <span class="nav-label mr-4">Compras Solicitadas</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('medidas_access')
                                    <li>
                                        <a href="{{ route('medidas.index') }}">
                                            &nbsp;<i class="fa fa-sitemap" aria-hidden="true"></i>
                                            <span class="nav-label mr-4">Medidas</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('partidas_access')
                                    <li>
                                        <a href="{{ route('partida.index') }}">
                                            &nbsp;<i class="fa fa-briefcase" aria-hidden="true"></i>
                                            <span class="nav-label mr-4">Partidas</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('productos_access')
                                    <li>
                                        <a href="{{ route('productos.index') }}">
                                            &nbsp;<i class="fa fa-suitcase" aria-hidden="true"></i>
                                            <span class="nav-label mr-4">Productos-Items</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('proveedores_access')
                                    <li>
                                        <a href="{{ route('proveedores.index') }}">
                                            &nbsp;<i class="fa fa-users" aria-hidden="true"></i>
                                            <span class="nav-label mr-4">Proveedores</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('programas_access')
                                    <li>
                                        <a href="{{ route('programas.index') }}">
                                            &nbsp;<i class="fa fa-cogs" aria-hidden="true"></i>
                                            <span class="nav-label mr-4">Programas</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('catprog_access')
                                    <li>
                                        <a href="{{ route('catprog.index') }}">
                                            &nbsp;<i class="fa fa-map-signs" aria-hidden="true"></i>
                                            <span class="nav-label mr-4">Categ. Programaticas</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    @canany(['archivos_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_archivos2" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-folder-open"></i>
                                <span class="nav-label mr-3">Archivos</span>
                                <span class="fa fa-chevron-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_archivos2">
                                @can('archivos_access')
                                    <li>
                                        <a href="{{ route('archivos2.index') }}">
                                            &nbsp; <i class="fa fa-file-pdf"></i>
                                            <span class="nav-label mr-4">Listar</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    {{--RRHH--}}
                    @canany(['recHumanos_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_rrhh" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-users"></i>
                                <span class="nav-label mr-3">Recursos Humanos</span>
                                <span class="fa fa-chevron-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_rrhh">
                                @can('areas_access')
                                    <li>
                                        <a href="{{ route('areas.index') }}">
                                            &nbsp;<i class="fa fa-database"></i>
                                            <span class="nav-label mr-4">Areas-Files</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('planta_access')
                                    <li>
                                        <a href="{{ route('planta.index') }}">
                                            &nbsp;<i class="fa fa-id-badge"></i>
                                            <span class="nav-label mr-4">Gestionar Personal-P</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('planta_access')
                                    <li>
                                        <a href="{{ route('planta.listageneral') }}">
                                            &nbsp;<i class="fa fa-file"></i>
                                            <span class="nav-label mr-4">Lista Gral. Planta</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('personal_contrato_access')
                                    <li>
                                        <a href="{{ route('contrato.index') }}">
                                            &nbsp;<i class="fa fa-user-circle"></i>
                                            <span class="nav-label mr-4">Personal Contrato</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('personal_contrato_access')
                                    <li>
                                        <a href="{{ route('contrato.listageneral') }}">
                                            &nbsp;<i class="fa fa-file"></i>
                                            <span class="nav-label mr-4">Lista Gral. Contrato</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    {{--Activos Fijos--}}
                    @canany(['recHumanos_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_activos_fijos" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-file-text"></i>
                                <span class="nav-label mr-3">Personerias</span>
                                <span class="fa fa-chevron-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_activos_fijos" @if(request()->is('admin/users') || request()->is('admin/users/*')) in @endif ">
                                @can('areas_access')
                                    <li>
                                        <a href="{{ route('activos.index') }}">
                                            &nbsp;<i class="fa fa-clipboard"></i>
                                            <span class="nav-label mr-4">Personerias</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    {{--Activos Fijos--}}
                    @canany(['recHumanos_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_activos_fijos" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-circle"></i>
                                <span class="nav-label mr-3">Activos Fijos</span>
                                <span class="fa fa-chevron-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_activos_fijos" @if(request()->is('admin/users') || request()->is('admin/users/*')) in @endif ">
                                @can('areas_access')
                                    <li>
                                        <a href="{{ route('activos.index') }}">
                                            &nbsp;<i class="fa fa-database"></i>
                                            <span class="nav-label mr-4">Activos</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    {{--Usuarios--}}
                    @canany(['users_access','roles_access','permissions_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_users" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-users"></i>
                                <span class="nav-label mr-3">Usuarios</span>
                                <span class="fa fa-chevron-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_users">
                                @can('users_access')
                                    <li>
                                        <a href="{{ route('admin.users.index') }}">
                                            &nbsp;<i class="fa fa-user"></i>
                                            <span class="nav-label mr-4">Usuarios</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('roles_access')
                                    <li>
                                        <a href="{{ route('admin.roles.index') }}">
                                            &nbsp;<i class="fa fa-user-secret"></i>
                                            <span class="nav-label mr-4">Roles</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('permissions_access')
                                    <li>
                                        <a href="{{ route('admin.permissions.index') }}">
                                            &nbsp;<i class="fa fa-user-plus"></i>
                                            <span class="nav-label mr-4">Permisos</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    {{--Discapacidad--}}
                    @canany(['discapacidad_panel_acess'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_discapacidad" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-users"></i>
                                <span class="nav-label mr-3">Discapacidad</span>
                                <span class="fa fa-chevron-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_discapacidad">
                                @can('entregas_acess')
                                    <li>
                                        <a href="{{ route('canasta.entrega.index') }}">
                                            &nbsp;<i class="fa fa-user"></i>
                                            <span class="nav-label mr-4"></span>Listar Entregas
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('canasta.pendientes.index') }}">
                                            &nbsp;<i class="fa fa-user"></i>
                                            <span class="nav-label mr-4"></span>Pendientes
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    {{--Activos--}}
                    @canany(['activos_panel_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_activosvsiaf" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-users"></i>
                                <span class="nav-label mr-3">Activos</span>
                                <span class="fa fa-chevron-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_activosvsiaf">
                                @can('activos_listar')
                                    <li>
                                        <a href="{{ route('activos.vsiaf.index') }}">
                                            <i class="fa fa-user"></i>
                                            <span class="nav-label mr-4"></span>Listar
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                </ul>
            </div>
        </div>
    </div>
</aside>

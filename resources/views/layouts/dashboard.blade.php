<aside class="sidebar">
    <div class="toggle">
        <a href="#" class="burger js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
            <span></span>
        </a>
    </div>
    <div class="side-inner">
        <div class="profile">
            <img src="{{ asset('logos/logo2.png') }}" alt="Image" class="img-fluid">
            <h3 class="name" style="color:green">S.A.I. - G.A.R.G.CH.</h3>
            <span class="country" style="color:green">Yacuiba - Carapari - Villamontes</span>
       </P>
                <a href="javascript:void(0)" onclick="$('#logout-form').submit();" class="dropdown-item">
                    <i class="fa fa-sign-out" aria-hidden="true" style="color:red"></i>
                    <span  style="color:red;">Cerrar Sesion</span>

                </a>

        </div>
        <div class="nav-menu">
            <div class="sidebar left">
                <ul class="list-sidebar bg-defoult">
                    {{--COMPRAS--}}
                    @canany(['compras_panel_access'])
                        <li>
                            <a href="" data-toggle="collapse" data-target="#dashboard_compras" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-shopping-cart" style="color:blue;font-weight: bold;"></i>
                                <span class="nav-label mr-3 " style="color:blue;font-weight: bold;">Compras</span>
                                <span class="fa fa-chevron-left pull-right" style="color:red;font-weight: bold;"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_compras">
                                @can('compras_panel_access')
                                <li>
                                    <a href="{{ route('compras.pedidoparcial.index') }}">
                                        &nbsp;&nbsp; &nbsp;<i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        <span class="nav-label mr-4">Solicitud-Compra</span>
                                    </a>
                                </li>
                                @endcan

                                @can('compras_panel_access')
                                    <li>
                                        <a href="{{ route('compras.pedido.index') }}">
                                            &nbsp;&nbsp; &nbsp;<i class="fa fa-cart-arrow-down"></i>
                                            <span class="nav-label mr-4">Compras-Solicitadas</span>
                                        </a>
                                    </li>
                                @endcan


                                @can('medidas_access')
                                <li>
                                    <a href="{{ route('medidas.index') }}">
                                        &nbsp;&nbsp; &nbsp;<i class="fa fa-sitemap"></i>
                                        <span class="nav-label mr-4">Medidas</span>
                                    </a>
                                </li>
                            @endcan

                                @can('partidas_access')
                                    <li>
                                        <a href="{{ route('partida.index') }}">
                                            &nbsp;&nbsp; &nbsp; <i class="fa fa-briefcase"></i>
                                            <span class="nav-label mr-4">Partidas</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('productos_access')
                                    <li>
                                        <a href="{{ route('productos.index') }}">
                                            &nbsp;&nbsp; &nbsp;<i class="fa fa-suitcase"></i>
                                            <span class="nav-label mr-4">Productos-Items</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('proveedores_access')
                                    <li>
                                        <a href="{{ route('proveedores.index') }}">
                                            &nbsp;&nbsp; &nbsp; <i class="fa fa-users"></i>
                                            <span class="nav-label mr-4">Proveedores</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('programas_access')
                                    <li>
                                        <a href="{{ route('programas.index') }}">
                                            &nbsp;&nbsp; &nbsp;<i class="fa fa-cogs"></i>
                                            <span class="nav-label mr-4">Programas</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('catprog_access')
                                    <li>
                                        <a href="{{ route('catprog.index') }}">
                                            &nbsp;&nbsp; &nbsp;<i class="fa fa-map-signs"></i>
                                            <span class="nav-label mr-4">Cat.Programatica</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany




                    {{--RRHH--}}
                    @canany(['recHumanos_access'])
                        <li>
                            <a href="" data-toggle="collapse" data-target="#dashboard_rrhh" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-users" style="color:blue;font-weight: bold;"></i>
                                <span class="nav-label mr-3" style="color:blue;font-weight: bold;">Recursos Humanos</span>
                                <span class="fa fa-chevron-left pull-right" style="color:red;font-weight: bold;"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_rrhh">
                                @can('areas_access')
                                    <li>
                                        <a href="{{ route('areas.index') }}">
                                            &nbsp;&nbsp; &nbsp; <i class="fa fa-database"></i>
                                            <span class="nav-label mr-4">Areas-Files</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('planta_access')
                                    <li>
                                        <a href="{{ route('planta.index') }}">
                                            &nbsp;&nbsp; &nbsp;<i class="fa fa-id-badge"></i>
                                            <span class="nav-label mr-4">Personal Planta</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('planta_access')
                                    <li>
                                        <a href="{{ route('planta.listageneral') }}">
                                            &nbsp;&nbsp; &nbsp;<i class="fa fa-file"></i>
                                            <span class="nav-label mr-4">Lista Gral. Planta</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('personal_contrato_access')
                                    <li>
                                        <a href="{{ route('contrato.index') }}">
                                            &nbsp;&nbsp; &nbsp; <i class="fa fa-user-circle"></i>
                                            <span class="nav-label mr-4">Personal Contrato</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('personal_contrato_access')
                                    <li>
                                        <a href="{{ route('contrato.listageneral') }}">
                                            &nbsp;&nbsp; &nbsp; <i class="fa fa-file"></i>
                                            <span class="nav-label mr-4">Lista Gral. Contrato</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany




                    {{--Activos Fijos--}}
                    @canany(['recHumanos_access'])
                        <li>
                            <a href="" data-toggle="collapse" data-target="#dashboard_activos_fijos" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-circle" style="color:blue;font-weight: bold;"></i>
                                <span class="nav-label mr-3" style="color:blue;font-weight: bold;">Activos Fijos</span>
                                <span class="fa fa-chevron-left pull-right" style="color:red;font-weight: bold;"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_activos_fijos" @if(request()->is('admin/users') || request()->is('admin/users/*')) in @endif ">
                                @can('areas_access')
                                    <li>
                                        <a href="{{ route('activos.index') }}">
                                            &nbsp;&nbsp; &nbsp;<i class="fa fa-database"></i>
                                            <span class="nav-label mr-4">Activos</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany



                    {{--Usuarios--}}
                    @canany(['users_access','roles_access','permissions_access'])
                        <li>
                            <a href="" data-toggle="collapse" data-target="#dashboard_users" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-users" style="color:blue;font-weight: bold;"></i>
                                <span class="nav-label mr-3" style="color:blue;font-weight: bold;">Usuarios</span>
                                <span class="fa fa-chevron-left pull-right" style="color:red;font-weight: bold;"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_users">
                                @can('users_access')
                                    <li>
                                        <a href="{{ route('admin.users.index') }}">
                                            &nbsp;&nbsp; &nbsp;<i class="fa fa-user"></i>
                                            <span class="nav-label mr-4">Usuarios</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('roles_access')
                                    <li>
                                        <a href="{{ route('admin.roles.index') }}">
                                            &nbsp;&nbsp; &nbsp;<i class="fa fa-user-secret"></i>
                                            <span class="nav-label mr-4">Roles</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('permissions_access')
                                    <li>
                                        <a href="{{ route('admin.permissions.index') }}">
                                            &nbsp;&nbsp; &nbsp;<i class="fa fa-user-plus"></i>
                                            <span class="nav-label mr-4">Permisos</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany


                    {{--Discapacidad--}}
                    @canany(['discapacidad_panel_acess'])
                        <li>
                            <a href="" data-toggle="collapse" data-target="#dashboard_discapacidad" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-users" style="color:blue;font-weight: bold;"></i>
                                <span class="nav-label mr-3" style="color:blue;font-weight: bold;">Discapacidad</span>
                                <span class="fa fa-chevron-left pull-right" style="color:red;font-weight: bold;"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_discapacidad">
                                @can('entregas_acess')
                                    <li>
                                        <a href="{{ route('canasta.entrega.index') }}">
                                            &nbsp;&nbsp; &nbsp;  <i class="fa fa-user"></i>
                                            <span class="nav-label mr-4"></span>Listar Entregas
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('canasta.pendientes.index') }}">
                                            &nbsp;&nbsp; &nbsp;<i class="fa fa-user"></i>
                                            <span class="nav-label mr-4"></span>Pendientes
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany




                    {{--Activos--}}
                    @canany(['activos_panel_access'])
                    <li>
                        <a href="" data-toggle="collapse" data-target="#dashboard_activosvsiaf" class="active collapsed" aria-expanded="false">
                            <i class="fa fa-users" style="color:blue;font-weight: bold;"></i>
                            <span class="nav-label mr-3" style="color:blue;font-weight: bold;">Activos</span>
                            <span class="fa fa-chevron-left pull-right" style="color:red;font-weight: bold;"></span>
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

        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>


                        @can('admin_panel_access')
                        <!-- dashboard-->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin')) is_active @endif"
                                href="{{ route('admin.home') }}" aria-expanded="false">
                                <i class="fab fa-windows" aria-hidden="true"></i>
                                <span class="hide-menu" style="color:#55CE86;font-weight: bold;">MENU PRINCIPAL</span>
                            </a>
                        </li>
                        @endcan



                        @canany(['compras_panel_access'])
                        <li class="sidebar-item">

                            <a class="sidebar-link has-arrow waves-effect waves-dark selected" href="javascript:void(0)"
                                aria-expanded="false">

                                <i class="fa fa-cog" aria-hidden="true" style="color:red;"></i>
                                <span class="hide-menu" style="color:black;font-weight: bold;">COMPRAS</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level
                                @if(request()->is('admin/users') || request()->is('admin/users/*')) in @endif
                            ">
                                @can('medidas_access')
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/users') || request()->is('admin/users/*')) is_active @endif"
                                        href="{{ route('medidas.index') }}" aria-expanded="false">
                                        <i class="fa fa-sitemap" aria-hidden="true"></i>
                                        <span class="hide-menu" style="color:black;font-weight: bold;">Medidas</span>
                                    </a>
                                </li>
                                @endcan
                                @can('productos_access')
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/users') || request()->is('admin/users/*')) is_active @endif"
                                        href="{{ route('pedido.index') }}" aria-expanded="false">
                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                        <span class="hide-menu" style="color:black;font-weight: bold;">Compras</span>
                                    </a>
                                </li>
                                @endcan
                                @can('partidas_access')
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/users') || request()->is('admin/users/*')) is_active @endif"
                                        href="{{ route('partida.index') }}" aria-expanded="false">
                                        <i class="fa fa-briefcase" aria-hidden="true"></i>
                                        <span class="hide-menu" style="color:black;font-weight: bold;">Partidas</span>
                                    </a>
                                </li>
                                @endcan
                                @can('productos_access')
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/users') || request()->is('admin/users/*')) is_active @endif"
                                        href="{{ route('productos.index') }}" aria-expanded="false">
                                        <i class="fa fa-suitcase" aria-hidden="true"></i>
                                        <span class="hide-menu"
                                            style="color:black;font-weight: bold;">Productos-Items</span>
                                    </a>
                                </li>
                                @endcan


                                @can('proveedores_access')
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/users') || request()->is('admin/users/*')) is_active @endif"
                                        href="{{ route('proveedores.index') }}" aria-expanded="false">
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                        <span class="hide-menu"
                                            style="color:black;font-weight: bold;">Proveedores</span>
                                    </a>
                                </li>
                                @endcan



                                @can('programas_access')
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/users') || request()->is('admin/users/*')) is_active @endif"
                                        href="{{ route('programas.index') }}" aria-expanded="false">
                                        <i class="fa fa-cogs" aria-hidden="true"></i>
                                        <span class="hide-menu" style="color:black;font-weight: bold;">Programas</span>
                                    </a>
                                </li>
                                @endcan

                                @can('catprog_access')
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/users') || request()->is('admin/users/*')) is_active @endif"
                                        href="{{ route('catprog.index') }}" aria-expanded="false">
                                        <i class="fa fa-map-signs" aria-hidden="true"></i>
                                        <span class="hide-menu"
                                            style="color:black;font-weight: bold;">Cat.Programatica</span>
                                    </a>
                                </li>
                                @endcan


                            </ul>
                        </li>
                        @endcanany




                        @canany(['recHumanos_access'])
                        <li class="sidebar-item">

                            <a class="sidebar-link has-arrow waves-effect waves-dark selected" href="javascript:void(0)"
                                aria-expanded="false">

                                <i class="fas fa-users" aria-hidden="true" style="color:blue;"></i>
                                <span class="hide-menu" style="color:black;font-weight: bold;">RECURSOS HUMANOS</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level
                                @if(request()->is('admin/users') || request()->is('admin/users/*')) in @endif

                            ">

                            @can('areas_access')
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/users') || request()->is('admin/users/*')) is_active @endif"
                                        href="{{ route('areas.index') }}" aria-expanded="false">
                                        <i class="fa fa-database" aria-hidden="true" style="color:#800000;font-weight: bold;"></i>
                                        <span class="hide-menu" style="color:black;font-weight: bold;">Areas-Files</span>
                                    </a>
                                </li>
                                @endcan


                                @can('planta_access')
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/users') || request()->is('admin/users/*')) is_active @endif"
                                        href="{{ route('planta.index') }}" aria-expanded="false">
                                        <i class="fa fa-id-badge" aria-hidden="true" style="color:#2894FF;font-weight: bold;"></i>
                                        <span class="hide-menu" style="color:black;font-weight: bold;">Personal Planta</span>
                                    </a>
                                </li>
                                @endcan

                                @can('planta_access')
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/users') || request()->is('admin/users/*')) is_active @endif"
                                        href="{{ route('planta.listageneral') }}" aria-expanded="false" >
                                        <i class="fa fa-file" aria-hidden="true" style="color:#2894FF;font-weight: bold;"></i>
                                        <span class="hide-menu" style="color:black;font-weight: bold;">Lista Gral. Planta</span>
                                    </a>
                                </li>
                                @endcan



                                @can('personal_contrato_access')
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/users') || request()->is('admin/users/*')) is_active @endif"
                                        href="{{ route('contrato.index') }}" aria-expanded="false">
                                        <i class="fa fa-user-circle" aria-hidden="true" style="color:#800080;font-weight: bold;"></i>
                                        <span class="hide-menu" style="color:black;font-weight: bold;">Personal Contrato</span>
                                    </a>
                                </li>
                                @endcan


                                @can('personal_contrato_access')
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/users') || request()->is('admin/users/*')) is_active @endif"
                                        href="{{ route('contrato.listageneral') }}" aria-expanded="false" >
                                        <i class="fa fa-file" aria-hidden="true" style="color:#800080;font-weight: bold;"></i>
                                        <span class="hide-menu" style="color:black;font-weight: bold;">Lista Gral. Contrato</span>
                                    </a>
                                </li>
                                @endcan


                            </ul>
                        </li>
                        @endcanany



















                        @canany(['users_access','roles_access','permissions_access'])
                        <li class="sidebar-item">

                            <a class="sidebar-link has-arrow waves-effect waves-dark selected" href="javascript:void(0)"
                                aria-expanded="false">

                                <i class="fab fa-expeditedssl" aria-hidden="true" style="color:green;"></i>
                                <span class="hide-menu" style="color:black;font-weight: bold;">USUARIOS</span>
                            </a>
                            <ul aria-expanded="false"
                                class="collapse first-level
                                @if(request()->is('admin/users') || request()->is('admin/users/*')) in @endif
                                @if(request()->is('admin/roles') || request()->is('admin/roles/*')) in @endif
                                @if(request()->is('admin/permissions') || request()->is('admin/permissions/*')) in @endif">









                                @can('users_access')
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/users') || request()->is('admin/users/*')) is_active @endif"
                                        href="{{ route('admin.users.index') }}" aria-expanded="false">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        <span class="hide-menu" style="color:black;font-weight: bold;">Usuarios</span>
                                    </a>
                                </li>
                                @endcan

                                @can('roles_access')
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/roles') || request()->is('admin/roles/*')) is_active @endif"
                                        href="{{ route('admin.roles.index') }}" aria-expanded="false">
                                        <i class="fa fa-user-secret" aria-hidden="true"></i>
                                        <span class="hide-menu" style="color:black;font-weight: bold;">Roles</span>
                                    </a>
                                </li>
                                @endcan

                                @can('permissions_access')
                                <li class="sidebar-item">
                                    <a class="sidebar-link waves-effect waves-dark  @if(request()->is('admin/permissions') || request()->is('admin/permissions/*')) is_active @endif"
                                        href="{{ route('admin.permissions.index') }}" aria-expanded="false">
                                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                                        <span class="hide-menu" style="color:black;font-weight: bold;">Permisos</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcanany

                        {{-- <li class="sidebar-item selected"> <a class="sidebar-link has-arrow waves-effect waves-dark active" href="javascript:void(0)" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home feather-icon"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg><span class="hide-menu">Dashboard <span class="badge badge-pill badge-success">5</span></span></a>
                            <ul aria-expanded="false" class="collapse first-level in">
                                <li class="sidebar-item"><a href="index.html" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Modern Dashboard  </span></a></li>
                                <li class="sidebar-item active"><a href="index2.html" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Awesome Dashboard </span></a></li>
                                <li class="sidebar-item"><a href="index3.html" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Classy Dashboard </span></a></li>
                                <li class="sidebar-item"><a href="index4.html" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Analytical Dashboard </span></a></li>
                                <li class="sidebar-item"><a href="index5.html" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Minimal Dashboard </span></a></li>
                            </ul>
                        </li> --}}

                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->

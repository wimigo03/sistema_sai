<aside class="sidebar">
    <div class="toggle">
        <a href="#" class="burger js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
            <span></span>
        </a>
    </div>
    <div class="side-inner">
        <div class="profile">
            <img src="{{ asset('logos/logo2.png') }}" alt="Image" class="img-fluid" />
            <span class="name font-verdana" style="color:green">S.A.I. - G.A.R.G.CH.</span>
            {{-- <span class="country" style="color:green">Yacuiba - Carapari - Villamontes</span> --}}
            <a href="javascript:void(0)" onclick="$('#logout-form').submit();" class="dropdown-item">
                <i class="fa fa-sign-out" aria-hidden="true" style="color:red"></i>
                <span class="font-verdana-bg" style="color:red;">Cerrar Sesion</span>
            </a>
        </div>
        <div class="nav-menu">
            <div class="sidebar left">
                <ul class="list-sidebar bg-defoult">


                    {{-- CANASTA --}}
                    @canany(['agenda_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_canasta"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa-duotone fa-user" style="color:green"></i>
                                <span class="nav-label mr-3">CANASTA</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_canasta">
                                @can('agenda_ejecutivo')
                                    <li>
                                        <a href="{{ route('canasta.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Acceso1</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('agenda_institucional')
                                    <li>
                                        <a href="{{ asset('/Evento2/index/') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Acceso2</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany


       {{-- EXPOCHACO --}}
       @canany(['agenda_access'])
       <li class="font-verdana-bg">
           <a href="" data-toggle="collapse" data-target="#dashboard_expochaco"
               class="active collapsed" aria-expanded="false">
               <i class="fa-duotone fa-user" style="color:green"></i>
               <span class="nav-label mr-3">EXPOCHACO</span>
               <span class="fa fa-arrow-circle-left float-right"></span>
           </a>
           <ul class="sub-menu collapse" id="dashboard_expochaco">
               @can('agenda_ejecutivo')
                   <li>
                       <a href="{{ route('expochaco.index') }}">
                           &nbsp; &nbsp; &nbsp;
                           <span class="nav-label mr-4">Ingresar</span>
                       </a>
                   </li>
               @endcan

           </ul>
       </li>
   @endcanany


                    {{-- EVENTO --}}
                    @canany(['agenda_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_agenda"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa-sharp fa-solid fa-calendar fa-beat" style="color:green"></i>
                                <span class="nav-label mr-3">AGENDA</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_agenda">
                                @can('agenda_ejecutivo')
                                    <li>
                                        <a href="{{ asset('/Evento/index/') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Ejecutivo</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('agenda_institucional')
                                    <li>
                                        <a href="{{ asset('/Evento2/index/') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Institucional</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany


                    {{-- EVENTO 2
               @canany(['agenda2_access'])
                   <li class="font-verdana-bg">
                       <a href="" data-toggle="collapse" data-target="#dashboard_agenda2"
                           class="active collapsed" aria-expanded="false">
                           <i class="fa-sharp fa-solid fa-calendar fa-beat" style="color:green"></i>
                           <span class="nav-label mr-3">Agenda2</span>
                           <span class="fa fa-arrow-circle-left float-right"></span>
                       </a>
                       <ul class="sub-menu collapse" id="dashboard_agenda2">
                           @can('agenda2_access')
                               <li>
                                   <a href="{{ asset('/Evento2/index/') }}">
                                       &nbsp; &nbsp; &nbsp;
                                       <span class="nav-label mr-4">Calendario</span>
                                   </a>
                               </li>
                           @endcan


                       </ul>
                   </li>
               @endcanany
--}}


                    {{-- COMPRAS --}}
                    @canany(['compras_panel_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_compras"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa fa-shopping-cart" style="color:green"></i>
                                <span class="nav-label mr-3">COMPRAS</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_compras">
                                @can('compras_panel_access')
                                    <li>
                                        <a href="{{ route('compras.pedidoparcial.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Solicitudes de Compra</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('compras_panel_access')
                                    <li>
                                        <a href="{{ route('compras.pedido.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Compras Solicitadas</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('medidas_access')
                                    <li>
                                        <a href="{{ route('medidas.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Medidas</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('partidas_access')
                                    <li>
                                        <a href="{{ route('partida.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Partidas</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('productos_access')
                                    <li>
                                        <a href="{{ route('productos.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Productos-Items</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('proveedores_access')
                                    <li>
                                        <a href="{{ route('proveedores.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Proveedores</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('programas_access')
                                    <li>
                                        <a href="{{ route('programas.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Programas</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('catprog_access')
                                    <li>
                                        <a href="{{ route('catprog.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Categ. Programaticas</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany


                     {{-- COMPRAS combustible --}}
                     @canany(['combustibles_access'])
                     <li class="font-verdana-bg">
                         <a href="" data-toggle="collapse" data-target="#dashboard_combustibles"
                             class="active collapsed" aria-expanded="false">
                             <i class="fa fa-shopping-cart" style="color:green"></i>
                             <span class="nav-label mr-3">COMBUSTIBLES</span>
                             <span class="fa fa-arrow-circle-left float-right"></span>
                         </a>
                         <ul class="sub-menu collapse" id="dashboard_combustibles">
                              @can('compras_panel_access')
                                 <li>
                                     <a href="{{ route('combustibles.pedidoparcial.index') }}">
                                         &nbsp; &nbsp; &nbsp;
                                         <span class="nav-label mr-4">Solicitud de Combustible</span>
                                     </a>
                                 </li>
                             @endcan 


                              @can('compras_panel_access')
                                 <li>
                                     <a href="{{ route('combustibles.pedido.index') }}">
                                         &nbsp; &nbsp; &nbsp;
                                         <span class="nav-label mr-4">Combustible Solicitados</span>
                                     </a>
                                 </li>
                             @endcan
                         
                             @can('partidas_access')
                                 <li>
                                     <a href="{{ route('partidacomb.index') }}">
                                         &nbsp; &nbsp; &nbsp;
                                         <span class="nav-label mr-4">Partidas</span>
                                     </a>
                                 </li>
                             @endcan 
                             @can('productocomb_access')
                                 <li>
                                     <a href="{{ route('producto.index') }}">
                                         &nbsp; &nbsp; &nbsp;
                                         <span class="nav-label mr-4">Productos-Items</span>
                                     </a>
                                 </li>
                             @endcan

                              @can('proveedorcomb_access')
                                 <li>
                                     <a href="{{ route('proveedor.index') }}">
                                         &nbsp; &nbsp; &nbsp;
                                         <span class="nav-label mr-4">Proveedores</span>
                                     </a>
                                 </li>
                             @endcan


                             @can('programacomb_access')
                                 <li>
                                     <a href="{{ route('programa.index') }}">
                                         &nbsp; &nbsp; &nbsp;
                                         <span class="nav-label mr-4">Programas</span>
                                     </a>
                                 </li>
                             @endcan



                             @can('catprog_access')
                                 <li>
                                     <a href="{{ route('catprogcomb.index') }}">
                                         &nbsp; &nbsp; &nbsp;
                                         <span class="nav-label mr-4">Categ. Programaticas</span>
                                     </a>
                                 </li>
                             @endcan 
                         </ul>
                     </li>
                 @endcanany

                    {{-- ALMACEN --}}

                    @canany(['archivos_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_almacen"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa fa-th-list" style="color:green"></i>
                                <span class="nav-label mr-3">ALMACEN</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_almacen">
                                @can('archivos_access')
                                    <li>
                                        <a href="{{ route('almacen.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Ingresos</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>

                            <ul class="sub-menu collapse" id="dashboard_almacen">
                                @can('archivos_access')
                                    <li>
                                        <a href="{{ route('almacen.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Salidas</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>

                            <ul class="sub-menu collapse" id="dashboard_almacen">
                                @can('archivos_access')
                                    <li>
                                        <a href="{{ route('almacenes.ingreso.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Ingreso.</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>

                            <ul class="sub-menu collapse" id="dashboard_almacen">
                                @can('archivos_access')
                                    <li>
                                        <a href="{{ route('almacenes.ingreso.grafico') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Grafico.</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>

                            <ul class="sub-menu collapse" id="dashboard_almacen">
                                @can('archivos_access')
                                    <li>
                                        <a href="{{ route('almacenes.pedido.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Solicitudes Pend.</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>


                            <ul class="sub-menu collapse" id="dashboard_almacen">
                                @can('archivos_access')
                                    <li>
                                        <a href="{{ route('almacenes.pedido.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Solicitudes Pend.</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>

                            <ul class="sub-menu collapse" id="dashboard_almacen">
                                @can('archivos_access')
                                    <li>
                                        <a href="{{ route('localidad.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Localidad</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany


                    {{--todo trasnporte --}}

@canany(['transportes_access'])
<li class="font-verdana-bg">
    <a href="" data-toggle="collapse" data-target="#dashboard_transportes" class="active collapsed" aria-expanded="false">
        <i class="fa fa-users"></i>
        <span class="nav-label mr-3">transporte</span>
        <span class="fa fa-chevron-left float-right"></span>
    </a>
    <ul class="sub-menu collapse" id="dashboard_transportes">

        @can('vehiculo_access')
        <li>
            <a href="{{ route('transportes.pedidoparcial.index') }}">
                &nbsp;<i class="fa fa-data base"></i>
                <span class="nav-label mr-4">Solicitud</span>
            </a>
        </li>

    @endcan

    @can('vehiculo_access')
    <li>
        <a href="{{ route('transportes.pedido.index3') }}">
            &nbsp;<i class="fa fa-data base"></i>
            <span class="nav-label mr-4">Por aprovar</span>
        </a>
    </li>

@endcan

    @can('vehiculo_access')
    <li>
        <a href="{{ route('transportes.pedido.index') }}">
            &nbsp;<i class="fa fa-data base"></i>
            <span class="nav-label mr-4">Pendientes</span>
        </a>
    </li>

@endcan




        @can('vehiculo_access')
            <li>
                <a href="{{ route('transportes.uconsumo.index') }}">
                    &nbsp;<i class="fa fa-data base"></i>
                    <span class="nav-label mr-4">vehiculo</span>
                </a>
            </li>

        @endcan

        @can('tipomovilidad_access')
        <li>
            <a href="{{ route('tipo.index') }}">
                &nbsp;<i class="fa fa-data base"></i>
                <span class="nav-label mr-4">Tipo</span>
            </a>
        </li>

    @endcan

    {{-- @can('unidadconsumo_access')
    <li>
        <a href="{{ route('uconsumo.index') }}">
            &nbsp;<i class="fa fa-data base"></i>
            <span class="nav-label mr-4">Unidad De Consumo</span>
        </a>
    </li>

@endcan --}}



        {{-- @can('planta_access')
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
        --}}
    </ul>
</li>
@endcanany 



                    {{-- CORRESPONDENCIA --}}
                    @canany(['ventanilla_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_ventanilla"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa fa-folder-open" style="color:green"></i>
                                <span class="nav-label mr-3">CORRESPONDENCIA</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_ventanilla">
                                @can('archivos_access')
                                    <li>
                                        <a href="{{ route('recepcion.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Acceder</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany

                    {{-- CORRESPONDENCIA LOCAL --}}
                    @canany(['ventanilla_access_local'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_ventanilla2"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa fa-envelope" style="color:green"></i>
                                <span class="nav-label mr-3">CORRESP.LOCAL</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_ventanilla2">
                                @can('ventanilla_access_local')
                                    <li>
                                        <a href="{{ route('recepcion2.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Acceder</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany


                    {{-- CORRESPONDENCIA LOCAL 2 --}}
                    @canany(['ventanilla_access_local'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_ventanilla22"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa fa-envelope" style="color:green"></i>
                                <span class="nav-label mr-3">DERVICACION</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_ventanilla22">
                                @can('ventanilla_access_local')
                                    <li>
                                        <a href="{{ route('derivacion.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Acceder</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany


                    {{-- ARCHIVOS --}}
                    @canany(['archivos_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_archivos2"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa fa-file-pdf" style="color:green"></i>
                                <span class="nav-label mr-3">ARCHIVOS</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_archivos2">
                                @can('archivos_access')
                                    <li>
                                        <a href="{{ route('archivos2.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Acceder</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                            <ul class="sub-menu collapse" id="dashboard_archivos2">
                                @can('archivos_gral_access')
                                    <li>
                                        <a href="{{ route('archivos2.index2') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Listado General</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany


                    {{-- RRHH --}}
                    @canany(['recHumanos_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_rrhh"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa fa-users" style="color:green"></i>
                                <span class="nav-label mr-3">RECURSOS HUMANOS</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_rrhh">
                                @can('areas_access')
                                    <li>
                                        <a href="{{ route('areas.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Areas-Files</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('planta_access')
                                    <li>
                                        <a href="{{ route('planta.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Gestionar P. Planta</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('planta_access')
                                    <li>
                                        <a href="{{ route('planta.listageneral') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Lista Gral. Planta</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('personal_contrato_access')
                                    <li>
                                        <a href="{{ route('contrato.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Gestionar P. Contrato</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('personal_contrato_access')
                                    <li>
                                        <a href="{{ route('contrato.listageneral') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Lista Gral. Contrato</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    {{-- Personerias --}}
                    @canany(['recHumanos_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_personeria"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa fa-file-text" style="color:green"></i>
                                <span class="nav-label mr-3">PERSONERIAS</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_personeria"
                                @if (request()->is('admin/users') || request()->is('admin/users/*')) in @endif>
                                @can('areas_access')
                                    <li>
                                        <a href="{{ route('activos.index') }}">
                                            &nbsp; &nbsp; &nbsp;
                                            <span class="nav-label mr-4">Personerias</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    {{-- Activos Fijos --}}
                    @canany(['recHumanos_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_activos_fijos"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa fa-circle" style="color:green"></i>
                                <span class="nav-label mr-3">ACTIVOS FIJOS</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_activos_fijos"
                                @if (request()->is('admin/users') || request()->is('admin/users/*')) in @endif ">
                                        @can('areas_access')
        <li>
                                                        <a href="{{ route('activos.index') }}">
                                                            &nbsp; &nbsp; &nbsp;
                                                            <span class="nav-label mr-4">Activos</span>
                                                        </a>
                                                    </li>
    @endcan
                                    </ul>
                                </li>
                    @endcanany
                    {{-- Usuarios --}}
                    @canany(['users_access', 'roles_access', 'permissions_access'])
                                <li class="font-verdana-bg">
                                    <a href="" data-toggle="collapse" data-target="#dashboard_users"
                                        class="active collapsed" aria-expanded="false">
                                        <i class="fa fa-users" style="color:green"></i>
                                        <span class="nav-label mr-3">USUARIOS</span>
                                        <span class="fa fa-arrow-circle-left float-right"></span>
                                    </a>
                                    <ul class="sub-menu collapse" id="dashboard_users">
                                        @can('users_access')
        <li>
                                                        <a href="{{ route('admin.users.index') }}">
                                                            &nbsp; &nbsp; &nbsp;
                                                            <span class="nav-label mr-4">Usuarios</span>
                                                        </a>
                                                    </li>
    @endcan
                                        @can('roles_access')
        <li>
                                                        <a href="{{ route('admin.roles.index') }}">
                                                            &nbsp; &nbsp; &nbsp;
                                                            <span class="nav-label mr-4">Roles</span>
                                                        </a>
                                                    </li>
    @endcan
                                        @can('permissions_access')
        <li>
                                                        <a href="{{ route('admin.permissions.index') }}">
                                                            &nbsp; &nbsp; &nbsp;
                                                            <span class="nav-label mr-4">Permisos</span>
                                                        </a>
                                                    </li>
    @endcan
                                    </ul>
                                </li>
                    @endcanany
                    {{-- Discapacidad --}}
                    @canany(['discapacidad_panel_acess'])
                                <li class="font-verdana-bg">
                                    <a href="" data-toggle="collapse" data-target="#dashboard_discapacidad"
                                        class="active collapsed" aria-expanded="false">
                                        <i class="fa fa-users" style="color:green"></i>
                                        <span class="nav-label mr-3">DISCAPACIDAD</span>
                                        <span class="fa fa-arrow-circle-left float-right"></span>
                                    </a>
                                    <ul class="sub-menu collapse" id="dashboard_discapacidad">
                                        @can('entregas_acess')
        <li>
                                                        <a href="{{ route('canasta.entrega.index') }}">
                                                            &nbsp;
                                                            <span class="nav-label mr-4"></span>Listar Entregas
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('canasta.pendientes.index') }}">
                                                            &nbsp;
                                                            <span class="nav-label mr-4"></span>Pendientes
                                                        </a>
                                                    </li>
    @endcan
                                    </ul>
                                </li>
                    @endcanany
                    {{-- Activos --}}
                    @canany(['activos_panel_access'])
                                <li class="font-verdana-bg">
                                    <a href="" data-toggle="collapse" data-target="#dashboard_activosvsiaf"
                                        class="active collapsed" aria-expanded="false">
                                        <i class="fa fa-users" style="color:green"></i>
                                        <span class="nav-label mr-3">ACTIVOS</span>
                                        <span class="fa fa-arrow-circle-left float-right"></span>
                                    </a>
                                    <ul class="sub-menu collapse" id="dashboard_activosvsiaf">
                                        @can('activos_listar')
        <li>
                                                        <a href="{{ route('activos.vsiaf.index') }}">
                                                            &nbsp;
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

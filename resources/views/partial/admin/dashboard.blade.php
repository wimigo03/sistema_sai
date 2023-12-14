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
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_canasta_v1"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa-solid fa-gift"></i>
                                <span class="nav-label mr-3">Canasta (V1)</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_canasta_v1">
                                <li>
                                    <a href="{{ route('canasta.barrios.index') }}">
                                        <span class="nav-label mr-4">
                                            <i class="fa-solid fa-house"></i>&nbsp;Barrios
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('canasta.beneficiarios.index') }}">
                                        <span class="nav-label mr-4">
                                            <i class="fa-solid fa-users"></i>&nbsp;Beneficiarios
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('canasta.periodos.index') }}">
                                        <span class="nav-label mr-4">
                                            <i class="fa-brands fa-slack"></i>&nbsp;Periodos
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('canasta.entregas.index') }}">
                                        <span class="nav-label mr-4">
                                            <i class="fa-solid fa-list"></i>&nbsp;Entregas
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <li class="font-verdana-bg">
                        <a href="" data-toggle="collapse" data-target="#dashboard_canasta_v2"
                            class="active collapsed" aria-expanded="false">
                            <i class="fa-solid fa-gift"></i>
                            <span class="nav-label mr-3">Canasta (V2)</span>
                            <span class="fa fa-arrow-circle-left float-right"></span>
                        </a>
                        <ul class="sub-menu collapse" id="dashboard_canasta_v2">
                            <li>
                                <a href="{{ route('distritos.index') }}">
                                    <span class="nav-label mr-4">
                                        <i class="fa-solid fa-house"></i>&nbsp;Distritos
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('barrios.index') }}">
                                    <span class="nav-label mr-4">
                                        <i class="fa-solid fa-house"></i>&nbsp;Barrios
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- USUARIOS --}}
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_users"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa fa-users"></i>
                                <span class="nav-label mr-3">Usuarios</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_users">

                                    <li>
                                        <a href="{{ route('users.index') }}">
                                            <span class="nav-label mr-4">
                                                <i class="fa-solid fa-people-arrows"></i>&nbsp;Listar
                                            </span>
                                        </a>
                                    </li>


                                    <li>
                                        <a href="{{ route('roles.index') }}">
                                            <span class="nav-label mr-4">
                                                <i class="fa-solid fa-list"></i>&nbsp;Roles
                                            </span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('permissions.index') }}">
                                            <span class="nav-label mr-4">
                                                <i class="fa-solid fa-layer-group"></i>&nbsp;Permisos
                                            </span>
                                        </a>
                                    </li>

                            </ul>
                        </li>

                    {{-- COMPRAS --}}
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_compras"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa fa-shopping-cart" style="color:green"></i>
                                <span class="nav-label mr-3">COMPRAS</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_compras">
                                <li>
                                    <a href="{{ route('compras.pedidoparcial.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Solicitudes de Compra</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('compras.pedido.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Compras Solicitadas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('medidas.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Medidas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('partida.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Partidas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('productos.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Productos-Items</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('proveedores.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Proveedores</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('programas.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Programas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('catprog.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Categ. Programaticas</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    {{-- EXPOCHACO --}}
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_expochaco"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa-duotone fa-user" style="color:green"></i>
                                <span class="nav-label mr-3">EXPOCHACO</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_expochaco">
                                <li>
                                    <a href="{{ route('expochaco.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Ingresar</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    {{-- EXPOCHACO3 --}}
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_expochaco3"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa-duotone fa-user" style="color:green"></i>
                                <span class="nav-label mr-3">EXPOCHACO3</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_expochaco3">
                                <li>
                                    <a href="{{ route('expochaco3.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Ingresar</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    {{-- PERSONALIDADES JURIDICAS --}}
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_personerias"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa-duotone fa-book-user" style="color:green"></i>
                                <span class="nav-label mr-3">SI.RE.PE.JU.</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_personerias">
                                <li>
                                    <a href="{{ route('personerias.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Ingresar</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    {{-- EVENTO --}}
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_agenda"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa-sharp fa-solid fa-calendar fa-beat" style="color:green"></i>
                                <span class="nav-label mr-3">AGENDA</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_agenda">
                                <li>
                                    <a href="{{ asset('/Evento/index/') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Ejecutivo</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ asset('/Evento2/index/') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Institucional</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    {{-- COMPRAS combustible --}}
                        <li class="font-verdana-bg">
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
                                    <a href="{{ route('programa.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Programas</span>
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
                    {{-- ALMACEN --}}
                        <li class="font-verdana-bg">
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
                    {{--todo trasnporte --}}
                        <li class="font-verdana-bg">
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
                    {{-- CORRESPONDENCIA --}}
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_ventanilla"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa fa-folder-open" style="color:green"></i>
                                <span class="nav-label mr-3">CORRESPONDENCIA</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_ventanilla">
                                <li>
                                    <a href="{{ route('recepcion.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Acceder</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    {{-- CORRESPONDENCIA LOCAL --}}
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_ventanilla2"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa fa-envelope" style="color:green"></i>
                                <span class="nav-label mr-3">CORRESP.LOCAL</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_ventanilla2">
                                <li>
                                    <a href="{{ route('recepcion2.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Acceder</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    {{-- CORRESPONDENCIA LOCAL 2 --}}
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_ventanilla22"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa fa-envelope" style="color:green"></i>
                                <span class="nav-label mr-3">DERVICACION</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_ventanilla22">
                                <li>
                                    <a href="{{ route('derivacion.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Acceder</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    {{-- ARCHIVOS --}}
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_archivos2"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa fa-file-pdf" style="color:green"></i>
                                <span class="nav-label mr-3">ARCHIVOS</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_archivos2">
                                <li>
                                    <a href="{{ route('archivos2.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Acceder</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="sub-menu collapse" id="dashboard_archivos2">
                                <li>
                                    <a href="{{ route('archivos2.index2') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Listado General</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    {{-- RRHH --}}
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_rrhh"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa fa-users" style="color:green"></i>
                                <span class="nav-label mr-3">RECURSOS HUMANOS</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_rrhh">
                                <li>
                                    <a href="{{ route('areas.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Areas-Files</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('planta.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Gestionar P. Planta</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('planta.listageneral') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Lista Gral. Planta</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('contrato.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Gestionar P. Contrato</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('contrato.listageneral') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Lista Gral. Contrato</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    {{-- Personerias --}}
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_personeria"
                                class="active collapsed" aria-expanded="false">
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
                    {{-- Activos Fijos --}}
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_activos_fijos" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-circle" style="color:green"></i>
                                <span class="nav-label mr-3">ACTIVOS FIJOS</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_activos_fijos"
                                @if (request()->is('users') || request()->is('users/*')) in @endif>
                                <li>
                                    <a href="{{ route('activos.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Activos</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    {{-- Usuarios --}}
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_users" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-users" style="color:green"></i>
                                <span class="nav-label mr-3">USUARIOS</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_users">
                                <li>
                                    <a href="{{ route('users.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Usuarios</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{-- route('admin.roles.index') --}}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Roles</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{-- route('admin.permissions.index') --}}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Permisos</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    {{-- Discapacidad --}}
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_discapacidad"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa fa-users" style="color:green"></i>
                                <span class="nav-label mr-3">DISCAPACIDAD</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_discapacidad">
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
                            </ul>
                        </li>
                    {{-- Activos --}}
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_activosvsiaf" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-users" style="color:green"></i>
                                <span class="nav-label mr-3">ACTIVOS</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_activosvsiaf">
                                <li>
                                    <a href="{{ route('activos.vsiaf.index') }}">
                                        &nbsp;
                                        <span class="nav-label mr-4"></span>Listar
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_activos_fijos" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-users" style="color:green"></i>
                                <span class="nav-label mr-3">ACTIVOS FIJOS</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_activos_fijos"
                                @if (request()->is('users') || request()->is('users/*')) in @endif>
                                <li>
                                    <a href="{{ route('activo.unidadadmin.index') }}">
                                        &nbsp;<i class="fa fa-building"></i>
                                        <span class="nav-label mr-4"> unidad administrativa</span>
                                    </a>

                                </li>
                                <li>
                                    <a href="{{ route('activo.organismo.index') }}">
                                        &nbsp;<i class="fa fa-building"></i>
                                        <span class="nav-label mr-4"> Organismo Financiero</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('activo.codcont.index') }}">
                                        &nbsp;<i class="fas fa-money-check-alt"></i>
                                        <span class="nav-label mr-4"> Grupo Contable</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('activo.gestionactivo.index') }}">
                                        &nbsp;<i class="fa fa-database"></i>
                                        <span class="nav-label mr-4"> Gestión de Activos Fijos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('oficina.index') }}">
                                        &nbsp; <i class="fa fa-building"></i>
                                        <span class="nav-label mr-4"> Oficinas y Responsables</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('activo.reportes.index') }}">
                                        &nbsp;<i class="fa fa-chart-bar"></i>
                                        <span class="nav-label mr-4"> Reportes</a>
                                </li>
                            </ul>
                        </li>
                </ul>
            </div>
        </div>
    </div>
</aside>

<aside class="sidebar">
    <div class="toggle">
        <a href="#" class="burger js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
            <span></span>
        </a>
    </div>
    <div class="side-inner">
        <div class="profile">
            <img src="{{ asset('logos/logo2.png') }}" alt="Image" class="img-fluid" />
            <span class="font-roboto-15 text-success"><b>G.A.R.G.CH.</b></span>
        </div>
        <div class="nav-menu">
            <div class="sidebar left">
                <ul class="list-sidebar bg-defoult">
                    {{-- USUARIOS --}}
                    @canany(['users.index','roles.index','permissions.index'])
                        <li class="font-verdana-12">
                            <a href="" data-toggle="collapse" data-target="#dashboard_adm" class="active collapsed" aria-expanded="false">
                                <i class="fa-solid fa-gears fa-fw"></i>&nbsp;Administracion
                                <span class="fa-solid fa-chevron-left float-right fa-fw"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_adm">
                                @can('users.index')
                                    <li>
                                        <a href="{{ route('users.index') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fa fa-users fa-fw"></i>&nbsp;Usuarios
                                        </a>
                                    </li>
                                @endcan
                                @can('roles.index')
                                    <li>
                                        <a href="{{ route('roles.index') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fa-solid fa-list fa-fw"></i>&nbsp;Roles
                                        </a>
                                    </li>
                                @endcan
                                @can('permissions.index')
                                    <li>
                                        <a href="{{ route('permissions.index') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fa-solid fa-layer-group fa-fw"></i>&nbsp;Permisos
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    {{-- CANASTA --}}
                    @canany(['canasta.entregas.index','canasta.beneficiarios.index','canasta.distritos.index','canasta.barrios.index'])
                        <li class="font-verdana-12">
                            <a href="" data-toggle="collapse" data-target="#dashboard_canasta_v2" class="active collapsed" aria-expanded="false">
                                <i class="fa-solid fa-gift fa-fw"></i>&nbsp;Canasta
                                <span class="fa-solid fa-chevron-left float-right fa-fw"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_canasta_v2">
                                @can('canasta.entregas.index')
                                    <li>
                                        <a href="{{ route('entregas.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-shopping-bag fa-fw"></i>&nbsp;Paquetes
                                        </a>
                                    </li>
                                @endcan
                                @can('canasta.beneficiarios.index')
                                    <li>
                                        <a href="{{ route('beneficiarios.index') }}">
                                            &nbsp;&nbsp;<i class="fas fa-user-friends"></i>&nbsp;Beneficiarios
                                        </a>
                                    </li>
                                @endcan
                                @can('canasta.distritos.index')
                                    <li>
                                        <a href="{{ route('distritos.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-house"></i>&nbsp;Distritos
                                        </a>
                                    </li>
                                @endcan
                                @can('canasta.barrios.index')
                                    <li>
                                        <a href="{{ route('barrios.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-house"></i>&nbsp;Barrios
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    {{-- COMPRAS --}}
                    @canany(['solicitud.compra.index','orden.compra.index','proveedor.index','programa.index','categoria.programatica.index','item.index','unidad.medida.index','partida.index'])
                        <li class="font-verdana-12">
                            <a href="" data-toggle="collapse" data-target="#dashboard_compras" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="nav-label">Compras</span>
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
                                {{--<li>
                                    <a href="{{ route('compras.pedidoparcial.index') }}">
                                        &nbsp;&nbsp;&nbsp;<i class="fa-solid fa-file-lines fa-fw"></i>&nbsp;Solicitudes
                                    </a>
                                </li>--}}
                                @can('proveedor.index')
                                    <li>
                                        <a href="{{ route('proveedor.index') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fa-solid fa-person-carry fa-fw"></i>&nbsp;Proveedores
                                        </a>
                                    </li>
                                @endcan
                                @can('programa.index')
                                    <li>
                                        <a href="{{ route('programa.index') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fa-solid fa-list fa-fw"></i>&nbsp;Programas
                                        </a>
                                    </li>
                                @endcan
                                @can('categoria.programatica.index')
                                    <li>
                                        <a href="{{ route('categoria.programatica.index') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fa-solid fa-list fa-fw"></i>&nbsp;Categorias Programaticas
                                        </a>
                                    </li>
                                @endcan
                                @canany(['item.index','unidad.medida.index','partida.index'])
                                    <li class="font-verdana-12">
                                        <a href="" data-toggle="collapse" data-target="#dashboard_productos" class="active collapsed" aria-expanded="false">
                                            &nbsp;&nbsp;&nbsp;<i class="fa fa-shopping-cart"></i>
                                            <span class="nav-label">Productos</span>
                                            <span class="fa fa-arrow-circle-left float-right"></span>
                                        </a>
                                        <ul class="sub-menu collapse" id="dashboard_productos">
                                            @can('item.index')
                                                <li>
                                                    <a href="{{ route('item.index') }}">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-gifts fa-fw"></i>&nbsp;Items
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('unidad.medida.index')
                                                <li>
                                                    <a href="{{ route('unidad.medida.index') }}">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-balance-scale fa-fw"></i>&nbsp;Unidades de Medida
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('partida.index')
                                                <li>
                                                    <a href="{{ route('partida.index') }}">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-file-invoice fa-fw"></i>&nbsp;Partidas Presupuestarias
                                                    </a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcanany
                            </ul>
                        </li>
                    @endcanany
                    {{-- ALMACENES --}}
                    @canany(['almacen.index','ingreso_compra.index'])
                        <li class="font-verdana-12">
                            <a href="" data-toggle="collapse" data-target="#dashboard_almacenes" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="nav-label">Almacenes</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_almacenes">
                                @can('almacen.index')
                                    <li>
                                        <a href="{{ route('almacen.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-list fa-fw"></i>&nbsp;Ir a almacenes
                                        </a>
                                    </li>
                                @endcan
                                @can('ingreso.compra.index')
                                    <li>
                                        <a href="{{ route('ingreso.compra.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-file-lines fa-fw"></i>&nbsp;Ingresos por Compra
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    @can('expochaco.index')
                        <li class="font-verdana-12">
                            <a href="" data-toggle="collapse" data-target="#dashboard_expochaco" class="active collapsed" aria-expanded="false">
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
                        <hr style="margin-top:0; margin-bottom:0;">
                        <li class="font-verdana-12">
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
                        <hr style="margin-top:0; margin-bottom:0;">
                    @endcan
                    {{-- PERSONALIDADES JURIDICAS --}}
                    @can('personerias.index')
                        <li class="font-verdana-12">
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
                        <hr style="margin-top:0; margin-bottom:0;">
                    @endcan
                    {{-- SEREGES --}}
                    @can('sereges.registro_index')
                        <li class="font-verdana-12">
                            <a href="" data-toggle="collapse" data-target="#dashboard_sereges" class="active collapsed" aria-expanded="false">
                                <i class="fa-duotone fa-book-user" style="color:green"></i>
                                <span class="nav-label mr-3">SEREGES</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_sereges">
                                <li>
                                    <a href="{{ route('sereges.registro_index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Registro</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('sereges.albergue_index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Albergue-Hogar</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <hr style="margin-top:0; margin-bottom:0;">
                    @endcan
                     {{-- INFORMATICA --}}
                    @can('informatica.registro_index')
                        <li class="font-verdana-12">
                            <a href="" data-toggle="collapse" data-target="#dashboard_infor" class="active collapsed" aria-expanded="false">
                                <i class="fa-duotone fa-book-user" style="color:green"></i>
                                <span class="nav-label mr-3">INFORMATICA</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_infor">
                                <li>
                                    <a href="{{ route('informatica.registro_index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Registro</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <hr style="margin-top:0; margin-bottom:0;">
                    @endcan
                    {{-- EVENTO --}}
                    @can('evento.index')
                        <li class="font-verdana-12">
                            <a href="" data-toggle="collapse" data-target="#dashboard_agenda" class="active collapsed" aria-expanded="false">
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
                                <li>
                                    <a href="{{ asset('facebook') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Facebook</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <hr style="margin-top:0; margin-bottom:0;">
                    @endcan
                    {{-- COMPRAS combustible --}}
                    @can('combustibles.pedidoparcial.index')
                        <li class="font-verdana-12">
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
                        <hr style="margin-top:0; margin-bottom:0;">
                    @endcan
                    {{-- ALMACEN --}}
                    @can('almacenes.ingreso.index')
                        <li class="font-verdana-12">
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
                    @endcan
                    {{-- todo trasnporte --}}
                    @can('transportes.pedidoparcial.index')
                        <li class="font-verdana-12">
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
                    @endcan
                    {{-- CORRESPONDENCIA --}}
                    {{--@can('correspondencia.index')--}}
                        <li class="font-verdana-12">
                            <a href="" data-toggle="collapse" data-target="#dashboard_ventanilla" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-folder-open" style="color:green"></i>
                                <span class="nav-label mr-3">CORRESPONDENCIA</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_ventanilla">
                                <li>
                                    <a href="{{ route('correspondencia.index') }}">
                                        &nbsp; &nbsp; &nbsp;
                                        <span class="nav-label mr-4">Acceder</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <hr style="margin-top:0; margin-bottom:0;">
                    {{--@endcan--}}
                    {{-- CORRESPONDENCIA LOCAL --}}
                    @can('recepcion2.index')
                        <li class="font-verdana-12">
                            <a href="" data-toggle="collapse" data-target="#dashboard_ventanilla2" class="active collapsed" aria-expanded="false">
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
                        <hr style="margin-top:0; margin-bottom:0;">
                    @endcan
                    {{-- CORRESPONDENCIA LOCAL 2 --}}
                    @can('derivacion.index')
                        <li class="font-verdana-12">
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
                        <hr style="margin-top:0; margin-bottom:0;">
                    @endcan
                    {{-- ARCHIVOS --}}
                    @can('archivos2.index')
                        <li class="font-verdana-12">
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
                        <hr style="margin-top:0; margin-bottom:0;">
                    @endcan
                    {{-- RRHH --}}
                    @can('areas.index')
                        <li class="font-verdana-12">
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
                        <hr style="margin-top:0; margin-bottom:0;">
                    @endcan
                    {{-- Personerias --}}
                    @can('activos.index')
                        <li class="font-verdana-12">
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
                    @endcan
                    @can('unidadadmin_access')
                        <li class="font-verdana-12">
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
                                                        {{-- Gestión de Activos Fijos--}}
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
                                                <span class="font-verdana-12" style="color:red;">Cerrar Sesion</span>
                                            </a>
                                        </ul>
                                </ul>
                        </li>
                    @endcan
                    <li class="font-verdana-12">
                        <a href="javascript:void(0)" onclick="$('#logout-form').submit();" class="text-danger">
                            <i class="fa fa-sign-out fa-fw"></i>&nbsp;Cerrar Sesion
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>

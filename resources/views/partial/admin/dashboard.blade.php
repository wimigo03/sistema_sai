<aside class="sidebar">
    <div class="toggle">
        <a href="#" class="burger js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
            <span></span>
        </a>
    </div>
    <div class="side-inner">
        <div class="profiles text-center">
            <img src="{{ asset('logos/logo_gober.png') }}" alt="Image" class="imagen-header" />
            {{--<span class="font-roboto-15 text-success"><b>G.A.R.G.CH.</b></span>--}}
        </div>
        <div class="nav-menu">
            <div class="sidebar left">
                <ul class="list-sidebar bg-defoult">
                    {{-- @can('empleados.mi.perfil') --}}
                        <li class="font-verdana-13">
                            <a href="{{ route('empleado.mi.perfil') }}">
                                <i class="fa fa-user fa-fw"></i>&nbsp;Mi perfil
                            </a>
                        </li>
                    {{-- @endcan --}}
                    {{--DESPACHO--}}
                    @can('agenda.ejecutiva.index')
                        <li class="font-verdana-13 counter">
                            <a href="{{ route('agenda.ejecutiva.index') }}">
                                <i class="fa-sharp fa-solid fa-calendar fa-fw"></i>&nbsp;Agenda ejecutiva
                            </a>
                        </li>
                    @endcan
                    {{-- USUARIOS --}}
                    @canany(['users.index','roles.index','permissions.index'])
                        <li class="font-verdana-13 counter">
                            <a href="" data-toggle="collapse" data-target="#dashboard_adm" class="active collapsed" aria-expanded="false">
                                <i class="fa-solid fa-gears fa-fw"></i>&nbsp;Configuracion
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
                    {{-- SISTEMAS --}}
                    @canany(['control.interno.index','mantenimientos.index','facebook.index','archivos.index.general'])
                        <li class="font-verdana-13 counter">
                            <a href="" data-toggle="collapse" data-target="#dashboard_sistemas" class="active collapsed" aria-expanded="false">
                                <i class="fa-solid fa-gears fa-fw"></i>&nbsp;Unidad de Sistemas
                                <span class="fa-solid fa-chevron-left float-right fa-fw"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_sistemas">
                                @can('control.interno.index')
                                    <li>
                                        <a href="{{ route('control.interno.index') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fa fa-envelope fa-fw"></i>&nbsp;Control Interno
                                        </a>
                                    </li>
                                @endcan
                                @can('mantenimientos.index')
                                    <li>
                                        <a href="{{ route('mantenimientos.index') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fa-solid fa-tools fa-fw"></i>&nbsp;Mantenimientos
                                        </a>
                                    </li>
                                @endcan
                                {{-- @can('archivos.index.general')
                                    <li>
                                        <a href="{{ route('archivos.index.full') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fa-solid fa-file fa-fw"></i>&nbsp;Archivos Digitales
                                        </a>
                                    </li>
                                @endcan --}}
                                @can('facebook.index')
                                    <li>
                                        <a href="{{ route('facebook.index') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fa-brands fa-twitter fa-fw"></i>&nbsp;Redes Sociales
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    {{-- CANASTA --}}
                    @canany([
                        'canasta.paquetes.index',
                        'canasta.beneficiarios.index',
                        'canasta.entregas.beneficiario.index',
                        'canasta.distritos.index',
                        'canasta.barrios.index',
                        'canasta.beneficiarios.brigadista.index'
                        ])
                        <li class="font-verdana-13 counter">
                            <a href="" data-toggle="collapse" data-target="#dashboard_canasta_v2" class="active collapsed" aria-expanded="false">
                                <i class="fa-solid fa-gift fa-fw"></i>&nbsp;Programa Tercera Edad
                                <span class="fa-solid fa-chevron-left float-right fa-fw"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_canasta_v2">
                                @can('reportes.canasta.index')
                                    <li>
                                        <a href="{{ route('reportes.canasta.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-list fa-fw"></i>&nbsp;Reportes
                                        </a>
                                    </li>
                                @endcan
                                @can('canasta.paquetes.index')
                                    <li>
                                        <a href="{{ route('paquetes.index') }}">
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
                                @can('canasta.beneficiarios.brigadista.index')
                                    <li>
                                        <a href="{{ route('beneficiarios.brigadista.index') }}">
                                            &nbsp;&nbsp;<i class="fas fa-user-friends"></i>&nbsp;*Beneficiarios
                                        </a>
                                    </li>
                                @endcan
                                @can('canasta.entregas.beneficiario.index')
                                    <li>
                                        <a href="{{ route('entrega.beneficiario.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-search fa-fw"></i>&nbsp;Buscar Entrega
                                        </a>
                                    </li>
                                @endcan
                                @can('canasta.distritos.index')
                                    <li>
                                        <a href="{{ route('distritos.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-house fa-fw"></i>&nbsp;Distritos
                                        </a>
                                    </li>
                                @endcan
                                @can('canasta.barrios.index')
                                    <li>
                                        <a href="{{ route('barrios.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-house-crack fa-fw"></i>&nbsp;Barrios
                                        </a>
                                    </li>
                                @endcan
                                @can('canasta.barrios.index')
                                    <li>
                                        <a href="{{ route('ocupacion.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-briefcase fa-fw"></i>&nbsp;Profesion/Ocupacion
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    {{-- CANASTA DISCAPACIDAD --}}
                    @canany(['canastadisc.beneficiarios.index'])
                        <li class="font-verdana-13 counter">
                            <a href="" data-toggle="collapse" data-target="#dashboard_canasta_didsc_v2" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-wheelchair"></i>&nbsp;Programa Discapacidad
                                <span class="fa-solid fa-chevron-left float-right fa-fw"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_canasta_didsc_v2">
                                @can('canastadisc.paquetes.index')
                                    <li>
                                        <a href="{{ route('paquetesdisc.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-shopping-bag fa-fw"></i>&nbsp;Paquetes
                                        </a>
                                    </li>
                                @endcan
                                @can('canastadisc.beneficiarios.index')
                                    <li>
                                        <a href="{{ route('beneficiariosdisc.index') }}">
                                            &nbsp;&nbsp;<i class="fas fa-user-friends"></i>&nbsp;Beneficiarios
                                        </a>
                                    </li>
                                @endcan
                                @can('canasta.entregas.beneficiario.index')
                                    <li>
                                        <a href="{{ route('entrega.beneficiario.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-search fa-fw"></i>&nbsp;Buscar
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
                    @endcan--}}
                    {{--@can('orden.compra.index')
                        <li class="font-verdana-13 counter">
                            <a href="{{ route('orden.compra.index') }}">
                                <i class="fas fa-shopping-cart fa-fw"></i>&nbsp;Ordenes de compra
                            </a>
                        </li>
                    @endcan--}}
                    {{--@can('solicitud.material.index')
                        <li class="font-verdana-13 counter">
                            <a href="{{ route('solicitud.material.index') }}">
                                <i class="fa-solid fa-marker fa-fw"></i>&nbsp;Solicitud de Materiales
                            </a>
                        </li>
                    @endcan--}}
                    {{-- ALMACENES --}}
                    @canany(['almacen.index','ingreso.compra.index','salida.almacen.index','inventario.index','categoria.programatica.index','partida.presupuestaria.index','item.index','unidad.medida.index','proveedor.index'])
                        <li class="font-verdana-13 counter">
                            <a href="" data-toggle="collapse" data-target="#dashboard_almacenes" class="active collapsed" aria-expanded="false">
                                <i class="fa fa-shop fa-fw"></i>&nbsp;Unidad de Almacenes
                                <span class="fa-solid fa-chevron-left float-right fa-fw"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_almacenes">
                                @can('ingreso.compra.index')
                                    <li class="font-verdana-13 counter">
                                        <a href="{{ route('ingreso.compra.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-file-lines fa-fw"></i>&nbsp;Ingreso de Materiales
                                        </a>
                                    </li>
                                @endcan
                                @can('salida.almacen.index')
                                    <li class="font-verdana-13 counter">
                                        <a href="{{ route('salida.almacen.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-hdd fa-fw"></i>&nbsp;Salida de Materiales
                                        </a>
                                    </li>
                                @endcan
                                @can('inventario.index')
                                    <li class="font-verdana-13 counter">
                                        <a href="{{ route('inventario.index') }}">
                                            &nbsp;&nbsp;<i class="fas fa-warehouse fa-fw"></i>&nbsp;Inventario
                                        </a>
                                    </li>
                                @endcan
                                @can('categoria.programatica.index')
                                    <li>
                                        <a href="{{ route('categoria.programatica.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-bars-staggered fa-fw"></i>&nbsp;Categorias Programaticas
                                        </a>
                                    </li>
                                @endcan
                                @can('almacen.index')
                                    <li class="font-verdana-13 counter">
                                        <a href="{{ route('almacen.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-list-alt fa-fw"></i>&nbsp;Gestionar Almacen
                                        </a>
                                    </li>
                                @endcan
                                @can('partida.presupuestaria.index')
                                    <li>
                                        <a href="{{ route('partida.presupuestaria.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-list-ul fa-fw"></i>&nbsp;Partidas Presupuestarias
                                        </a>
                                    </li>
                                @endcan
                                @can('item.index')
                                    <li>
                                        <a href="{{ route('item.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-list-check fa-fw"></i>&nbsp;Items
                                        </a>
                                    </li>
                                @endcan
                                @can('unidad.medida.index')
                                    <li>
                                        <a href="{{ route('unidad.medida.index') }}">
                                            &nbsp;&nbsp;<i class="fas fa-balance-scale fa-fw"></i>&nbsp;Unidades de Medida
                                        </a>
                                    </li>
                                @endcan
                                @can('proveedor.index')
                                    <li>
                                        <a href="{{ route('proveedor.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-users fa-fw"></i>&nbsp;Proveedores
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    {{-- PERSONALIDADES JURIDICAS --}}
                    @can('personerias.index')
                        <li class="font-verdana-13">
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
                        <li class="font-verdana-13">
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
                        <li class="font-verdana-13">
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
                    @can('agenda.ej.index')
                        <li class="font-verdana-13">
                            <a href="" data-toggle="collapse" data-target="#dashboard_agenda" class="active collapsed" aria-expanded="false">
                                <i class="fa-sharp fa-solid fa-calendar fa-beat"></i>&nbsp;Agenda
                                <span class="fa-solid fa-chevron-left float-right fa-fw"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_agenda">
                                <li>
                                    <a href="{{ route('agenda.ej.index') }}">
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
                    @endcan
                    {{-- ALMACEN --}}
                    @can('almacenes.ingreso.index')
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
                    @endcan
                    {{-- todo trasnporte --}}
                    @can('transportes.pedidoparcial.index')
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
                    @endcan
                    {{-- CORRESPONDENCIA --}}
                    @canany(['correspondencia_local.index','correspondencia_local.remitente.index','correspondencia_local.unidad.index','correspondencia.index'])
                        <li class="font-verdana-13 counter">
                            <a href="" data-toggle="collapse" data-target="#dashboard_correspondencia" class="active collapsed" aria-expanded="false">
                                <i class="fa-solid fa-gift fa-fw"></i>&nbsp;Modulo Correspondencia
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
                                @can('correspondencia_local.index')
                                    <li>
                                        <a href="{{ route('correspondencia.derivada.index') }}">
                                            &nbsp;&nbsp;<i class="fa-solid fa-shopping-bag fa-fw"></i>&nbsp;Corresp. Derivada
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
                    @endcanany
                    {{-- CORRESPONDENCIA --}}
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
                    {{-- CORRESPONDENCIA LOCAL 2 --}}
                    @can('derivacion.index')
                        <li class="font-verdana-13">
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
                    @canany(['archivos.index','tipos.archivos.index','archivos.index.general'])
                        <li class="font-verdana-13 counter">
                            <a href="" data-toggle="collapse" data-target="#dashboard_archivos" class="active collapsed" aria-expanded="false">
                                <i class="fas fa-file fa-fw"></i>&nbsp;Archivos Digitales
                                <span class="fa-solid fa-chevron-left float-right fa-fw"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_archivos">
                                @can('archivos.index')
                                    <li>
                                        <a href="{{ route('archivos.index') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fas fa-file fa-fw"></i>&nbsp;Listar
                                        </a>
                                    </li>
                                @endcan
                                @can('tipos.archivos.index')
                                    <li>
                                        <a href="{{ route('tipos.archivos.index') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fas fa-file fa-fw"></i>&nbsp;Tipos
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    {{-- RRHH --}}
                    @canany(['empleados.index','areas.index'])
                        <li class="font-verdana-13 counter">
                            <a href="" data-toggle="collapse" data-target="#dashboard_rrhh" class="active collapsed" aria-expanded="false">
                                <i class="fas fa-users fa-fw"></i>&nbsp;Recursos Humanos
                                <span class="fa-solid fa-chevron-left float-right fa-fw"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_rrhh">
                                @can('empleados.index')
                                    <li>
                                        <a href="{{ route('empleado.index') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fas fa-user-friends fa-fw"></i>&nbsp;Personal
                                        </a>
                                    </li>
                                @endcan
                                @can('files.index')
                                    <li>
                                        <a href="{{ route('file.index') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fas fa-id-card fa-fw"></i>&nbsp;Cargos
                                        </a>
                                    </li>
                                @endcan
                                @can('areas.index')
                                    <li>
                                        <a href="{{ route('area.index') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fas fa-sitemap fa-fw"></i>&nbsp;Organigrama
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    {{-- Personerias --}}
                    @can('activos.index')
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
                    @endcan
                    @can('unidadadmin_access')
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
                                                <span class="font-verdana-13" style="color:red;">Cerrar Sesion</span>
                                            </a>
                                        </ul>
                                </ul>
                        </li>
                    @endcan
                    <li class="font-verdana-13 counter">
                        <a href="javascript:void(0)" onclick="$('#logout-form').submit();" class="text-danger">
                            <i class="fa fa-sign-out fa-fw"></i>&nbsp;Cerrar Sesion
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>

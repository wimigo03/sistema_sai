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

                     {{-- AGENDA EJECUTIVO E INSTITUCIONAL --}}
                    @canany(['agenda_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_agenda"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa-duotone fa-calendar-day" style="color:green"></i>
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
                                @can('facebook.index')
                                <li>
                                <a href="{{ asset('facebook') }}">
                                    &nbsp; &nbsp; &nbsp;
                                    <span class="nav-label mr-4">Facebook</span>
                                </a>
                            </li>
                            @endcan
                            </ul>
                        </li>
                    @endcanany

                <hr style="margin-top:0; margin-bottom:0;">

                {{-- CORRESPONDENCIA --}}
                    @canany(['ventanilla_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_ventanilla"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa-duotone fa-envelope" style="color:green"></i>
                                <span class="nav-label mr-3">CORRESP.ANTERIOR</span>
                                <span class="fa fa-arrow-circle-left float-right"></span>
                            </a>

                            <ul class="sub-menu collapse" id="dashboard_ventanilla">
                                @can('ventanilla_access')
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

                <hr style="margin-top:0; margin-bottom:0;">
                {{-- CORRESPONDENCIA LOCAL --}}
                    @canany(['ventanilla_access_local'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_ventanilla2"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa-duotone fa-envelopes-bulk" style="color:green"></i>
                                <span class="nav-label mr-3">CORRESP.ACTUAL</span>
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

                 <hr style="margin-top:0; margin-bottom:0;">

                  {{-- RRHH --}}
                    @canany(['recHumanos_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_rrhh"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa-duotone fa-users" style="color:green"></i>
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

                <hr style="margin-top:0; margin-bottom:0;">


                        <li class="font-verdana-12">
                            <a href="" data-toggle="collapse" data-target="#dashboard_canasta_v2" class="active collapsed" aria-expanded="false">
                                <i class="fa-solid fa-gift fa-fw"></i>&nbsp;Canasta
                                <span class="fa-solid fa-chevron-left float-right fa-fw"></span>
                            </a>
                            <ul class="sub-menu collapse" id="dashboard_canasta_v2">

                                    <li>
                                        <a href="{{ route('entregas.index') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fa-solid fa-shopping-bag fa-fw"></i>&nbsp;Paquetes
                                        </a>
                                    </li>


                                    <li>
                                        <a href="{{ route('beneficiarios.index') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fas fa-user-friends"></i>&nbsp;Beneficiarios
                                        </a>
                                    </li>


                                    <li>
                                        <a href="{{ route('distritos.index') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fa-solid fa-house"></i>&nbsp;Distritos
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('barrios.index') }}">
                                            &nbsp;&nbsp;&nbsp;<i class="fa-solid fa-house"></i>&nbsp;Barrios
                                        </a>
                                    </li>



                            </ul>
                        </li>


                    <hr style="margin-top:0; margin-bottom:0;">
                    {{-- ARCHIVOS --}}
                    @canany(['archivos_access'])
                        <li class="font-verdana-bg">
                            <a href="" data-toggle="collapse" data-target="#dashboard_archivos2"
                                class="active collapsed" aria-expanded="false">
                                <i class="fa-duotone fa-folder-tree" style="color:green"></i>
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

                <hr style="margin-top:0; margin-bottom:0;">





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

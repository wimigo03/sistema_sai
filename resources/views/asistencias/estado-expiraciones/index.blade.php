@extends('layouts.admin')

@section('content')
<div class="container-xl font-verdana-bg">
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <b>Lista de Personal Activo</b>
        </div>
        <div class="col-md-4 text-right">
            <a class="tts:left tts-slideIn tts-custom" aria-label="Exp" href="{{route('lista2.exp')}}">
                <button class="btn btn-sm btn-info font-verdana" type="button">

                    &nbsp; <i class="fa-regular fa-address-card"> &nbsp; </i>Lista General de Expiraciones</i>&nbsp;
                </button>
            </a>
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{route('admin.home')}}">
                <button class="btn btn-sm btn-danger font-verdana" type="button">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>

        </div>
         <div class="col-md-12">
            <hr class="hrr">
        </div>
        <ul class="nav nav-tabs" id="myTabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab1">Personal Planta</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab2">Personal Contrato</a>
            </li>

        </ul>
    </div>
    <div class="tab-content font-verdana">
        <div class="tab-pane fade show active" id="tab1">
            <hr class="hr">

            <div class="row font-verdana">
                <hr class="hr">

                <div class=" col-md-4  mb-2 ">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <div>
                                <div class="float-left mini-stat-img mr-4">
                                    <span class="fa fa-users" style="font-size: 30px"></span>
                                </div>
                                <h6 class="font-16 text-uppercase mt-0 text-white-50">Total <br>EXP. INDUCCIÓN</h6>
                            </div>
                            <span class="fa fa-user float-left " style="font-size: 60px; color:cadetblue "></span>
                            <div class="text-right">
                                @if ($cumplenAnioshoy > 0)
                                <h1 class="font-500 text-right"> {{ $cumplenAnioshoy }}</h1>
                                @else
                                <h1>0</h1>
                                @endif
                            </div>
                            <div class="text-right  ">
                                <a href="#hoy1" data-toggle="modal" class="text-white"><i class=" mdi-arrow-right h7">HOY
                                    </i></a>
                                </a>
                            </div>
                            <div class="text-right  ">
                                <a href="{{ route('lista.index', 1) }}"  class="text-white"><i class=" mdi-arrow-right h7">MES
                                    </i></a>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-md-4  mb-2">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <div>
                                <div class="float-left mini-stat-img mr-4">
                                    <span class="fa fa-users" style="font-size: 30px"></span>
                                </div>
                                <h6 class="font-16 text-uppercase mt-0 text-white-50">Total <br>EXP. DEC. JURADA</h6>
                            </div>
                            <span class="fa fa-user float-left " style="font-size: 60px; color:cadetblue "></span>
                            <div class="text-right">
                                @if ($cumplenexpdecjuradahoy > 0)
                                <h1 class="font-500 text-right"> {{ $cumplenexpdecjuradahoy }}</h1>
                                @else
                                <h1>0</h1>
                                @endif
                            </div>
                            <div class="text-right  ">
                                <a href="#hoy2" data-toggle="modal" class="text-white"><i class=" mdi-arrow-right h7">HOY
                                    </i></a>
                                </a>
                            </div>
                            <div class="text-right  ">
                                <a href="{{ route('lista.index', 2) }}" class="text-white"><i class=" mdi-arrow-right h7">MES
                                    </i></a>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-md-4  mb-2">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <div>
                                <div class="float-left mini-stat-img mr-4">
                                    <span class="fa fa-users" style="font-size: 30px"></span>
                                </div>
                                <h6 class="font-16 text-uppercase mt-0 text-white-50">Total <br>EXP. REJAP</h6>
                            </div>
                            <span class="fa fa-user float-left " style="font-size: 60px; color:cadetblue "></span>
                            <div class="text-right">
                                @if ($cumplenrejaphoy > 0)
                                <h1 class="font-500 text-right"> {{ $cumplenrejaphoy }}</h1>
                                @else
                                <h1>0</h1>
                                @endif
                            </div>
                            <div class="text-right  ">
                                <a href="#hoy3" data-toggle="modal" class="text-white"><i class=" mdi-arrow-right h7">HOY
                                    </i></a>
                                </a>
                            </div>
                            <div class="text-right  ">
                                <a href="{{ route('lista.index', 3) }}" class="text-white"><i class=" mdi-arrow-right h7">MES
                                    </i></a>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-md-4  mb-2">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <div>
                                <div class="float-left mini-stat-img mr-4">
                                    <span class="fa fa-users" style="font-size: 30px"></span>
                                </div>
                                <h6 class="font-16 text-uppercase mt-0 text-white-50">Total <br>EXP. SIPPASE</h6>
                            </div>
                            <span class="fa fa-user float-left " style="font-size: 60px; color:cadetblue "></span>
                            <div class="text-right">
                                @if ($expsippasehoyhoy>0)
                                <h1 class="font-500 text-right"> {{ $expsippasehoyhoy }}</h1>
                                @else
                                <h1>0</h1>
                                @endif
                            </div>
                            <div class="text-right  ">
                                <a href="#hoy4" data-toggle="modal" class="text-white"><i class=" mdi-arrow-right h7">HOY
                                    </i></a>
                                </a>
                            </div>
                            <div class="text-right  ">
                                <a href="{{ route('lista.index', 4) }}"class="text-white"><i class=" mdi-arrow-right h7">MES
                                    </i></a>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-md-4  mb-2">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <div>
                                <div class="float-left mini-stat-img mr-4">
                                    <span class="fa fa-users" style="font-size: 30px"></span>
                                </div>
                                <h6 class="font-16 text-uppercase mt-0 text-white-50">Total <br>EXP. POAI</h6>
                            </div>
                            <span class="fa fa-user float-left " style="font-size: 60px; color:cadetblue "></span>
                            <div class="text-right">
                                @if ($cumplenexppoaihoy > 0)
                                <h1 class="font-500 text-right"> {{ $cumplenexppoaihoy }}</h1>
                                @else
                                <h1>0</h1>
                                @endif
                            </div>
                            <div class="text-right  ">
                                <a href="#hoy5" data-toggle="modal" class="text-white"><i class=" mdi-arrow-right h7">HOY
                                    </i></a>
                                </a>
                            </div>
                            <div class="text-right  ">
                                <a href="{{ route('lista.index', 5) }}" class="text-white"><i class=" mdi-arrow-right h7">MES
                                    </i></a>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-md-4 mb-2 ">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <div>
                                <div class="float-left mini-stat-img mr-4">
                                    <span class="fa fa-users" style="font-size: 30px"></span>
                                </div>
                                <h6 class="font-16 text-uppercase mt-0 text-white-50">Total <br>EXP. PROG. VACACIONES</h6>
                            </div>
                            <span class="fa fa-user float-left " style="font-size: 60px; color:cadetblue "></span>
                            <div class="text-right">
                                @if ($cumplenexpprogvacacionhoy > 0)
                                <h1 class="font-500 text-right"> {{ $cumplenexpprogvacacionhoy }}</h1>
                                @else
                                <h1>0</h1>
                                @endif
                            </div>
                            <div class="text-right  ">
                                <a href="#hoy6" data-toggle="modal" class="text-white"><i class=" mdi-arrow-right h7">HOY
                                    </i></a>
                                </a>
                            </div>
                            <div class="text-right  ">
                                <a href="{{ route('lista.index', 6) }}" class="text-white"><i class=" mdi-arrow-right h7">MES
                                    </i></a>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tab2">
            <hr class="hr">
            <div class="row font-verdana">

                <hr class="hr">

                <div class=" col-md-4  mb-2 ">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <div>
                                <div class="float-left mini-stat-img mr-4">
                                    <span class="fa fa-users" style="font-size: 30px"></span>
                                </div>
                                <h6 class="font-16 text-uppercase mt-0 text-white-50">Total <br>EXP. INDUCCIÓN</h6>
                            </div>
                            <span class="fa fa-user float-left " style="font-size: 60px; color:cadetblue "></span>
                            <div class="text-right">
                                @if ($cumplenexpsippase2hoy > 0)
                                <h1 class="font-500 text-right"> {{ $cumplenexpsippase2hoy }}</h1>
                                @else
                                <h1>0</h1>
                                @endif
                            </div>
                            <div class="text-right  ">
                                <a href="#hoy7" data-toggle="modal" class="text-white"><i class=" mdi-arrow-right h7">HOY
                                    </i></a>
                                </a>
                            </div>
                            <div class="text-right  ">
                                <a href="{{ route('lista.index', 7) }}" class="text-white"><i class=" mdi-arrow-right h7">MES
                                    </i></a>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-md-4  mb-2 ">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <div>
                                <div class="float-left mini-stat-img mr-4">
                                    <span class="fa fa-users" style="font-size: 30px"></span>
                                </div>
                                <h6 class="font-16 text-uppercase mt-0 text-white-50">Total <br>EXP. INDUCCIÓN</h6>
                            </div>
                            <span class="fa fa-user float-left " style="font-size: 60px; color:cadetblue "></span>
                            <div class="text-right">
                                @if ($cumplenrejaphoy2 > 0)
                                <h1 class="font-500 text-right"> {{ $cumplenrejaphoy2 }}</h1>
                                @else
                                <h1>0</h1>
                                @endif
                            </div>
                            <div class="text-right  ">
                                <a href="#hoy8" data-toggle="modal" class="text-white"><i class=" mdi-arrow-right h7">HOY
                                    </i></a>
                                </a>
                            </div>
                            <div class="text-right  ">
                                <a href="{{ route('lista.index', 8) }}" class="text-white"><i class=" mdi-arrow-right h7">MES
                                    </i></a>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>

    </div>
    <div class="row  ">

    </div>

    @include('asistencias.estado-expiraciones.mostrar_emp')
</div>
@section('scripts')
<script>
    $(document).ready(function() {
        $('#empleados-fecha').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5' // Agrega el botón de exportación a Excel
            ]
        });
    });
</script>
@endsection
@endsection
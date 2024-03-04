@extends('layouts.admin')
@section('content')
    <div class="row font-verdana-12">
        <div class="col-md-3 titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-p">
                <a href="{{route('planta.index')}}" class="color-icon-1">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>
            </span>
        </div>
        <div class="col-md-6 titulo">
            <b>GESTIONAR PERSONAL-P/{{$nombrearea}}</b>
        </div>
        <div class="col-md-3 text-right">
            <a href="{{route('planta.crear',$idarea)}}" class="tts:left tts-slideIn tts-custom" aria-label="Registrar">
                <button class="btn btn-sm btn-outline-primary font-verdana" type="button" >
                    &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
        <input type="hidden" value="{{$idarea}}">
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive" >
                <table id="tablaAjax" class="table hoverTable table-bordered" style="width:100%">
                    <thead>
                        <tr class="font-verdana-sm">
                            <td class="text-center p-1" style="vertical-align: bottom;"><i class="fa fa-bars" aria-hidden="true"></i></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><i class="fa fa-bars" aria-hidden="true"></i></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>FILE</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>NOMBRES</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>AP. PATERNO</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>AP. MATERNO</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>CARGO</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>NOMBRE CARGO</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>HAB. BASICO</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>CATEGORIA</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>NIVEL ADM.</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>CLASE</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>NIVEL SAL.</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>F. INGRESO</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>NATALICIO</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>EDAD</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>N° CARNET</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>POAI</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>EXP. POAI</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>DEC. JURADA</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>EXP. DEC. JURADA</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>REJAP</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>SIPPASE</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>EXP. SIPPASE</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>SERV. MILITAR</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>IDIOMA</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>INDUCCION</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>EXP. INDUCCION</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>PROG. VACAC.</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>EXP. PROG. VACAC.</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>VAC. GANADAS</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>VAC. PENDIENTES</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>VAC. USADAS</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>SEG. SALUD</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>INAMOV.</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>AÑOS SERV.</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>CURR. VITAE</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>TELEFONO</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>BIOMETRICO</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>GRADO ACADEM.</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>RAE</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>REG. PROF.</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>EVAL. DESEMP.</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($empleados))
                            @foreach ($empleados as $empleado)
                                <tr class="font-verdana-sm">
                                    <td class="text-center p-1" style="vertical-align: middle;">
                                        <span class="tts:right tts-slideIn tts-custom" aria-label="Modificar">
                                            <a href="{{ route('planta.editar', $empleado->idemp)}}">
                                                <span class="text-primary"><i class="fa-solid fa-xl fa-pen-to-square"></i></span>
                                            </a>
                                        </span>
                                    </td>
                                    <td class="text-center p-1" style="vertical-align: middle;">
                                        <span class="tts:right tts-slideIn tts-custom" aria-label="Activar o Desactivar">
                                            <a href="{{ route('planta.editar2', $empleado->idemp)}}">
                                                <span class="text-warning"><i class="fas fa-xl fa-minus-circle"></i></span>
                                            </a>
                                        </span>
                                    </td>
                                    <td class="text-center p-1">{{$empleado->numfile}}</td>
                                    <td class="text-justify p-1">{{$empleado->nombres}}</td>
                                    <td class="text-justify p-1">{{$empleado->ap_pat}}</td>
                                    <td class="text-justify p-1">{{$empleado->ap_mat}}</td>
                                    <td class="text-justify p-1">{{$empleado->cargo}}</td>
                                    <td class="text-justify p-1">{{$empleado->nombrecargo}}</td>
                                    <td class="text-right p-1">{{$empleado->habbasico}}</td>
                                    <td class="text-center p-1">{{$empleado->categoria}}</td>
                                    <td class="text-center p-1">{{$empleado->niveladm}}</td>
                                    <td class="text-center p-1">{{$empleado->clase}}</td>
                                    <td class="text-center p-1">{{$empleado->nivelsal}}</td>
                                    <td class="text-center p-1">{{$empleado->fechingreso}}</td>
                                    <td class="text-center p-1">{{$empleado->natalicio}}</td>
                                    <td class="text-center p-1">{{$empleado->edad}}</td>
                                    <td class="text-center p-1">{{$empleado->ci}}</td>
                                    <td class="text-center p-1">{{$empleado->poai}}</td>
                                    <td class="text-center p-1">{{$empleado->exppoai}}</td>
                                    <td class="text-center p-1">{{$empleado->decjurada}}</td>
                                    <td class="text-center p-1">{{$empleado->expdecjurada}}</td>
                                    <td class="text-center p-1">{{$empleado->rejap}}</td>
                                    <td class="text-center p-1">{{$empleado->sippase}}</td>
                                    <td class="text-center p-1">{{$empleado->expsippase}}</td>
                                    <td class="text-center p-1">{{$empleado->servmilitar}}</td>
                                    <td class="text-center p-1">{{$empleado->idioma}}</td>
                                    <td class="text-center p-1">{{$empleado->induccion}}</td>
                                    <td class="text-center p-1">{{$empleado->expinduccion}}</td>
                                    <td class="text-center p-1">{{$empleado->progvacacion}}</td>
                                    <td class="text-center p-1">{{$empleado->expprogvacacion}}</td>
                                    <td class="text-center p-1">{{$empleado->vacganadas}}</td>
                                    <td class="text-center p-1">{{$empleado->vacpendientes}}</td>
                                    <td class="text-center p-1">{{$empleado->vacusasdas}}</td>
                                    <td class="text-center p-1">{{$empleado->segsalud}}</td>
                                    <td class="text-center p-1">{{$empleado->inamovilidad}}</td>
                                    <td class="text-center p-1">{{$empleado->aservicios}}</td>
                                    <td class="text-center p-1">{{$empleado->cvitae}}</td>
                                    <td class="text-center p-1">{{$empleado->telefono}}</td>
                                    <td class="text-center p-1">{{$empleado->biometrico}}</td>
                                    <td class="text-center p-1">{{$empleado->gradacademico}}</td>
                                    <td class="text-center p-1">{{$empleado->rae}}</td>
                                    <td class="text-center p-1">{{$empleado->regprofesional}}</td>
                                    <td class="text-center p-1">{{$empleado->evdesempenio}}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@section('scripts')
    <script>
    $(document).ready(function() {
        $('#tablaAjax').DataTable({
            processing: true,
            "iDisplayLength": 10,
            "language":{
                "info": "<span class='font-verdana'>Mostrando _START_ al _END_ de _TOTAL_</span>",
                "search": '',
                "searchPlaceholder": "Buscar",
                "paginate": {
                    "next": "<span class='font-verdana'><b>Siguiente</b></span>",
                    "previous": "<span class='font-verdana'><b>Anterior</b></span>",
                },
                "lengthMenu": "<span class='font-verdana'>Mostrar </span>"+
                                "<select class='form form-control-sm'>"+
                                "<option value='10'>10</option>"+
                                "<option value='50'>50</option>"+
                                "<option value='100'>100</option>"+
                                "<option value='-1'>Todos</option>"+
                                "</select> <span class='font-verdana'>registros</span>",
                "loadingRecords": "<span class='font-verdana'>...Cargando...</span>",
                "processing": "<span class='font-verdana'>...Procesando...</span>",
                "emptyTable": "<span class='font-verdana'>No hay datos</span>",
                "zeroRecords": "<span class='font-verdana'>No hay resultados para mostrar</span>",
                "infoEmpty": "<span class='font-verdana'>Ningun registro encontrado</span>",
                "infoFiltered": "<span class='font-verdana'>(filtrados de un total de _MAX_ registros)</span>"
            }
        });
    });
    </script>
@endsection
@endsection

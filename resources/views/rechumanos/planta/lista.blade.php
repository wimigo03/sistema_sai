@extends('layouts.admin')
@section('content')
    <div class="row font-verdana-bg">
        <div class="col-md-1 titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-p">
                <a href="{{route('planta.index')}}" class="color-icon-1">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>
            </span>
        </div>
        <div class="col-md-10 titulo text-right">
            <b>GESTIONAR PERSONAL-P/{{$nombrearea}}</b>
        </div>
        <div class="col-md-1 text-right">
            @can('planta_create_access')
                <a href="{{route('planta.crear',$idarea)}}" class="tts:left tts-slideIn tts-custom" aria-label="Registrar">
                    <button class="btn btn-sm btn-outline-primary font-verdana" type="button" >
                        &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                    </button>
                </a>
                <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
            @endcan
        </div>
     
    </div>
    <div class="col-md-12">
            <hr class="hrr">
        </div>
        <input type="hidden" value="{{$idarea}}">
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
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>APELLIDO<br>PATERNO</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>APELLIDO<br> MATERNO</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>CARGO</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>NOMBRE<br>CARGO</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>HABER<br>BÁSICO</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>CATEGORIA</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>NIVEL<br> ADMIN.</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>CLASE</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>NIVEL<br> SALARIAL</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>FECHA<br>INGRESO</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>NATALICIO</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>EDAD</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>N° CARNET</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>POAI</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>EXP.<br> POAI</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>DECLARACIÓN<br>JURADA</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>EXP.<br> DEC. JURADA</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>REJAP</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>SIPPASE</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>EXP. SIPPASE</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>SERVICIO<br>MILITAR</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>CERTIFICADO<br>IDIOMA</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>INDUCCIóN</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>EXP. <br>INDUCCIóN</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>PROG.<br> VACACIÓN.</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>EXP. PROG.<br> VACACIÓN.</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>VAC.<br> GANADAS</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>VAC. <br>PENDIENTES</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>VAC.<br> USADAS</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>SEGURO<br>SALUD</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>INAMOVILIDAD.</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>AÑOS<br> SERVICIO.</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>CURRCULUM<br>VITAE</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>TELEF.<br>CELULAR</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>BIOMÉTRICO</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>GRADO<br>ACADÉMICO.</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>RAE</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>REGISTRO<br>PROFESIONAL</b></td>
                            <td class="text-center p-1" style="vertical-align: bottom;"><b>EVALUACIÓN.<br>DESEMPEÑO.</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($empleados))
                            @foreach ($empleados as $empleado)
                                <tr class="font-verdana-sm">
                                    <td class="text-center p-1" style="vertical-align: middle;">
                                        @can('planta_edit_access')
                                            <span class="tts:right tts-slideIn tts-custom" aria-label="Modificar">
                                                <a href="{{ route('planta.editar', $empleado->idemp)}}">
                                                    <span class="text-primary"><i class="fa-solid fa-2xl fa-pen-to-square"></i></span>
                                                </a>
                                            </span>
                                        @endcan
                                    </td>
                                    <td class="text-center p-1" style="vertical-align: middle;">
                                        @can('planta_edit_access')
                                            <span class="tts:right tts-slideIn tts-custom" aria-label="Activar o Desactivar">
                                                <a href="{{ route('planta.editar2', $empleado->idemp)}}">
                                                    <span class="text-warning"><i class="fas fa-2xl fa-minus-circle"></i></span>
                                                </a>
                                            </span>
                                        @endcan
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
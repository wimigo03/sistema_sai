@extends('layouts.admin')
@section('content')
    <div class="row font-verdana-bg">
        <div class="col-md-3 titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a Areas">
                <a href="{{route('areas.index')}}" class="color-icon-1">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>
            </span>
        </div>
        <div class="col-md-6 titulo text-center">
            <b>FILES-P/{{strtoupper($area->nombrearea)}}</b>
        </div>
        <div class="col-md-3 text-right">
            @can('file_create_access')
                <span class="tts:left tts-slideIn tts-custom" aria-label="Nuevo Registro">
                    <a href="{{ route('areas.crearFile', $id) }}" >
                        <span class="btn btn-sm btn-outline-success font-verdana">
                            &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                        </span>
                    </a>
                </span>
            @endcan
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="tablaAjax" class="display responsive table-bordered" style="width:100%">
                <thead>
                    <tr class="font-verdana-sm">
                        <td class="text-center p-1" style="vertical-align: bottom;"><b>N°</b></td>
                        <td class="text-center p-1" style="vertical-align: bottom;"><b>CARGO</b></td>
                        <td class="text-center p-1" style="vertical-align: bottom;"><b>NOMBRE CARGO</b></td>
                        <td class="text-center p-1" style="vertical-align: bottom;"><b>HABER&nbsp;B.</b></td>
                        <td class="text-center p-1" style="vertical-align: bottom;"><b>CATEGORIA</b></td>
                        <td class="text-center p-1" style="vertical-align: bottom;"><b>NIV.&nbsp;ADM.</b></td>
                        <td class="text-center p-1" style="vertical-align: bottom;"><b>CLASE</b></td>
                        <td class="text-center p-1" style="vertical-align: bottom;"><b>NIV.&nbsp;S.</b></td>
                        <td class="text-center p-1" style="vertical-align: bottom;"><b>ESTADO</b></td>
                        <td class="text-center p-1" style="vertical-align: bottom;"><i class="fa fa-bars" aria-hidden="true"></i></td>
                    </tr>
                </thead>
                @if (isset($file))
                    <tbody>
                        @foreach ($file as $files)
                            <tr class="font-verdana-sm">
                                <td class="text-justify p-1">{{$files->numfile}}</td>
                                <td class="text-justify p-1">{{$files->cargo}}</td>
                                <td class="text-justify p-1">{{$files->nombrecargo}}</td>
                                <td class="text-right p-1">{{$files->habbasico}}</td>
                                <td class="text-center p-1">{{$files->categoria}}</td>
                                <td class="text-center p-1">{{$files->niveladm}}</td>
                                <td class="text-center p-1">{{$files->clase}}</td>
                                <td class="text-center p-1">{{$files->nivelsal}}</td>
                                @if ($files->estadofile == 1)
                                    <td class="text-center p-1 text-success"><b>DISPONIBLE</b></td>
                                @else
                                    <td class="text-center p-1 text-danger"><b>OCUPADO</b></td>
                                @endif
                                <td class="text-center p-1">
                                    @can('file_edit_access')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar">
                                            <a href="{{ route('file.edit', $files->idfile) }}" style="color:#017EBE;">
                                                &nbsp;<i class="fas fa-lg fa-edit" aria-hidden="true"></i>&nbsp;
                                            </a>
                                        </span>
                                    @endcan
                                </td>
                            </tr>    
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
    @section('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                $('#tablaAjax').DataTable({
                    "processing":true,
                    "iDisplayLength": 50,
                    "order": [[ 0, "asc" ]],
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
@extends('layouts.admin')
@section('content')
    <div class="row font-verdana-12">
        <div class="col-md-8 titulo">
            <b>AREAS</b>
        </div>
        <div class="col-md-4 text-right">
 
                <a href="{{route('areas.create')}}" class="tts:left tts-slideIn tts-custom" aria-label="Registrar area">
                    <button class="btn btn-sm btn-outline-primary font-verdana" type="button" >
                        &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                    </button>
                </a>
                <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
    
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table-bordered yajra-datatable hoverTable" style="width:70%;">
                <thead>
                    <tr>
                        <td class="text-center p-1"><b>N°</b></td>
                        <td class="text-center p-1"><b>NOMBRE</b></td>
                        <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                        {{--<td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                        <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>--}}
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    @section('scripts')
        <script type="text/javascript">
            $(function() {
                var table = $('.yajra-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ route('areas.list') }}",
                    columns: [
                                {data: 'DT_RowIndex', name: 'DT_RowIndex', class:'text-justify p-1 font-verdana-sm'},
                                {data: 'nombrearea', name: 'nombrearea', class:'text-justify p-1 font-verdana-sm'},
                                {data: 'btn', name: 'btn', orderable: false, class:'text-center p-1'},
                                /*{data: 'btn2', name: 'btn2', orderable: false, class:'text-center p-1'},
                                {data: 'btn3', name: 'btn3', orderable: false, class:'text-center p-1'},*/
                            ],
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

@extends('layouts.admin')
@section('content')


    <br>
    <div class="row font-verdana-12">
        <div class="col-md-8 titulo">

            @include('agenda.search')
        </div>
        <div class="col-md-4 text-right titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                <a href="{{ url('/agenda/indexhoy') }}">
                    <span class="color-icon-1">
                        &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                    </span>
                </a>
            </span>

        </div>

        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 table-responsive">
            <center>
                <table class="table-bordered yajra-datatable hoverTable responsive font-verdana" style="width:100%;">
                    <thead>
                        <tr>
                            <td class="text-justify p-1"><b>N°</b></td>
                            <td class="text-justify p-1"><b>FECHA</b></td>
                            <td class="text-justify p-1"><b>HORA INICIO</b></td>
                            <td class="text-justify p-1"><b>HORA FIN</b></td>
                            <td class="text-justify p-1"><b>EVENTO</b></td>
                            <td class="text-justify p-1"><b>DETALLE</b></td>

                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </center>
        </div>
    </div>
@section('scripts')
    <script type="text/javascript">
        $(function() {

            var table = $('.yajra-datatable').DataTable({
                paging: false,
        ordering: false,
        info: false,
                searching: false,
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ route('agenda.indextotal') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: 'text-justify p-1 font-verdana'
                    },

                    {
                        data: 'fecha2',
                        name: 'ag.fecha2',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'hora1',
                        name: 'ag.hora1',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'hora2',
                        name: 'ag.hora2',
                        class: 'text-justify p-1 font-verdana'
                    },

                    {
                        data: 'evento',
                        name: 'ag.evento',
                        class: 'text-justify p-1 font-verdana'
                    },

                    {
                        data: 'descripcion',
                        name: 'ag.descripcion',
                        class: 'text-justify p-1 font-verdana'
                    }


                ],



                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },


            });



        });
    </script>
@endsection
@endsection

@extends('layouts.admin')

@section('content')

    <style>
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
    <div class="row font-verdana-12">
        <div class="col-md-4 titulo">
            <b>UNIDAD ADMINISTRATIVA</b>
        </div>
        <div class="col-md-8 text-right">

 
                <a href="{{ route('activo.unidadadmin.create') }}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar">
                    <button class="btn btn-sm btn-primary font-verdana" type="button">
                        &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                    </button>
                </a>
                <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
      
        </div>
        <div class="col-md-12">
            <hr class="hrr">
            <b>ENTIDAD: </b>{{ $entidad->desc_ent }}
            <hr class="hrr">
        </div>
    </div>
    <div class="row font-verdana-12">
        <div class="col-md-12">
            <center>
                <table class="table-bordered yajra-datatable" style="width: 100%;">
                    <thead class="font-courier">
                        <tr>
                            <th class="text-center p-1 font-weight-bold"
                                style="background-color: #f9fdfd; color: rgb(12, 12, 12);"><b>N°</b></th>
                            <th class="text-center p-1 font-weight-bold"
                                style="background-color: #f9fdfd; color: rgb(10, 10, 10);"><b>ENTIDAD</b></th>
                            <th class="text-center p-1 font-weight-bold"
                                style="background-color: #f9fdfd; color: rgb(12, 12, 12);"><b>UNIDAD</b></th>
                            <th class="text-center p-1 font-weight-bold"
                                style="background-color: #f9fdfd; color: rgb(8, 8, 8);"><b>DESCRIPCION</b></th>
                            <th class="text-center p-1 font-weight-bold"
                                style="background-color: #f9fdfd; color: rgb(12, 12, 12);"><b>CIUDAD</b></th>
                            <th class="text-center p-1 font-weight-bold"
                                style="background-color: #f9fdfd; color: rgb(12, 12, 12);"><b>ESTADO</b></th>
                            <th class="text-center p-1 font-weight-bold"
                                style="background-color: #f9fdfd; color: rgb(8, 8, 8);">
                                <i class="fa fa-bars" aria-hidden="true"></i>
                            </th>
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
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ route('activo.unidadadmin.list') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'entidad',
                        name: 'entidad',
                        class: 'text-justify p-1 font-verdana',
                        "visible": false,
                    },
                    {
                        data: 'unidad',
                        name: 'unidad',
                        class: 'text-justify p-1 font-verdana',

                    },
                    {
                        data: 'descrip',
                        name: 'descrip',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'ciudad',
                        name: 'ciudad',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'estadouni',
                        name: 'estadouni',
                        render: function(data, type, full, meta) {
                            if (data == 1) {
                                return '<span class="badge badge-success cursor-pointer estado" data-id="' +
                                    full
                                    .idunidadadmin + '">Activo</span>';
                            } else {
                                return '<span class="badge badge-danger cursor-pointer estado" data-id="' +
                                    full
                                    .idunidadadmin + '">Inactivo</span>';
                            }
                        },
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'btn',
                        name: 'btn',
                        orderable: true,
                        searchable: true,
                    },
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


            $('.yajra-datatable tbody').on('click', '.estado', function() {
                var unidadadminId = $(this).data('id');

                $.ajax({
                    url: "/Activo/unidadadmin/" + unidadadminId + "/estado",
                    type: "PUT",
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        table.ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    },
                });
            });
        });
    </script>
@endsection
@endsection

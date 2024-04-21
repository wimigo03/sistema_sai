@extends('layouts.admin')
@section('content')


    <br>
    <div class="row font-verdana-12">
        <div class="col-md-8 titulo">
            <b>RECEPCION VENTANILLA</b>
        </div>
        <div class="col-md-4 text-right titulo">
{{-- CORRESPONDENCIA LOCAL {{ route('crear.recepcion') }} --}}

                <a href="" class="tts:left tts-slideIn tts-custom" aria-label="Agregar Recepcion">
                    <button class="btn btn-sm btn-success font-verdana" type="button">
                        &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                    </button>
                </a>
{{-- CORRESPONDENCIA LOCAL {{ route('crear.recepcion') }} {{ route('recepcion.remitenteIndex') }} --}}
                <a href="" class="tts:left tts-slideIn tts-custom"
                    aria-label="Agregar Persona">
                    <button class="btn btn-sm btn-warning font-verdana" type="button">PERSONA

                    </button>
                </a>
{{-- CORRESPONDENCIA LOCAL {{ route('crear.recepcion') {{ route('recepcion.unidadIndex') }} }} --}}
                <a href="" class="tts:left tts-slideIn tts-custom"
                    aria-label="Agregar Area">
                    <button class="btn btn-sm btn-info font-verdana" type="button">AREA

                    </button>
                </a>






        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 table-responsive">
            <center>
                <table class="table-bordered  hoverTable  responsive  font-verdana" style="width:100%;" id="users-table">
                    <thead>
                        <tr>
                            <td class="text-justify p-1"><b>N°</b></td>
                            <td class="text-justify p-1"><b>NOMBRES</b></td>
                            <td class="text-justify p-1"><b>AP/PAT</b></td>
                            <td class="text-justify p-1"><b>AP/MAT</b></td>
                            <td class="text-justify p-1"><b>UNIDAD</b></td>
                            <td class="text-justify p-1"><b>ASUNTO</b></td>
                            <td class="text-justify p-1"><b>FECHA</b></td>
                            <td class="text-justify p-1"><b>CODIGO</b></td>
                            <td class="text-justify p-1"><b>N/OFICIO</b></td>
                            <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>


                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr  >
                            <th ></th>
                            <th ></th>
                            <th ></th>
                            <th ></th>
                            <th ></th>
                            <th ></th>
                            <th ></th>
                            <th ></th>
                            <th ></th>
                            <th ></th>


                    </tr>

                    </tfoot>
                </table>
            </center>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">

        $('#users-table').DataTable({
            bFilter: true,
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,


            ajax: "{{ route('correspondencia.index') }}",
            columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: 'text-justify p-1 font-verdana'
                    },

                    {
                        data: 'nombres',
                        name: 'e.nombres',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'ap_pat',
                        name: 'e.ap_pat',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'ap_mat',
                        name: 'e.ap_mat',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'nombre_unidad',
                        name: 'u.nombre_unidad',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'asunto',
                        name: 'r.asunto',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'fecha_recepcion',
                        name: 'r.fecha_recepcion',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'n_oficio',
                        name: 'r.n_oficio',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'observaciones',
                        name: 'r.observaciones',
                        class: 'text-justify p-1 font-verdana'
                    },

                    {
                        data: 'btn',
                        name: 'btn',
                        class: 'text-center p-1 font-verdana',
                        orderable: false,
                        searchable: false
                    },



                ],


            initComplete: function () {
            this.api().columns(1).every(function () {
                var column = this;
                var input = document.createElement("input");
                input.style.width = input.style.width = "50px";
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });


            this.api().columns(2).every(function () {
                var column = this;
                var input = document.createElement("input");
                input.style.width = input.style.width = "50px";
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });

            this.api().columns(3).every(function () {
                var column = this;
                var input = document.createElement("input");
                input.style.width = input.style.width = "50px";
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });
            this.api().columns(4).every(function () {
                var column = this;
                var input = document.createElement("input");
                input.style.width = input.style.width = "300px";
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });
            this.api().columns(5).every(function () {
                var column = this;
                var input = document.createElement("input");
                input.style.width = input.style.width = "200px";
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });
            this.api().columns(7).every(function () {
                var column = this;
                var input = document.createElement("input");
                input.style.width = input.style.width = "50px";
                $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column.search(val ? val : '', true, false).draw();
                });
            });


        }
,
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
}

        });
    </script>
@endsection



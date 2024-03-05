@extends('layouts.admin')
@section('content')
    <br>
    <div class="row font-verdana-12">
        <div class="col-md-8 titulo">
            <b>ARCHIVOS LISTADO GENERAL</b>
        </div>

        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 table-responsive">
            <center>
                <table class="table-bordered  hoverTable  responsive  font-verdana" id="users-table">
                    <thead>
                        <tr>

                            <td class="text-justify p-1"><b>Gestion</b></td>
                            <td class="text-justify p-1"><b>Fecha Rec./Env.</b></td>
                            <td class="text-justify p-1"><b>Num.Doc.</b></td>
                            <td class="text-justify p-1"><b>Referencia</b></td>
                            <td class="text-justify p-1"><b>Tipo</b></td>
                            <td class="text-justify p-1"><b>Area</b></td>
                            <td class="text-justify p-1"><b>F.Creacion</b></td>
                            <td class="text-center p-1 font-weight-bold">
                                <i class="fa fa-bars" aria-hidden="true"></i>
                            </td>

                        </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                        <tr>

                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>


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


            ajax: "{{ route('archivos2.index22') }}",
            columns: [

                {
                    data: 'gestion',
                    name: 'a.gestion',
                    class: 'text-justify p-1 font-verdana'
                },

                {
                    data: 'fecha',
                    name: 'a.fecha',
                    class: 'text-justify p-1 font-verdana'
                },

                {
                    data: 'nombrearchivo',
                    name: 'a.nombrearchivo',
                    class: 'text-justify p-1 font-verdana'
                },

                {
                    data: 'referencia',
                    name: 'a.referencia',
                    class: 'text-justify p-1 font-verdana'
                },

                {
                    data: 'nombretipo',
                    name: 't.nombretipo',
                    class: 'text-justify p-1 font-verdana'
                },

                {
                    data: 'nombrearea',
                    name: 'ar.nombrearea',
                    class: 'text-justify p-1 font-verdana'
                },
                {
                    data: 'created_at',
                    name: 'a.created_at',
                    class: 'text-justify p-1 font-verdana'
                },

                {
                    data: 'btn2',
                    name: 'btn2',
                    orderable: false,
                    searchable: false
                }
            ],

            initComplete: function() {
                this.api().columns(0).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "50px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });


                this.api().columns(1).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "75px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });

                this.api().columns(2).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "50px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(3).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "250px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(4).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "150px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(5).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "150px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(6).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "100px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });

            },
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

@extends('layouts.admin')
@section('content')
<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <b>SOLICITUDES PENDIENTES--</b><b style='color:red'>{{$idd->nombrearea}} </b>
        
    </div>

    <div class="col-md-12">
        <hr class="hrr">
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <center>
                        <table   class="table-bordered yajra-datatable hoverTable responsive font-verdana" id="users-table" style="width:100%;">
                            <thead class="font-courier">
                                <tr>
                                    <td class="text-justify p-1"><b>N°</b></td>
                                    <td class="text-justify p-1"><b>FECHA SOL.</b></td>
                                    {{-- <td class="text-justify p-1"><b>REFERENCIA</b></td> --}}
                                    <td class="text-justify p-1"><b>AREA</b></td>
                                    {{-- <td class="text-justify p-1"><b>OFICINA</b></td> --}}
                                    <td class="text-justify p-1"><b>N° CONTROL</b></td>
                                    <td class="text-justify p-1"><b>LOCALIDAD</b></td>
                                    <td class="text-justify p-1"><b>ESTADO</b></td>
                                    <td class="text-justify p-1"><b>ACCIONES</b></td>

                                </tr>
                            </thead>
                            <tbody>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    {{-- <th></th>
                                    <th></th> --}}
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

@section('scripts')
<script type="text/javascript">
$('#users-table').DataTable({


            bFilter: true,
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
        ajax: "{{ route('transportes.pedido.index3') }}",
        columns: [
            {data: 'DT_RowIndex',orderable: false,searchable: false,class:'text-justify p-1 font-verdana'},

            { className: 'text-center', data: 'fechasol',name: 'fechasol'},

            // { className: 'text-center', data: 'referencia',name: 'referencia'},

            { className: 'text-center', data: 'nombrearea',name: 'nombrearea'},

            // { className: 'text-center', data: 'oficina',name: 'oficina'},

            { className: 'text-center', data: 'cominterna',name: 'cominterna'},

            { className: 'text-center', data: 'nombrelocalidad',name: 'nombrelocalidad'},
            { className: 'text-center', data: 'estadosoluconsumo',name: 'estadosoluconsumo'},

            {
                     className: 'text-center',
                     data: 'actions',
                     name: 'actions',
                     orderable: false,
                     searchable: false
                 }


        ],

        initComplete: function() {
                this.api().columns(1).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "80px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });


                this.api().columns(2).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "150px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });

                this.api().columns(3).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "40px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(4).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "140px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(5).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "90px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                       
                // this.api().columns(7).every(function() {
                //     var column = this;
                //     var input = document.createElement("input");
                //     input.style.width = input.style.width = "90px";
                //     $(input).appendTo($(column.footer()).empty())
                //         .on('change', function() {
                //             var val = $.fn.dataTable.util.escapeRegex($(this).val());

                //             column.search(val ? val : '', true, false).draw();
                //         });
                // });

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
@endsection

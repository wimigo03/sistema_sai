@extends('layouts.admin')
@section('content')
<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
     
         <b>SOLICITUDES PENDIENTES--</b><b style='color:red'>{{$idd->nombrearea}} </b>-- 
    </div>
 
    <div class="col-md-12">
        <hr class="hrr">
    </div>

</div>

<div class="row">
    <div class="col-md-12 table-responsive">
        <center>
                        <table  id="users-table" class="table display table-bordered responsive font-verdana" style="width:100%;">
                            <thead class="font-courier">
                                <tr>
                                    <td class="text-justify p-1"><b>N°</b></td>
                                    <td class="text-justify p-1"><b>N° COMPRA</b></td>
                                    <td class="text-justify p-1"><b>FECHA SOL.</b></td>
                                    <td class="text-justify p-1"><b>N° CONTROL</b></td>
                                    <td class="text-justify p-1"><b>OBJETO</b></td>
                                    <td class="text-justify p-1"><b>AREA</b></td>
                                    <td class="text-justify p-1"><b>PROVEEDOR</b></td>
                                    <td class="text-justify p-1"><b>PREVENTIVO</b></td>
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
@section('scripts')
<script type="text/javascript">
$('#users-table').DataTable({

            bFilter: true,
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{{ route('pedidocomb.index') }}",

            columns: [
            
            {data: 'DT_RowIndex',orderable: false,searchable: false,class:'text-justify p-1 font-verdana'},

            {
                    className: 'text-center',
                    data: 'idcompracomb',
                    name: 'idcompracomb'
                },

            {
                    className: 'text-center',
                    data: 'fechasoli',
                    name: 'fechasoli'
                },
                {
                    className: 'text-center',
                    data: 'controlinterno',
                    name: 'controlinterno'
                },
            {
                    className: 'text-center',
                    data: 'objeto',
                    name: 'objeto'
                },
                {
                    className: 'text-center',
                    data: 'nombrearea',
                    name: 'nombrearea'
                },
                {
                    className: 'text-center',
                    data: 'nombreproveedor',
                    name: 'nombreproveedor'
                },
                {
                    className: 'text-center',
                    data: 'preventivo',
                    name: 'preventivo'
                },
            
                {
                    className: 'text-center',
                    data: 'estadocompracomb',
                    name: 'estadocompracomb'
                },
                
                 {
                     className: 'text-justify p-1 font-verdana',
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
                    input.style.width = input.style.width = "80px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });

                this.api().columns(3).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "50px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(4).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "100px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(5).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "100px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                       
                this.api().columns(6).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "90px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });

                this.api().columns(7).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "90px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });

                this.api().columns(8).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "90px";
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
@endsection

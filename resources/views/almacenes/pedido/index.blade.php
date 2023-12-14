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
    <div class="col-md-12 ">
        <center>
            <table   class="table-bordered  hoverTable  responsive  font-verdana" id="users-table">
                <thead >
                                <tr>
                                    <td class="text-justify p-1"><b>N°</b></td>
                                    <td class="text-justify p-1"><b>FECHA SOL.</b></td>
                                    <td class="text-justify p-1"><b>ID VALE</b></td>
                                    <td class="text-justify p-1"><b>AREA PE.</b></td>
                                    <td class="text-justify p-1"><b>FUNCIONARIO</b></td>
                                    <td class="text-justify p-1"><b>CARGO</b></td>
                                    <td class="text-justify p-1"><b>UNIDAD</b></td>
                                    <td class="text-justify p-1"><b>PLACA</b></td>
                                    <td class="text-justify p-1"><b>DESTINO</b></td>
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
        ajax: "{{ route('almacenes.pedido.index') }}",
        columns: [
            {data: 'DT_RowIndex',orderable: false,searchable: false,class:'text-justify p-1 font-verdana'},
            { data: 'fechasolicitud',name: 'fechasolicitud',class:'text-justify p-1 font-verdana'},

            { data: 'idvale',name: 'idvale',class:'text-justify p-1 font-verdana'},

            { data: 'nombrearea',name: 'nombrearea',class:'text-justify p-1 font-verdana'},

            {data: 'usuarionombre',name: 'usuarionombre',class:'text-justify p-1 font-verdana'},

            {data: 'usuariocargo',name: 'usuariocargo',class:'text-justify p-1 font-verdana'},

            {data: 'nombreuconsumo',name: 'nombreuconsumo',class:'text-justify p-1 font-verdana'},
            {data: 'placaconsumo',name: 'placaconsumo',class:'text-justify p-1 font-verdana'},



            {data: 'nombrelocalidad',name: 'nombrelocalidad',class:'text-justify p-1 font-verdana'},
            
            {data: 'estadovale',name: 'estadovale',class:'text-justify p-1 font-verdana'},
         

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
                    input.style.width = input.style.width = "30px";
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
                    input.style.width = input.style.width = "150px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                // this.api().columns(4).every(function() {
                //     var column = this;
                //     var input = document.createElement("input");
                //     input.style.width = input.style.width = "150px";
                //     $(input).appendTo($(column.footer()).empty())
                //         .on('change', function() {
                //             var val = $.fn.dataTable.util.escapeRegex($(this).val());

                //             column.search(val ? val : '', true, false).draw();
                //         });
                // });
                this.api().columns(5).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "110px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(6).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "50px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
             
                this.api().columns(8).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "80px";
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

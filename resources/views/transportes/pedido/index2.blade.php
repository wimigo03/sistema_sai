@extends('layouts.dashboard')
@section('content')
<div class="row font-verdana-12">
    <div class="col-md-8 titulo">
        <b>SOLICITUDES APROVADAS</b><b style='color:red'>{{$idd->nombrearea}} </b>--
    </div>
    <div class="col-md-4 text-right">

              <a href="{{ route('transportes.pedido.index') }}" class="tts:left tts-slideIn tts-custom" 
            aria-label="ir a solicitudes pendientes">
                <button class="btn btn-sm btn-warning font-verdana" type="button" >VOLVER A PENDIENTES
                    &nbsp;<i class="fa-sharp fa-solid fa-thumbs-down" style="font-size:14px"></i>&nbsp;
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
        <center>
            <table   class="table-bordered  hoverTable  responsive  font-verdana" id="users-table">

                            <thead class="font-courier">
                                <tr>
                                    <td class="text-justify p-1"><b>N°</b></td>
                                    <td class="text-justify p-1"><b>REFERENCIA</b></td>
                                    <td class="text-justify p-1"><b>AREA</b></td>
                                    <td class="text-justify p-1"><b>OFICINA</b></td>
                                    <td class="text-justify p-1"><b>N° CONTROL</b></td>
                                    <td class="text-justify p-1"><b>LOCALIDAD</b></td>
                                    <td class="text-center p-1 font-weight-bold">
                                        <i class="fa fa-bars" aria-hidden="true"></i></td>
                                        <td class="text-center p-1 font-weight-bold">
                                            <i class="fa fa-bars" aria-hidden="true"></i></td> 
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
@section('scripts')

<script type="text/javascript">
$('#users-table').DataTable({


            bFilter: true,
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
        ajax: "{{ route('transportes.pedido.index2') }}",
        columns: [
            {data: 'DT_RowIndex',orderable: false,searchable: false,class:'text-justify p-1 font-verdana'},

            { data: 'referencia',name: 's.referencia',class:'text-justify p-1 font-verdana'},

            {data: 'nombrearea',name: 'a.nombrearea',class:'text-justify p-1 font-verdana'},

            {data: 'oficina',name: 's.oficina',class:'text-justify p-1 font-verdana'},

            {data: 'cominterna',name: 's.cominterna',class:'text-justify p-1 font-verdana'},

            {data: 'nombrelocalidad',name: 'lo.nombrelocalidad',class:'text-justify p-1 font-verdana'},

             {data: 'btn', name: 'btn', orderable: false, searchable: false },

             {data: 'btn3', name: 'btn3', orderable: false, searchable: false }

        ],

        initComplete: function() {
                this.api().columns(1).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "150px";
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
                this.api().columns(4).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "80px";
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
},


    });



</script>

@endsection
@endsection

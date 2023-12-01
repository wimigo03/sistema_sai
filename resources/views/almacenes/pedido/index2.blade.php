@extends('layouts.admin')
@section('content')
<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <b>SOLICITUDES APROBADAS</b>
    </div>
    <div class="col-md-4 text-right">
         @can('unidadconsumo_create') 

             <a href="{{ route('almacenes.pedido.index') }}" class="tts:left tts-slideIn tts-custom" 
            aria-label="ir a solicitudes pendientes">
                <button class="btn btn-sm btn-success font-verdana" type="button" >VOLVER ATRAS
                    &nbsp;<i class="fa-solid fa-thumbs-up" style="font-size:14px"></i>&nbsp;
                </button>
            </a> 

            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>

            <a href="{{route('almacenes.pedido.index3')}}" class="tts:left tts-slideIn tts-custom" 
            aria-label="  Aprobadas">
                <button class="btn btn-sm btn-primary font-verdana" type="button" >Solic. Aprobadas
                    &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
         @endcan 
    </div>

  

    <div class="col-md-12">
        <hr class="hrr">
    </div>

</div>

<div class="row">
    <div class="col-md-12 table-responsive">
        <center>
                        <table class="table-bordered  hoverTable  responsive  font-verdana" id="users-table">
                            <thead >
                                <tr>
                                    <td class="text-justify p-1"><b>N°</b></td>
                                    <td class="text-justify p-1"><b>ID VALE</b></td>
                                    <td class="text-justify p-1"><b>AREA PE.</b></td>
                                    <td class="text-justify p-1"><b>FUNCIONARIO</b></td>
                                    <td class="text-justify p-1"><b>CARGO</b></td>
                                    <td class="text-justify p-1"><b>UNIDAD</b></td>
                                    <td class="text-justify p-1"><b>PLACA</b></td>
                                    <td class="text-justify p-1"><b>DESTINO</b></td>
                                 
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
        ajax: "{{ route('almacenes.pedido.index2') }}",
        columns: [
            {
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    class: 'text-justify p-1 font-verdana'
                },
                { data: 'idvale',name: 'v.idvale',class:'text-justify p-1 font-verdana'},

            { data: 'nombrearea',name: 'a.nombrearea',class:'text-justify p-1 font-verdana'},

            {data: 'usuarionombre',name: 'v.usuarionombre',class:'text-justify p-1 font-verdana'},

            {data: 'usuariocargo',name: 'v.usuariocargo',class:'text-justify p-1 font-verdana'},

            {data: 'marcaconsumo',name: 'v.marcaconsumo',class:'text-justify p-1 font-verdana'},

            {data: 'placaconsumo',name: 'v.placaconsumo',class:'text-justify p-1 font-verdana'},

            {data: 'nombrelocalidad',name: 'v.nombrelocalidad',class:'text-justify p-1 font-verdana'},


            {data: 'btn3', name: 'btn3', orderable: false, searchable: false }

        ],


        initComplete: function() {
                this.api().columns(1).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "50px";
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
                    input.style.width = input.style.width = "120px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(5).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "80px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(6).every(function() {
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
}


    });



</script>

@endsection
@endsection

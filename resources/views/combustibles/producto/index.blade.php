@extends('layouts.admin')
@section('content')
<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <b>LISTA--PRODUCTOS--</b><b style='color:orange'>{{ $idd->nombrearea }} </b>--
    </div>
    <div class="col-md-4 text-right">


        <a href="{{ route('producto.create') }}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar">
                <button class="btn btn-sm btn-primary font-verdana" type="button" >
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
        <center>
                        <table class="table-bordered yajra-datatable hoverTable responsive font-verdana" style="width:100%;">
                            <thead class="font-courier">
                                <tr>
                                    <td class="text-center p-1 font-weight-bold"><b>N°</b></td>
                                    <td class="text-center p-1 font-weight-bold"><b>CODIGO</b></td>
                                    <td class="text-center p-1 font-weight-bold"><b>NOMBRE</b></td>
                                    <td class="text-center p-1 font-weight-bold"><b>PRECIO</b></td>
                                    <td class="text-center p-1 font-weight-bold"><b>MEDIDA</b></td>
                                    <td class="text-center p-1 font-weight-bold"><b>CANTIDAD</b></td>
                                    <td class="text-center p-1 font-weight-bold"><b>TOTAL</b></td>
                                    <td class="text-center p-1 font-weight-bold"><b>STOCK MIN</b></td>
                                    <td class="text-center p-1 font-weight-bold"><b>STOCK MAX</b></td>
                                    <td class="text-center p-1 font-weight-bold"><b>PARTIDA</b></td>
                                   

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
$(function() {

    var table = $('.yajra-datatable').DataTable({


        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: "{{ route('producto.list') }}",
        columns: [
            {data: 'DT_RowIndex',orderable: false,searchable: false,class:'text-justify p-1 font-verdana'},

            { data: 'detalleprodcomb',name: 'p.detalleprodcomb',class:'text-justify p-1 font-verdana'},
            { data: 'nombreprodcomb',name: 'p.nombreprodcomb',class:'text-justify p-1 font-verdana'},
            {data: 'precioprodcomb',name: 'p.precioprodcomb',class:'text-justify p-1 font-verdana'},
            {data: 'nombremedida',name: 'me.nombremedida',class:'text-justify p-1 font-verdana'},

           
            {data: 'cantidadproducto',name: 'p.cantidadproducto',class:'text-justify p-1 font-verdana'},
            {data: 'subtotalproducto',name: 'p.subtotalproducto',class:'text-justify p-1 font-verdana'},
            {data: 'cantidadminima',name: 'p.cantidadminima',class:'text-justify p-1 font-verdana'},
            {data: 'cantidadmaxima',name: 'p.cantidadmaxima',class:'text-justify p-1 font-verdana'},

            {data: 'codigopartida',name: 'pt.codigopartida',class:'text-justify p-1 font-verdana'},

            {
                data: 'btn',
                name: 'btn',
                orderable: true,
                searchable: true
            },
        ],

        initComplete: function() {
                this.api().columns(1).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "120px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });


                this.api().columns(2).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "120px";
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
                    input.style.width = input.style.width = "50px";
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

                this.api().columns(9).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "50px";
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



});
</script>

@endsection
@endsection

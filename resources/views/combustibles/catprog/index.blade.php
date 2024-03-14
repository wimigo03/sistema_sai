@extends('layouts.admin')
@section('content')
<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <b>CATEGORIAS PROGRAMATICAS--</b><b style='color:red'>{{$idd->nombrearea}} </b>
    </div>
    <div class="col-md-4 text-right titulo">
  
        @can('catprogcomb.create')
            <a href="{{route('catprogcomb.create')}}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar">
                <button class="btn btn-sm btn-primary font-verdana" type="button" >
                    &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
                </button>
            </a>

            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
            @endcan
    </div>

    <div class="col-md-12">
        <hr class="hrr">
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <center>
                <table  class="table hoverTable yajra-datatable table-bordered responsive font-verdana" style="width:100%;">
                    <thead class="font-courier">
                            <tr>
                                    <td class="text-justify p-1"><b>N°</b></td>
                                    <td class="text-justify p-1"><b>FECHA</b></td>
                                    <td class="text-justify p-1"><b>GESTION</b></td>
                                    <td class="text-justify p-1"><b>N° ID</b></td>
                                    <td class="text-justify p-1"><b>CODIGO</b></td>

                                    <td class="text-justify p-1"><b>NOMBRE</b></td>
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
        ajax: "{{ route('catprogcomb.listado') }}",
        columns: [
            {data: 'DT_RowIndex',orderable: false,searchable: false,class:'text-justify p-1 font-verdana'},
            {data: 'fechacat',name: 'fechacat',class:'text-justify p-1 font-verdana'},
            {data: 'gestioncat',name: 'gestioncat',class:'text-justify p-1 font-verdana'},
            {data: 'idcatprogramaticacomb',name: 'idcatprogramaticacomb',class:'text-justify p-1 font-verdana'},
            {data: 'codcatprogramatica',name: 'codcatprogramatica',class:'text-justify p-1 font-verdana'},
            {data: 'nombrecatprogramatica',name: 'nombrecatprogramatica',class:'text-justify p-1 font-verdana'},
                {data: 'estadocatprogramatica',name: 'estadocatprogramatica',class:'text-justify p-1 font-verdana'},
         
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
                    input.style.width = input.style.width = "110px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });

                this.api().columns(3).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "70px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });  
                
                
                this.api().columns(4).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "110px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(5).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "260px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(6).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "110px";
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
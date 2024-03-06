@extends('layouts.admin')

@section('content')
<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <b>COMPROBANTE DE EGRESO--</b><b style='color:red'>{{$idd->nombrearea}} </b>--
    </div>
    <div class="col-md-4 text-right titulo">
        <a href="{{route('comegreso.create')}}" class="tts:left tts-slideIn tts-custom" 
        aria-label="  Solicitud">
            <button class="btn btn-sm btn-success font-verdana" type="button" >Agreg.Solic.
                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
            </button>
        </a>
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <center>
            <table  id="users-table"   class="table-bordered yajra-datatable hoverTable responsive font-verdana" style="width:100%;">
                <thead class="font-courier">
                                <tr>
                                    <td class="text-justify p-1"><b>N°</b></td>
                                    <td class="text-justify p-1"><b>Cpbte</b></td>
                                    <td class="text-justify p-1"><b>FECHA</b></td>
                                    <td class="text-justify p-1"><b>TIPO</b></td>
                                    <td class="text-justify p-1"><b>N° VALE</b></td>
                                    <td class="text-justify p-1"><b>PROYECTO</b></td>
                                    <td class="text-justify p-1"><b>AREA</b></td>
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

             ajax: "{{ route('comegreso.index') }}",
            columns: [
                {data: 'DT_RowIndex',orderable: false,searchable: false,class:'text-justify p-1 font-verdana'},
                {data: 'idcomegreso',name: 'idcomegreso',className:'text-center'},
                {data: 'fechaegreso',name: 'fechaegreso',className:'text-center'},
                {data: 'nombrecoming',name: 'nombrecoming',className:'text-center'},
                {data: 'numvale',name: 'numvale',className:'text-center'},
                {data: 'codcatprogramatica',name: 'codcatprogramatica',className:'text-center'},
                {data: 'nombrearea',name: 'nombrearea',className:'text-center'},
               {
                   
                    data: 'estadoegreso',
                    name: 'estadoegreso',
                    className: 'text-center'
                },
                
                 {
                     
                     data: 'actions',
                     name: 'actions',
                     className: 'text-justify p-1 font-verdana',
                     orderable: false,
                     searchable: false
                 }
            ],
            initComplete: function() {
                this.api().columns(1).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "40px";
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
                    input.style.width = input.style.width = "130px";
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

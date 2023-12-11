@extends('layouts.admin')
@section('content')
<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <b>UNIDAD DE TRANSPORTE -- </b><b style='color:red'>{{$idd->nombrearea}} </b>--
    </div>
    <div class="col-md-4 text-right">
        @can('unidadconsumo_create')

            <a href="{{ route('transportes.uconsumo.create') }}" class="tts:left tts-slideIn tts-custom" aria-label="CREAR NUEVO">
                <button class="btn btn-sm btn-success font-verdana" type="button" >create nuevo
                    &nbsp;<i class="fa-solid fa-thumbs-up" style="font-size:14px"></i>&nbsp;
                </button>
            </a>
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
            @endcan
            @can('unidadconsumo_ocupados')
            <a href="{{ route('transportes.uconsumo.index2') }}" class="tts:left tts-slideIn tts-custom" aria-label="CREAR NUEVO">
                <button class="btn btn-sm btn-primary font-verdana" type="button" >Ocupados
                    &nbsp;<i class="fa-solid fa-xmark" style="font-size:14px"></i>&nbsp;
                </button>
            </a>
        @endcan
    </div>

     
  
    <div class="col-md-12">
        <hr class="hrr">
    </div>
  
  <div class="col-md-6">
    
    
    
</div>

</div>

<div class="row">
    <div class="col-md-12">
        <center>
            
                        <table class="table-bordered  hoverTable  responsive  font-verdana" id="users-table">
                            <thead >
                                <tr>
                                    <td class="text-justify p-1"><b>N°</b></td>
                                    <td class="text-justify p-1"><b>CODIGO</b></td>
                                    <td class="text-justify p-1"><b>NOMBRE</b></td>
                                    <td class="text-justify p-1"><b>PLACA</b></td>
                                    <td class="text-justify p-1"><b>TIPO</b></td>
                                    <td class="text-justify p-1"><b>AREA</b></td>
                                    <td class="text-justify p-1"><b>DOCUMENTO</b></td>
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
            ajax: "{{ route('transportes.uconsumo.index') }}",
            columns: [
                {data: 'DT_RowIndex',orderable: false,searchable: false,class:'text-justify p-1 font-verdana'},
    
                { data: 'codigoconsumo',name: 'u.codigoconsumo',class:'text-justify p-1 font-verdana'},
               
                { data: 'nombreuconsumo',name: 'u.nombreuconsumo',class:'text-justify p-1 font-verdana'},
    
                {data: 'placaconsumo',name: 'u.placaconsumo',class:'text-justify p-1 font-verdana'},
               
                {data: 'nombremovilidad',name: 't.nombremovilidad',class:'text-justify p-1 font-verdana'},
    
                {data: 'nombrearea',name: 'a.nombrearea',class:'text-justify p-1 font-verdana'},
    
                {data: 'documento',name: 'documento',  render: function (data, type, full, meta) {
                    return '<img src="../../Imagenes/' + data + '" alt="Imagen" width="70" height="70">';
                },
                class: 'text-center' 
            },
    
    
                {data: 'btn', name: 'btn', orderable: false, searchable: false },
    
                {data: 'btn2', name: 'btn2', orderable: false, searchable: false }
    
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
    }
});

        </script>

@endsection
@endsection

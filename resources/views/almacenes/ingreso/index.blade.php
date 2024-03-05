@extends('layouts.admin')

@section('content')
<div class="row font-verdana-12">
    <div class="col-md-8 titulo">
        <b>ALMACEN--</b><b style='color:red'>{{$idd->nombrearea}} </b>--
    </div>

    <div class="col-md-12">
        <hr class="hrr">
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <center>
                        <table  class="table-bordered yajra-datatable hoverTable responsive font-verdana" style="width:100%;">
                            <thead class="font-courier">
                                <tr>
                                    <td class="text-justify p-1"><b>N°</b></td>
                                    <td class="text-justify p-1"><b>PRODUCTO</b></td>
                                    <td class="text-justify p-1"><b>CANTIDAD</b></td>
                                    <td class="text-justify p-1"><b>SUBTOTAL</b></td>
                                    <td class="text-justify p-1"><b>PRECIO</b></td>
                                    <td class="text-justify p-1"><b>PARTIDA</b></td>
                                    <td class="text-justify p-1"><b>PROYECTO</b></td>

                                     <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td> 
                                     <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td> 
                                    <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

        </center>
    </div>
</div>

<center>
    <div class="container" mt-5>
        <div class="row">
            <div class="col">
                <div id="container"></div>
                </div>
            
            </div>
        
        </div>
    </center>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">

@section('scripts')


<script type="text/javascript">

    $(document).ready(function() {
        
       
    
        var table = $('.yajra-datatable').DataTable({




            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{{ route('almacenes.ingreso.index') }}",
            columns: [
                {data: 'DT_RowIndex',orderable: false,searchable: false,class:'text-justify p-1 font-verdana'},
                {data: 'nombreproducto',name: 'ing.nombreproducto',class:'text-justify p-1 font-verdana'},
                {data: 'cantidad',name: 'ing.cantidad',class:'text-justify p-1 font-verdana'},
                {data: 'subtotal',name: 'ing.subtotal',class:'text-justify p-1 font-verdana'},
                {data: 'precio',name: 'ing.precio',class:'text-justify p-1 font-verdana'},
                {data: 'nombrepartida',name: 'ing.nombrepartida',class:'text-justify p-1 font-verdana'},
                {data: 'nombrecatprogmai',name: 'ing.nombrecatprogmai',class:'text-justify p-1 font-verdana'},
                
                {data: 'btn2', name: 'btn2', orderable: false, searchable: false },
                {data: 'btn3', name: 'btn3', orderable: false, searchable: false },
                {data: 'btn4', name: 'btn4', orderable: false, searchable: false },
            ],

            
            
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

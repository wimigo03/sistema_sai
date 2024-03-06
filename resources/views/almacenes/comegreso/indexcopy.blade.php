@extends('layouts.admin')
@section('content')
<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <b>ALMACEN</b>
    </div>
    <div class="col-md-4 text-right">
   
   {{-- optimize asdfasdfads --}}

   {{-- fixme asdfasdf --}}

             <a href="{{ route('combustibles.ingreso.index') }}" class="tts:left tts-slideIn tts-custom" aria-label="CREAR NUEVO">
                <button class="btn btn-sm btn-success font-verdana" type="button" >create nuevo
                    &nbsp;<i class="fa-solid fa-thumbs-up" style="font-size:14px"></i>&nbsp;
                </button>
            </a> 

            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" 
            style="display: none;"></i>

    
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
                                    <td class="text-justify p-1"><b>PROGRAMA</b></td>
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

<div class="container" mt-5>
    <div class="row">
        <div class="col">
            <div id="container"> aqui</div>
            </div>
        
        </div>
    
    </div>

@section('scripts')


<script type="text/javascript">

    $(document).ready(function() {
     
    
        var table = $('.yajra-datatable').DataTable({




            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{{ route('combustibles.ingreso.index') }}",
            columns: [
                {data: 'DT_RowIndex',orderable: false,searchable: false,class:'text-justify p-1 font-verdana'},
                { data: 'nombreproducto',name: 'ing.nombreproducto',class:'text-justify p-1 font-verdana'},
                {data: 'cantidad',name: 'ing.cantidad',class:'text-justify p-1 font-verdana'},
                {data: 'subtotal',name: 'ing.subtotal',class:'text-justify p-1 font-verdana'},
                {data: 'precio',name: 'ing.precio',class:'text-justify p-1 font-verdana'},
                {data: 'nombrepartida',name: 'ing.nombrepartida',class:'text-justify p-1 font-verdana'},
                {data: 'nombreprograma',name: 'ing.nombreprograma',class:'text-justify p-1 font-verdana'},
                {data: 'btn2', name: 'btn2', orderable: false, searchable: false },
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

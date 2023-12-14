@extends('layouts.admin')
@section('content')
<br>
<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <b>SOLICITUD DE UNIDAD -- </b><b style='color:red'>{{$idd->nombrearea}} </b>--
    </div>
    <div class="col-md-4 text-right titulo">
        
   

        <a href="{{route('transportes.pedidoparcial.create')}}" class="tts:left tts-slideIn tts-custom" 
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
    <div class="col-md-12 table-responsive">
        <center>
            <table id="dataTable" class="table display table-bordered responsive font-verdana" style="width:100%">
                <thead>
                    <tr>
                        <td class="text-justify p-1"><b>Nro</b></td>
                        <td class="text-justify p-1"><b>FECHA SOL.</b></td>
                        <td class="text-justify p-1"><b>COM.INTERNA</b></td>
                        <td class="text-justify p-1"><b>referencia</b></td>
                        <td class="text-justify p-1"><b>AREA</b></td>
                        <td class="text-justify p-1"><b>ESTADO</b></td>
                         <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td> 
                         
                   
                    </tr>
                </thead>
                <tbody>
                    @php
                   
                    $num = 1;
                @endphp
                    @forelse ($soluconsumos as $key => $sol)
                        <tr>
                            <td class="text-justify p-1">{{$key+1}}</td>
                            <td class="text-justify p-1">{{$sol->fechasol}}</td>
                            <td class="text-justify p-1">{{$sol->cominterna}}</td>
                            <td class="text-justify p-1">{{$sol->referencia}}</td>
                            <td class="text-justify p-1">{{$sol->nombrearea}}</td>

                            @if($sol->estadosoluconsumo == '1')
                            <td class="text-justify p-1">
                            <b style="color: green">Pendiente</b></td>
                            @elseif($sol->estadosoluconsumo == '3')
                            <td class="text-justify p-1">
                            <b style="color: blue">Aprobada</b></td>
                            @elseif($sol->estadosoluconsumo == '10')
                            <td class="text-justify p-1">
                                <b style="color: red">Rechazada</b></td>
                            @endif

                            @if($sol->estadosoluconsumo == '1')
                            <td style="padding: 0;" class="text-center p-1">
                               
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar Solicitud">
                                        <a href="{{route('transportes.pedidoparcial.editar',$sol->idsoluconsumo)}}">
                                            <span class="text-warning">
                                                <i class="fa-solid fa-2xl fa-square-pen"></i>
                                            </span>
                                        </a>
                                    </span>
                             
                                </td>


                                @elseif($sol->estadosoluconsumo == '3')

                                <td style="padding: 0;" class="text-center p-1">
                                    
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar Compra">
                                            <a href="{{route('transportes.pedidoparcial.solicitud',$sol->idsoluconsumo)}}">
                                                <span class="text-primary">
                                                    <i class="fa-solid fa-2xl fa-print"></i>
                                                </span>
                                            </a>
                                        </span>
                                    
                                    </td>


                                    @elseif($sol->estadosoluconsumo == '10')

                                    <td style="padding: 0;" class="text-center p-1">
                                        
                                             <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar Compra">
                                                 <a href="{{route('transportes.pedidoparcial.editrechazado',$sol->idsoluconsumo)}}">
                                                     <span class="text-warning">
                                                         <i class="fa-solid fa-2xl fa-square-pen"></i>
                                                     </span>
                                                 </a>
                                             </span>
                                          
                                            </td>
                                    @endif 
                              
 
                        </tr>
                    @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted py-3">No existen registros</td>
                    </tr>
                    @endforelse
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
                      
                      
                    </tr>

                </tfoot>

            </table>
        </center>
    </div>
</div>
@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({

            initComplete: function() {
                this.api().columns(1).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "100px";
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
                    input.style.width = input.style.width = "120px";
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
order: [[ 0, "desc" ]],
        });
    });
   
</script>
@endsection
@endsection

@extends('layouts.admin')
@section('content')
<br>
<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <b>SOLICITUD DE COMBUSTIBLE -- </b><b style='color:red'>{{$idd->nombrearea}} </b>--
    </div>

    <div class="col-md-4 text-right titulo">
        @can('pedidoparcialcomb.create')
        <a href="{{route('pedidoparcialcomb.create')}}" class="tts:left tts-slideIn tts-custom" 
        aria-label="Agregar Solicitud">
            <button class="btn btn-sm btn-success font-verdana" type="button" >Agreg. Solic.
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
            <table id="dataTable"  class="table display table-bordered responsive font-verdana" style="width:100%">
                <thead>
                    <tr>
                        <td class="text-justify p-1"><b>N°</b></td>
                        <td class="text-justify p-1"><b>N° COMPRA</b></td>
                        <td class="text-justify p-1"><b>FECHA SOL.</b></td>
                        <td class="text-justify p-1"><b>FECHA RESP.</b></td>
                        <td class="text-justify p-1"><b>N° SOL.</b></td>
                        <td class="text-justify p-1"><b>OBJETO</b></td>
                        <td class="text-justify p-1"><b>AREA</b></td>
                        <td class="text-justify p-1"><b>ESTADO</b></td>
                        <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                         <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>

                    </tr>
                </thead>
                <tbody>
                    @php
                   
                    $num = 1;
                @endphp
                    @forelse ($compras as $key => $comp)
                        <tr>
                            <td class="text-justify p-1">{{$key+1}}</td>
                            <td class="text-justify p-1">{{$comp->idcompracomb}}</td>
                            <td class="text-justify p-1">{{$comp->fechasoli}}</td>
                            @if($comp->fechaaprob == '')
                            <td class="text-justify p-1">
                            <b style="color: green">Pendiente</b></td>
                            @elseif($comp->fechaaprob !== '')
                            <td class="text-justify p-1">{{$comp->fechaaprob}}</td>
                            @endif

                            <td class="text-justify p-1">{{$comp->controlinterno}}</td>
                            <td class="text-justify p-1">{{$comp->objeto}}</td>
                            <td class="text-justify p-1">{{$comp->nombrearea}}</td>

                            @if($comp->estadocompracomb == '0')
                            <td class="text-justify p-1">
                            <b style="color: green">Pendiente</b></td>

                            @elseif($comp->estadocompracomb == '1')
                            <td class="text-justify p-1">
                            <b style="color: green">Pendiente</b></td>

                            @elseif($comp->estadocompracomb == '2')
                            <td class="text-justify p-1">
                            <b style="color: blue">Aprobado</b></td>

                            
                            @elseif($comp->estadocompracomb == '5')
                            <td class="text-justify p-1">
                                <b style="color: purple">Almacen</b></td>

                            @elseif($comp->estadocompracomb == '10')
                            <td class="text-justify p-1">
                                <b style="color: red">Rechazada</b></td>
                            @endif

                            @if($comp->estadocompracomb == '0')
                            @can('pedidoparcialcomb.editaruno') 
                            <td style="padding: 0;" class="text-center p-1">
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar Compra">
                                        <a href="{{route('pedidoparcialcomb.editaruno',$comp->idcompracomb)}}">
                                            <span class="text-warning">
                                                <i class="fa-solid fa-2xl fa-square-pen"></i>
                                            </span>
                                        </a>
                                    </span>
                                </td>
                                @endcan 
                                    @can('pedidoparcialcomb.edit') 
                                 <td style="padding: 0;" class="text-center p-1">
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
                                    <a href="{{route('pedidoparcialcomb.edit',$comp->idcompracomb)}}">
                                        <span class="text-primary">
                                            <i class="fa-solid fa-2xl fa-square-info"></i>
                                        </span>
                                    </a>
                                </span>
                            </td>
                            @endcan 
                            @elseif($comp->estadocompracomb == '1')
                            @can('pedidoparcialcomb.editar') 
                            <td style="padding: 0;" class="text-center p-1">
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar Compra">
                                    <a href="{{route('pedidoparcialcomb.editar',$comp->idcompracomb)}}">
                                        <span class="text-warning">
                                            <i class="fa-solid fa-2xl fa-square-pen"></i>
                                        </span>
                                    </a>
                                </span>
                            </td>
                            @endcan 
                            @can('pedidoparcialcomb.edit') 
                            <td style="padding: 0;" class="text-center p-1">
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
                                    <a href="{{route('pedidoparcialcomb.edit',$comp->idcompracomb)}}">
                                        <span class="text-primary">
                                            <i class="fa-solid fa-2xl fa-square-info"></i>
                                        </span>
                                    </a>
                                </span>
                            </td>
                            @endcan 
                            @elseif($comp->estadocompracomb == '2')
                            @can('pedidoparcialcomb.ver') 
                            <td style="padding: 0;" class="text-center p-1">
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar Compra">
                                        <a href="{{route('pedidoparcialcomb.ver',$comp->idcompracomb)}}">
                                            <span class="text-warning">
                                                <i class="fa-solid fa-2xl fa-square-pen"></i>
                                            </span>
                                        </a>
                                    </span>
                                </td>
                                @endcan 
                              
                                @can('pedidoparcialcomb.editable') 
                            <td style="padding: 0;" class="text-center p-1">
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
                                    <a href="{{route('pedidoparcialcomb.editable',$comp->idcompracomb)}}">
                                        <span class="text-primary">
                                            <i class="fa-solid fa-2xl fa-square-info"></i>
                                        </span>
                                    </a>
                                </span>
                            </td>
                       
                            @endcan 
                            
                            @elseif($comp->estadocompracomb == '5')
                        
                            @can('pedidoparcialcomb.vercinco') 
                            <td style="padding: 0;" class="text-center p-1">
                                     <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar Compra">
                                         <a href="{{route('pedidoparcialcomb.vercinco',$comp->idcompracomb)}}">
                                             <span class="text-warning">
                                                 <i class="fa-solid fa-2xl fa-square-pen"></i>
                                             </span>
                                         </a>
                                     </span>
                                 </td>
                                 @endcan 
                             
                                 @can('pedidoparcialcomb.editalma') 
                             <td style="padding: 0;" class="text-center p-1">
                                 <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
                                     <a href="{{route('pedidoparcialcomb.editalma',$comp->idcompracomb)}}">
                                         <span class="text-primary">
                                             <i class="fa-solid fa-2xl fa-square-info"></i>
                                         </span>
                                     </a>
                                 </span>
                             </td>
                             @endcan 
                             
                             @elseif($comp->estadocompracomb == '10')
                             
                             @can('pedidoparcialcomb.verdiez') 
                           <td style="padding: 0;" class="text-center p-1">
                             
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar Compra">
                                        <a href="{{route('pedidoparcialcomb.verdiez',$comp->idcompracomb)}}">
                                            <span class="text-warning">
                                                <i class="fa-solid fa-2xl fa-square-pen"></i>
                                            </span>
                                        </a>
                                    </span>
                                </td>
                                @endcan 
                                 @can('pedidoparcialcomb.editrecha') 
                            <td style="padding: 0;" class="text-center p-1">
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
                                    <a href="{{route('pedidoparcialcomb.editrecha',$comp->idcompracomb)}}">
                                        <span class="text-primary">
                                            <i class="fa-solid fa-2xl fa-square-info"></i>
                                        </span>
                                    </a>
                                </span>
                            </td>
                            @endcan 
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
                        <th></th>
                        <th></th>
                        <th></th>
                      
                    </tr>

                </tfoot>

            </table>
        </center>
    </div>
</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({

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
                    input.style.width = input.style.width = "80px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(4).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "50px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(5).every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    input.style.width = input.style.width = "190px";
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
                this.api().columns(7).every(function() {
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
},
order: [[ 0, "asc" ]],
        });
    });
  
</script>
@endsection

@extends('layouts.admin')

@section('content')
<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <b>BALANCE INICIAL--</b><b style='color:red'>{{$idd->nombrearea}} </b>
        {{-- <b>COMPROBANTE DE INGRESO--</b><b style='color:red'>{{$idd->nombrearea}} </b> --}}
    </div>
    <div class="col-md-4 text-right titulo">
        <a href="{{route('comingreso.create')}}" class="tts:left tts-slideIn tts-custom" 
        aria-label="  Solicitud">
            <button class="btn btn-sm btn-success font-verdana" type="button" >Agreg.Regist.
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
                        <table id="dataTable"  class="table display table-bordered responsive font-verdana" style="width:100%;">
                            <thead >
                                <tr>
                                    <td class="text-justify p-1"><b>N°</b></td>
                                    <td class="text-justify p-1"><b>CPBTE</b></td>
                                    <td class="text-justify p-1"><b>GESTION</b></td>
                                    <td class="text-justify p-1"><b>FECHA</b></td>
                                    <td class="text-justify p-1"><b>PROVEEDOR</b></td>
                                    <td class="text-justify p-1"><b>AREA</b></td>
                                    <td class="text-justify p-1"><b>PROYECTO.</b></td>
                                    <td class="text-justify p-1"><b>N° SOLIC.</b></td>
                                    <td class="text-justify p-1"><b>N° COMPRA.</b></td>
                                    <td class="text-justify p-1"><b>ESTADO</b></td>
                                     <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td> 
                                     <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td> 
                                </tr>
                            </thead>
                            <tbody>
                              
                                    @php
                                   
                                    $num = 1;
                                @endphp
                                    @forelse ($ingresos as $key => $comp)
                                        <tr>
                                            <td class="text-justify p-1">{{$key+1}}</td>
                                            <td class="text-justify p-1">{{$comp->idcomingreso}}</td>
                                            <td class="text-justify p-1">{{$comp->gestion}}</td>
                                            <td class="text-justify p-1">{{$comp->fechaingreso}}</td>
                                            <td class="text-justify p-1">{{$comp->nombreproveedor}}</td>

                                            <td class="text-justify p-1">{{$comp->nombrearea}}</td>   
                                            <td class="text-justify p-1">{{$comp->codcatprogramatica}}</td>
                                            <td class="text-justify p-1">{{$comp->numsolicitud}}</td>
                                            <td class="text-justify p-1">{{$comp->numcompra}}</td>
                                         
                                            @if($comp->estadoingreso == '1')
                                            <td class="text-justify p-1">
                                            <b style="color: green">Pendiente</b></td>
                
                                            @elseif($comp->estadoingreso == '2')
                                            <td class="text-justify p-1">
                                            <b style="color: blue">Aprobado</b></td>
                
                                            
                                            @elseif($comp->estadoingreso == '5')
                                            <td class="text-justify p-1">
                                                <b style="color: purple">Almacen</b></td>
                
                                            @elseif($comp->estadoingreso == '10')
                                            <td class="text-justify p-1">
                                                <b style="color: red">Rechazada</b></td>
                                            @endif
                
                                            @if($comp->estadoingreso == '1')
                                            <td style="padding: 0;" class="text-center p-1">
                                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar">
                                                        <a href="{{route('comingreso.editarn',$comp->idcomingreso)}}">
                                                            <span class="text-warning">
                                                                <i class="fa-solid fa-2xl fa-square-pen"></i>
                                                            </span>
                                                        </a>
                                                    </span>
                                                </td>
                                                 <td style="padding: 0;" class="text-center p-1">
                                                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
                                                    <a href="{{route('comingreso.editardoc',$comp->idcomingreso)}}">
                                                        <span class="text-primary">
                                                            <i class="fa-solid fa-2xl fa-square-info"></i>
                                                        </span>
                                                    </a>
                                                </span>
                                            </td>
                
                                            @elseif($comp->estadoingreso == '2')
                                            <td style="padding: 0;" class="text-center p-1">
                                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar">
                                                        <a href="{{route('comingreso.editar',$comp->idcomingreso)}}">
                                                            <span class="text-warning">
                                                                <i class="fa-solid fa-2xl fa-square-pen"></i>
                                                            </span>
                                                        </a>
                                                    </span>
                                                </td>
                                            <td style="padding: 0;" class="text-center p-1">
                                                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
                                                    <a href="{{route('comingreso.editardocn',$comp->idcomingreso)}}">
                                                        <span class="text-primary">
                                                            <i class="fa-solid fa-2xl fa-square-info"></i>
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
                    input.style.width = input.style.width = "40px";
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
                    input.style.width = input.style.width = "70px";
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

@extends('layouts.admin')
@section('content')
<br>
<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <b>COMPRA DE COMBUSTIBLE -- </b><b style='color:red'>{{$idd->nombrearea}} </b>--
    </div>

   

    <div class="col-md-4 text-right titulo">
        @can('comprascomb_create')

        <a href="{{route('combustibles.pedidoparcial.create')}}" class="tts:left tts-slideIn tts-custom" 
        aria-label="Agregar Solicitud">
            <button class="btn btn-sm btn-success font-verdana" type="button" >Agreg.Solic.
                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
            </button>
        </a>

        <a href="{{route('combustibles.pedidoparcial.index2')}}" class="tts:left tts-slideIn tts-custom" 
        aria-label="Solicitudes Aprobadas">
            <button class="btn btn-sm btn-success font-verdana" type="button" >Solicitudes aprovadas.
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
                        <td class="text-justify p-1"><b>ID</b></td>
                        <td class="text-justify p-1"><b>CONT.INTERNO</b></td>
                        <td class="text-justify p-1"><b>OBJETO</b></td>
                        <td class="text-justify p-1"><b>AREA</b></td>
                        <td class="text-justify p-1"><b>ESTADO</b></td>
                        <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                         <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($compras as $comp)
                        <tr>
                            <td class="text-justify p-1">{{$comp->idcompracomb}}</td>
                            <td class="text-justify p-1">{{$comp->controlinterno}}</td>
                            <td class="text-justify p-1">{{$comp->objeto}}</td>
                            <td class="text-justify p-1">{{$comp->nombrearea}}</td>

                            @if($comp->estadocompracomb == '1')
                            <td class="text-justify p-1">
                            <b style="color: green">Pendiente</b></td>

                            @elseif($comp->estadocompracomb == '2')
                            <td class="text-justify p-1">
                            <b style="color: blue">Aprovada</b></td>

                            @elseif($comp->estadocompracomb == '10')
                            <td class="text-justify p-1">
                                <b style="color: red">Rechazada</b></td>
                            @endif



                            @if($comp->estadocompracomb == '1')
                            <td style="padding: 0;" class="text-center p-1">
                                @can('comprascomb_edit')
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar Compra">
                                        <a href="{{route('combustibles.pedidoparcial.editar',$comp->idcompracomb)}}">
                                            <span class="text-warning">
                                                <i class="fa-solid fa-2xl fa-square-pen"></i>
                                            </span>
                                        </a>
                                    </span>
                                @endcan
                                </td>


                                 <td style="padding: 0;" class="text-center p-1">
                                @can('comprascomb_detalle')
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
                                    <a href="{{route('combustibles.pedidoparcial.edit',$comp->idcompracomb)}}">
                                        <span class="text-primary">
                                            <i class="fa-solid fa-2xl fa-square-info"></i>
                                        </span>
                                    </a>
                                </span>
                                @endcan 
                            </td>

                            @elseif($comp->estadocompracomb == '2')

                            <td style="padding: 0;" class="text-center p-1">
                                @can('comprascomb_edit')
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar Compra">
                                        <a href="{{route('combustibles.pedidoparcial.ver',$comp->idcompracomb)}}">
                                            <span class="text-warning">
                                                <i class="fa-solid fa-2xl fa-square-pen"></i>
                                            </span>
                                        </a>
                                    </span>
                                @endcan
                                </td>

                            <td style="padding: 0;" class="text-center p-1">
                                @can('comprascomb_detalle')
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
                                    <a href="{{route('combustibles.pedidoparcial.editable',$comp->idcompracomb)}}">
                                        <span class="text-primary">
                                            <i class="fa-solid fa-2xl fa-square-info"></i>
                                        </span>
                                    </a>
                                </span>
                                @endcan 
                            </td>
                       
                            
                           
                        

                             @elseif($comp->estadocompracomb == '10')

                           <td style="padding: 0;" class="text-center p-1">
                                @can('comprascomb_edit')
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar Compra">
                                        <a href="{{route('combustibles.pedidoparcial.ver',$comp->idcompracomb)}}">
                                            <span class="text-warning">
                                                <i class="fa-solid fa-2xl fa-square-pen"></i>
                                            </span>
                                        </a>
                                    </span>
                                @endcan
                                </td>

                            <td style="padding: 0;" class="text-center p-1">
                                @can('comprascomb_detalle')
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
                                    <a href="{{route('combustibles.pedidoparcial.editrecha',$comp->idcompracomb)}}">
                                        <span class="text-primary">
                                            <i class="fa-solid fa-2xl fa-square-info"></i>
                                        </span>
                                    </a>
                                </span>
                                @endcan 
                            </td>

                            @endif 


                        </tr>
                    @empty
                    <tr>
                        <td colspan="100%" class="text-center text-muted py-3">No existen registros</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </center>
    </div>
</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({

     
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

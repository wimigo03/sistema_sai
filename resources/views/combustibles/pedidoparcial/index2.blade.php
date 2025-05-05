@extends('layouts.dashboard')
@section('content')
<br>
<div class="row font-verdana-12">
    <div class="col-md-8 titulo">
        <b>SOLICITUDES APROVADAS -- </b><b style='color:red'>{{$idd->nombrearea}} </b>--
    </div>
    <div class="col-md-4 text-right titulo">
   

        <a href="{{route('combustibles.pedidoparcial.index')}}" class="tts:left tts-slideIn tts-custom" 
        aria-label="Volver a pendientes">
            <button class="btn btn-sm btn-success font-verdana" type="button" >Volver a pendientes.
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
                        <td class="text-justify p-1"><b>ID</b></td>
                        <td class="text-justify p-1"><b>CONT.INTERNO</b></td>
                        <td class="text-justify p-1"><b>OBJETO</b></td>
                        <td class="text-justify p-1"><b>AREA</b></td>
                        <td class="text-justify p-1"><b>Estado</b></td>
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
                            <b style="color: green">Sin repuesta</b></td>

                            @elseif($comp->estadocompracomb == '2')
                            <td class="text-justify p-1">
                            <b style="color: blue">Aprovada</b></td>

                            @elseif($comp->estadocompracomb == '3')
                            <td class="text-justify p-1">
                                <b style="color: red">Rechazada</b></td>
                            @endif

                              <td style="padding: 0;" class="text-center p-1">
                  
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
                                    <a href="{{route('combustibles.pedidoparcial.editable',$comp->idcompracomb)}}">
                                        <span class="text-primary">
                                            <i class="fa-solid fa-2xl fa-square-info"></i>
                                        </span>
                                    </a>
                                </span>
                    
                            </td>
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

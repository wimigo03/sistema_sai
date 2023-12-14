@extends('layouts.admin')
@section('content')
<br>
<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <b>--APROBADA POR DIR. ADMIN. -- </b><b style='color:red'>{{$idd->nombrearea}} </b>--
    </div>
    <div class="col-md-4 text-right titulo">
        
         

        <a href="{{route('transportes.pedidoparcial.index')}}" class="tts:left tts-slideIn tts-custom" 
        aria-label="  Solicitud">
            <button class="btn btn-sm btn-success font-verdana" type="button" >Volver Atras.
                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
            </button>
        </a>

        <a href="{{route('transportes.pedidoparcial.index3')}}" class="tts:left tts-slideIn tts-custom" 
        aria-label="  Solicitud">
            <button class="btn btn-sm btn-primary font-verdana" type="button" >Solicitudes Aprovadas.
                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
            </button>
        </a>
       

             {{-- PASO UNO PDF --}}
             {{-- <a href="{{route('transportes.pedidoparcial.pdf')}}" class="tts:left tts-slideIn tts-custom" aria-label="Pdf">
                <button class="btn btn-sm btn-primary font-verdana" type="button" >
                    &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true">PDF</i>&nbsp;
                </button>
            </a> --}}
              {{-- PASO UNO PDF --}}
            



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
                        <td class="text-justify p-1"><b>COM.INTERNA</b></td>
                        <td class="text-justify p-1"><b>referencia</b></td>
                        <td class="text-justify p-1"><b>AREA</b></td>
                        <td class="text-justify p-1"><b>ESTADO</b></td>

                         <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td> 
                         
                    </tr>
                </thead>
                <tbody>
                    @forelse ($soluconsumos as $sol)
                        <tr>
                            <td class="text-justify p-1">{{$sol->idsoluconsumo}}</td>
                            <td class="text-justify p-1">{{$sol->cominterna}}</td>
                            <td class="text-justify p-1">{{$sol->referencia}}</td>
                            <td class="text-justify p-1">{{$sol->nombrearea}}</td>
                            @if($sol->estado1 == '2')
                            <td class="text-justify p-1">
                            <b style="color: green">Aprovado</b></td>
                            @endif
                                <td style="padding: 0;" class="text-center p-1">
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Imprimir Solicitud">
                                    <a href="{{route('transportes.pedidoparcial.solicitud',$sol->idsoluconsumo)}}">
                                        <span class="text-primary">
                                            <i class=" fa-2xl fa-solid fa-print"></i>
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
@endsection

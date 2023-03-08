@extends('layouts.admin')
@section('content')
<br>
<div class="row font-verdana-bg">
    <div class="col-md-8 titulo">
        <b>SOLICITUDES DE COMPRAS -- </b><b style='color:red'>{{$idd->nombrearea}} </b>--
    </div>
    <div class="col-md-4 text-right titulo">
        @can('compras_create')

        <a href="{{route('compras.pedidoparcial.create')}}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar Solicitud">
            <button class="btn btn-sm btn-success font-verdana" type="button" >Agreg.Solic.
                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
            </button>
        </a>
        @endcan


        @can('compras_encargados')

        <a href="{{route('compras.pedidoparcial.listadoResponsables')}}" class="tts:left tts-slideIn tts-custom" aria-label="Gestionar Responsable">
            <button class="btn btn-sm btn-info font-verdana" type="button" >Gest.Resp.
                &nbsp;<i class="fa-sharp fa-solid fa-people-arrows" aria-hidden="true"></i>&nbsp;
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
            <table id="dataTable" class="table display table-bordered responsive font-verdana" style="width:100%">
                <thead>
                    <tr>
                        <td class="text-justify p-1"><b>ID</b></td>
                        <td class="text-justify p-1"><b>CONT.INTERNO</b></td>
                        <td class="text-justify p-1"><b>OBJETO</b></td>
                        <td class="text-justify p-1"><b>AREA</b></td>
                        <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                        <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($compras as $comp)
                        <tr>
                            <td class="text-justify p-1">{{$comp->idcompra}}</td>
                            <td class="text-justify p-1">{{$comp->controlinterno}}</td>
                            <td class="text-justify p-1">{{$comp->objeto}}</td>
                            <td class="text-justify p-1">{{$comp->nombrearea}}</td>

                            <td style="padding: 0;" class="text-center p-1">
                                @can('compras_edit')
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar Compra">
                                        <a href="{{route('compras.pedidoparcial.editar',$comp->idcompra)}}">
                                            <span class="text-warning">
                                                <i class="fa-solid fa-2xl fa-square-pen"></i>
                                            </span>
                                        </a>
                                    </span>
                                @endcan
                                </td>
                                <td style="padding: 0;" class="text-center p-1">
                                @can('compras_detalle')
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
                                    <a href="{{route('compras.pedidoparcial.edit',$comp->idcompra)}}">
                                        <span class="text-primary">
                                            <i class="fa-solid fa-2xl fa-square-info"></i>
                                        </span>
                                    </a>
                                </span>
                                @endcan
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

            order: [[ 0, "desc" ]],



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
    function agregar(){
        $(".btn").hide();
        $(".spinner-btn-send").show();
        window.location.href = "{{route('compras.pedido.create')}}";
    }
</script>
@endsection
@endsection

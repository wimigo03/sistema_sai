@extends('layouts.admin')
@section('content')
<br>
<div class="row font-verdana-bg">

    <div class="col-md-2 text-right titulo">

            <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                <a href="{{ url('/compras/pedidoparcial/index')}}">
                    <span class="color-icon-1">
                        &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                    </span>
                </a>
            </span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        @can('compras_encargados_create')
        @if ($estado == 0)
        <a href="{{route('compras.pedidoparcial.crearEncargado')}}" class="tts:left tts-slideIn tts-custom" aria-label="Agregar Responsable">
            <button class="btn btn-sm btn-primary font-verdana" type="button" >
                &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;
            </button>
        </a>
        @endif
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
                        <td class="text-justify p-1"><b>RESPONSABLE</b></td>
                        <td class="text-justify p-1"><b>CARGO</b></td>
                        <td class="text-justify p-1"><b>AREA</b></td>
                        <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($encargados as $enc)
                        <tr>
                            <td class="text-justify p-1">{{$enc->idenc}}</td>
                            <td class="text-justify p-1">{{$enc->abrev}} {{$enc->nombres}} {{$enc->ap_pat}} {{$enc->ap_mat}}</td>
                            <td class="text-justify p-1">{{$enc->cargo}}</td>
                            <td class="text-justify p-1">{{$enc->nombrearea}}</td>

                            <td style="padding: 0;" class="text-center p-1">
                                @can('compras_encargados_edit')
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar">
                                        <a href="{{route('compras.pedidoparcial.responsableEdit',$enc->idenc)}}">
                                            <span class="text-warning">
                                                <i class="fa-solid fa-2xl fa-square-pen"></i>
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
            language: {
                url: '/spain.json'
            },
            order: [[ 0, "desc" ]]
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

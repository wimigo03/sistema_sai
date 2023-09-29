@extends('layouts.admin')
@section('content')
<style>
    table tbody tr:hover{background:rgba(143, 217, 240, 0.497)!important;}
</style>

<div class="header">
    <div class="row font-verdana-bg">
        <div class="col-md-10 titulo">
            <b>CORRESPONDENCIA DERIVADA</b>
        </div>
        <div class="col-md-2 text-right titulo">
            <button class="btn btn-primary font-verdana" type="button" onclick="search();">
                <i class="fa fa-search" aria-hidden="true"></i>&nbsp;Buscar
            </button>
            <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>

            &nbsp;&nbsp;&nbsp;

            <span class="tts:left tts-slideIn tts-custom" aria-label="Limpiar">
                <a href="{{route('derivacion.index')}}">
                    &nbsp;<i class="fa-duotone fa-eraser fa-xl"></i>&nbsp;
                </a>
            </span>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>


</div>
<hr>


    <div class="body">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <center>
                    <table class="table display table-bordered responsive font-verdana" style="width:100%;">
                        <thead>
                            <tr>

                                <td class="text-center p-1"><b>Fecha/Recepcion</b></td>
                                <td class="text-center p-1"><b>Fecha/Derivacion</b></td>

                                <td class="text-center p-1"><b>Asunto</b></td>
                                <td class="text-center p-1"><b>Gestionar</b></td>
                                <td class="text-center p-1"><b>Estado</b></td>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $datos)
                                <tr>
                                    <td class="text-center p-1">{{$datos->recepcion->fecha_recepcion}}</td>
                                    <td class="text-center p-1">{{$datos->fechaderivacion}}</td>

                                    <td class="text-center p-1">{{$datos->recepcion->asunto}}</td>

                                    <td class="text-center p-1">

                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Gestionar Correspondencia">
                                            <a href="{{ route('derivacion.gestionar',$datos->idderivacion) }}"
                                                <span class="text-warning">
                                                    <i class="fas fa-lg fa-cog" style="color:orange"></i>
                                                </span>
                                            </a>
                                        </span>
                                    </td>
                                    <td class="text-center p-1">


                                        @if ($datos->estadoderiv1 == 1)


                                        <b style="color: red">--SIN VERIFICAR--</b>

                                        @else
                                        <b style="color: green">--VERIFICADO--</b>
                                    @endif


                                    </td>


                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12">
                                    {{ $data->appends(Request::all())->links() }}
                                    <p class="text-muted">Mostrando
                                        <strong>{{$data->count()}}</strong> registros de
                                        <strong>{{$data->total()}}</strong> totales
                                    </p>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </center>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "--Seleccionar--"
        });
    });

    function search(){
        $(".btn").hide();
        $(".spinner-btn-send").show();
        $("#form").submit();
    }


</script>
@endsection

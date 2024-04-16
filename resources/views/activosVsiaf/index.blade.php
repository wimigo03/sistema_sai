@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')
<style>
    table tbody tr:hover{background:orange!important;}
</style>
<br>
<div class="header">
    <div class="row font-verdana-12">
        <div class="col-md-10 titulo">
            <b>ACTIVOS VSIAF</b>
        </div>
        <div class="col-md-2 text-right titulo">
            <span class="tts:left tts-slideIn tts-custom" aria-label="Limpiar">
                <a href="{{route('activos.vsiaf.index')}}">
                    &nbsp;<i class="fa-duotone fa-eraser"></i>&nbsp;
                </a>
            </span>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
    <form action="{{ route('activos.vsiaf.search') }}" method="get" id="form">
        @csrf
        @include('activosVsiaf.partials.search')
    </form>
</div>
<hr>
{{--@if ((request('anho') != '') || (request('periodo') != ''))
    <form action="{{ route('canasta.pendientes.search.detalle') }}" method="get" id="form-detalle">
        @csrf
        <input type="hidden" name="anho" value="{{request('anho')}}">
        <input type="hidden" name="periodo" value="{{request('periodo')}}">
        @include('discapacidad.pendientes.partials.search-detalle')
    </form>
    <form action="{{ route('canasta.pendientes.search.detallepdf') }}" method="get" id="form-detalle-pdf">
        @csrf
        <input type="hidden" name="anho" value="{{request('anho')}}">
        <input type="hidden" name="periodo" value="{{request('periodo')}}">
        <input type="hidden" name="nro_carnet" value="{{request('nro_carnet')}}">
        <input type="hidden" name="nombres" value="{{request('nombres')}}">
        <input type="hidden" name="apellidos" value="{{request('apellidos')}}">
        <input type="hidden" name="edad" value="{{request('edad')}}">
        <input type="hidden" name="carnet_disc" value="{{request('carnet_disc')}}">
    </form>
@endif--}}
@if (count($activos) > 0)
    <div class="body">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <center>
                    <table class="table display table-bordered responsive font-verdana" style="width:100%;">
                        <thead>
                            <tr>
                                <td class="text-center p-1"><b>UNIDAD</b></td>
                                <td class="text-justify p-1"><b>CODIGO</b></td>
                                <td class="text-center p-1"><b>V.&nbsp;UTIL</b></td>
                                <td class="text-justify p-1"><b>DESCRIPCION</b></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activos as $datos)
                                <tr>
                                    <td class="text-center p-1">{{$datos->unidad}}</td>
                                    <td class="text-justify p-1">{{$datos->codigo}}</td>
                                    <td class="text-center p-1">{{$datos->vidautil}}</td>
                                    <td class="text-justify p-1">{{$datos->descrip}}</td>
                                    {{--<td class="text-justify p-1">{{$datos->afiliado == null ? 'S/N':\Carbon\Carbon::parse($datos->afiliado->f_vencimiento)->format('d/m/Y')}}</td>--}}
                                    {{--<td class="text-justify p-1">{{$datos->afiliado == null ? 'S/N':$datos->afiliado->nombre_tutor}}</td>--}}
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12">
                                    {{$activos->appends(Request::all())->links()}}
                                    <p class="text-muted">Mostrando
                                        <strong>{{$activos->count()}}</strong> registros de
                                        <strong>{{$activos->total()}}</strong> totales
                                    </p>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </center>
            </div>
        </div>
    </div>
@else
<div class="body">
    <div class="row">
        <div class="col-md-12 font-verdana-12 text-center">
            ... No existen resultados ...
        </div>
    </div>
</div>
@endif
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

    /*function searchdetalle(){
        $(".btn").hide();
        $(".spinner-btn-send").show();
        $("#form-detalle").submit();
    }

    function searchdetallepdf(){
        $(".btn").hide();
        $(".spinner-btn-send").show();
        $("#form-detalle-pdf").submit();
    }

    function message_alert(mensaje){
        $("#modal-alert .modal-body").html(mensaje);
        $('#modal-alert').modal({keyboard: false});
    }

    function validar_formulario(){
        if($("#periodo >option:selected").val() == ""){
            message_alert("El campo <b>[Periodo]</b> es un campo requerido...");
            return false;
        }
        if($("#anho").val() == ""){
            message_alert("El campo <b>[Gestion]</b> es un campo requerido...");
            return false;
        }
        return true;
    }

    function valideNumberSinDecimal(evt){
        var code = (evt.which) ? evt.which : evt.keyCode;
        if(code>=48 && code<=57){
            return true;
        }else{
            return false;
        }
    }*/
</script>
@endsection

@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')
<style>
    table tbody tr:hover{background:orange!important;} 
</style>
<br>
<div class="header">
    <div class="row font-verdana-bg">
        <div class="col-md-10 titulo">
            <b>CANASTAS PENDIENTES</b>
        </div>
        <div class="col-md-2 text-right titulo">
            <span class="tts:left tts-slideIn tts-custom" aria-label="Limpiar">
                <a href="{{route('canasta.pendientes.index')}}">
                    &nbsp;<i class="fa-duotone fa-eraser"></i>&nbsp;
                </a>
            </span>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
    @canany(['discapacidad_buscar'])
    <form action="{{ route('canasta.pendientes.search') }}" method="get" id="form">
        @csrf
        @include('discapacidad.pendientes.partials.search')
    </form>
    @endcan
</div>
<hr>

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

@if (count($entrega_temp) > 0)
    <div class="body">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <center>
                    <table class="table display table-bordered responsive font-verdana" style="width:100%;">
                        <thead>
                            <tr>
                                <td class="text-justify p-1"><b>COD.</b></td>
                                <td class="text-justify p-1"><b>NRO. CI</b></td>
                                <td class="text-justify p-1"><b>NOMBRES</b></td>
                                <td class="text-justify p-1"><b>APELLIDOS</b></td>
                                <td class="text-justify p-1"><b>EDAD</b></td>
                                <td class="text-justify p-1"><b>BARRIO</b></td>
                                <td class="text-justify p-1"><b>CARNET DISC.</b></td>
                                <td class="text-justify p-1"><b>VENCIMIENTO</b></td>
                                <td class="text-justify p-1"><b>TUTOR</b></td>
                                <td class="text-justify p-1"><b>ESTADO</b></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entrega_temp as $datos)
                                <tr>
                                    <td class="text-justify p-1">{{$datos->id_ent}}</td>
                                    <td class="text-justify p-1">{{$datos->afiliado == null ? 'S/N':$datos->afiliado->carnet}}</td>
                                    <td class="text-justify p-1">{{$datos->afiliado == null ? 'S/N':$datos->afiliado->nombres}}</td>
                                    <td class="text-justify p-1">{{$datos->afiliado == null ? 'S/N':$datos->afiliado->apellidos}}</td>
                                    <td class="text-justify p-1">{{$datos->afiliado == null ? 'S/N':$datos->afiliado->edad}}</td>
                                    <td class="text-justify p-1">{{$datos->afiliado == null ? 'S/N':$datos->afiliado->barrio_com}}</td>
                                    <td class="text-justify p-1">{{$datos->afiliado == null ? 'S/N':$datos->afiliado->carnet_discap}}</td>
                                    <td class="text-justify p-1">{{$datos->afiliado == null ? 'S/N':\Carbon\Carbon::parse($datos->afiliado->f_vencimiento)->format('d/m/Y')}}</td>
                                    <td class="text-justify p-1">{{$datos->afiliado == null ? 'S/N':$datos->afiliado->nombre_tutor}}</td>
                                    <td class="text-justify p-1">
                                        @if($datos->afiliado->estado1 == 1)
                                        <FONT COLOR="green">HABILITADO</FONT>
                                        @else
                                            @if($datos->afiliado->estado1==2)
                                            <FONT COLOR="red">INHABILITADO</FONT>
                                            @else
                                            <FONT COLOR="blue">ERROR </FONT>
                                              @endif
                                        @endif
                                    
                                    </td>
                                </tr> 
                            @endforeach
                        </tbody>
                      {{-- <tfoot>
                            <tr>
                                <td colspan="12">
                                    {{$entrega_temp->appends(Request::all())->links()}}
                                    <p class="text-muted">Mostrando 
                                        <strong>{{$entrega_temp->count()}}</strong> registros de 
                                        <strong>{{$entrega_temp->total()}}</strong> totales
                                    </p>
                                </td>
                            </tr>
                        </tfoot>--}}
                    </table>
                </center>
            </div>
        </div>
    </div>
@else
<div class="body">
    <div class="row">
        <div class="col-md-12 font-verdana-bg text-center">
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
        if(validar_formulario() == true){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            $("#form").submit();
        }
    }

    function searchdetalle(){
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
    }

    /*function validarFormato(fecha) {
        var RegExPattern = /^\d{2}\/\d{2}\/\d{4}$/;
        if ((fecha.match(RegExPattern)) && (fecha!='')) {
                return true;
        } else {
                return false;
        }
    }
    

    $("#fecha_desde").datepicker({
        inline: false, 
        dateFormat: "dd/mm/yyyy",
        autoClose: true
    });

    $("#fecha_hasta").datepicker({
        inline: false, 
        dateFormat: "dd/mm/yyyy",
        autoClose: true
    });*/
</script>
@endsection
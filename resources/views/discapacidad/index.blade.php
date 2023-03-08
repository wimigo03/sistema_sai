@extends('layouts.admin')
@section('content')
<style>
    table tbody tr:hover{background:orange!important;} 
</style>
<br>
<div class="header">
    <div class="row font-verdana-bg">
        <div class="col-md-10 titulo">
            <b>ENTREGA CANASTA</b>
        </div>
        <div class="col-md-2 text-right titulo">
            <span class="tts:left tts-slideIn tts-custom" aria-label="Limpiar">
                <a href="{{route('canasta.entrega.index')}}">
                    &nbsp;<i class="fa-duotone fa-eraser"></i>&nbsp;
                </a>
            </span>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
    <form action="{{ route('canasta.entrega.search') }}" method="get" id="form">
        @csrf
        @include('discapacidad.partials.search')
    </form>
</div>
<div class="body">
    <div class="row">
        <div class="col-md-12 table-responsive">
            <center>
                <table class="table display table-bordered responsive font-verdana" style="width:100%;">
                    <thead>
                        <tr>
                            <td class="text-justify p-1"><b>NRO. CARNET</b></td>
                            <td class="text-justify p-1"><b>NOMBRES</b></td>
                            <td class="text-justify p-1"><b>APELLIDOS</b></td>
                            <td class="text-justify p-1"><b>EDAD</b></td>
                            <td class="text-justify p-1"><b>BARRIO</b></td>
                            <td class="text-justify p-1"><b>CARNET DISC.</b></td>
                            <td class="text-justify p-1"><b>VENCIMIENTO</b></td>
                            <td class="text-justify p-1"><b>TUTOR</b></td>
                            <td class="text-center p-1"><b>ENTREGA</b></td>
                            <td class="text-center p-1"><b>MES_1</b></td>
                            <td class="text-center p-1"><b>MES_2</b></td>
                            <td class="text-center p-1"><b>MES_3</b></td>
                            {{--<td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>--}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entregas as $datos)
                            <tr>
                                <td  class="text-justify p-1">{{$datos->afiliado->carnet}}</td>
                                <td  class="text-justify p-1">{{$datos->afiliado->nombres}}</td>
                                <td  class="text-justify p-1">{{$datos->afiliado->apellidos}}</td>
                                <td  class="text-justify p-1">{{$datos->afiliado->edad}}</td>
                                <td  class="text-justify p-1">{{$datos->afiliado->barrio_com}}</td>
                                <td  class="text-justify p-1">{{$datos->afiliado->carnet_discap}}</td>
                                <td  class="text-justify p-1">{{\Carbon\Carbon::parse($datos->f_vencimiento)->format('d/m/Y')}}</td>
                                <td  class="text-justify p-1">{{$datos->afiliado->nombre_tutor}}</td>
                                <td  class="text-center p-1">{{\Carbon\Carbon::parse($datos->fecha_e)->format('d/m/Y')}}</td>
                                <td  class="text-center p-1">{{$datos->mes1}}</td>
                                <td  class="text-center p-1">{{$datos->mes2}}</td>
                                <td  class="text-center p-1">{{$datos->mes3}}</td>
                                {{--<td  class="text-center p-1">x</td>--}}
                            </tr> 
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="12">
                                {{ $entregas->appends(Request::all())->links() }}
                                <p class="text-muted">Mostrando 
                                    <strong>{{ $entregas->count() }}</strong> registros de 
                                    <strong>{{$entregas->total() }}</strong> totales
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
    /*function agregar(){
        $(".btn").hide();
        $(".spinner-btn-send").show();
        window.location.href = "{{route('medidas.create')}}";
    }*/
    function search(){
        $(".btn").hide();
        $(".spinner-btn-send").show();
        $("#form").submit();
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
    });
</script>
@endsection
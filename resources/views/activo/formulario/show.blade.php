@extends('layouts.dashboard')
@section('content')
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">

            <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                <a href="{{ url('Activo/adeudo/index') }}">
                    <span class="color-icon-1">
                        &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                    </span>
                </a>
            </span>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
            <b>ENTIDAD:</b> {{ $entidad->entidad }}-{{ $entidad->desc_ent }}<span></span>
            <hr class="hrr">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <b>C.I.:</b>
            <h6> {{ $adeudo->ci }} </h6>
        </div>
        <div class="col-md-3">
            <b>FECHA DE INICIO:</b>
            <h6> {{ $adeudo->fecha_inicio }} </h6>
        </div>
        
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
function abrirModal(){
    $("#btn_store_imagen").show();
    $("#btn_update_imagen").hide();
    $('#titulo_modal').text('Agregar activo')
    $('#codigo').val("");
    $('#descripcion').val("");
    $('#estado').val("");
    $('#modalArchivo').modal('show');
}
</script>
@endsection

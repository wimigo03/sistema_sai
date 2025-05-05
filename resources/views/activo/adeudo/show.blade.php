@extends('layouts.dashboard')
@section('content')
    <div class="row font-verdana-12">
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
        <div class="col-md-3">
            <b>FECHA DE FINALIZACION:</b>
            <h6> {{ $adeudo->fecha_fin }} </h6>
        </div>
        <div class="col-md-3">
            <b>NRO. DE CONTRATO O AGRADECIMIENTO:</b>
            <h6> {{ $adeudo->nro_contrato }} </h6>
        </div>
        <div class="col-md-3">
            <b>CANTIDAD DE ACTIVOS:</b>
            <h6> {{ $adeudo->cantidad_activos }} </h6>
        </div>
        <div class="col-md-3">
            <b>MOTIVO DE RETIRO:</b>
            <h6> {{ $adeudo->motivo_retiro }} </h6>
        </div>
        <div class="col-md-3">
            <b>RESPONSABLE:</b>
            <h6> {{ $adeudo->empleado->full_name }} </h6>
        </div>
        <div class="col-md-3">
            <b>CARGO:</b>
            <h6> {{ $adeudo->empleado->file->nombrecargo }} </h6>
        </div>
        <div class="col-md-3">
            <b>OFICINA:</b>
            <h6> {{ $adeudo->empleado->empleadosareas->nombrearea }} </h6>
        </div>
        <div class="col-md-3">
            <b>PDF:</b>
            <h6> {{ $adeudo->respaldo }}
                <a href="{{ asset('/public/respaldos/' . $adeudo->respaldo) }}" target="_blank">
                    <i class="fas fa-eye fa-xl" style="color: cadetblue"></i>
                </a>
            </h6>
        </div>
        <div class="col-md-3">
            <b>FECHA DE ELABORACION:</b>
            <h6> {{ $fecha_creacion }} </h6>
        </div>
    </div>
@endsection

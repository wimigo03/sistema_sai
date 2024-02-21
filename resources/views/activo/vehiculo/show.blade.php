@extends('layouts.admin')
@section('content')
    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">

            <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                <a href="{{ url('Activo/vehiculo/index') }}">
                    <span class="color-icon-1">
                        &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                    </span>
                </a>
            </span>
            <b>ACTIVO {{ $vehiculo->codigo }}</b>
        </div>

        <div class="col-md-12">
            <hr class="hrr">
            <b>ENTIDAD:</b> {{ $entidad->entidad }}-{{ $entidad->desc_ent }}<span></span>
            <hr class="hrr">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <b>CODIGO VSIAF:</b>
            <h6>{{ $vehiculo->codigo }}</h6>
        </div>
        <div class="col-md-3">
            <b>CODIGO INTERNO:</b>
            <h6>{{ $vehiculo->codigo_interno }}</h6>
        </div>
        <div class="col-md-3">
            <b>CODIGO D.A.:</b>
            <h6>{{ $vehiculo->da }}</h6>
        </div>
        <div class="col-md-3">
            <b>COSTO HISTORICO:</b>
            <h6>{{ $vehiculo->costo_historico }}</h6>
        </div>
        <div class="col-md-3">
            <b>PDF:</b>
            <h6> {{ $vehiculo->documento }}
                <a href="{{ asset('/public/documentos/' . $vehiculo->documento) }}" target="_blank">
                    <i class="fas fa-eye fa-xl" style="color: cadetblue"></i>
                </a>
            </h6>
        </div>
        <div class="col-md-3">
            <b>ESTADO:</b>
            <h6>{{ $vehiculo->estado }}</h6>
        </div>
        <div class="col-md-3">
            <b>NOMBRE DEL PROPIETARIO:</b>
            <h6>{{ $vehiculo->nombre_propietario }}</h6>
        </div>
        <div class="col-md-3">
            <b>MUNICIPIO RADICATORIA:</b>
            <h6>{{ $vehiculo->municipio_radicatoria }}</h6>
        </div>
        <div class="col-md-3">
            <b>CLASE VEHICULO:</b>
            <h6>{{ $vehiculo->clase_vehiculo }}</h6>
        </div>
        <div class="col-md-3">
            <b>GNV:</b>
            <h6>{{ $vehiculo->gnv }}</h6>
        </div>
        <div class="col-md-3">
            <b>NUMERO DE PLACA:</b>
            <h6>{{ $vehiculo->nro_placa }}</h6>
        </div>
        <div class="col-md-3">
            <b>TIPO:</b>
            <h6>{{ $vehiculo->tipo }}</h6>
        </div>
        <div class="col-md-3">
            <b>MARCA:</b>
            <h6>{{ $vehiculo->marca }}</h6>
        </div>
        <div class="col-md-3">
            <b>MODELO:</b>
            <h6>{{ $vehiculo->modelo }}</h6>
        </div>
        <div class="col-md-3">
            <b>COLOR:</b>
            <h6>{{ $vehiculo->color }}</h6>
        </div>
        <div class="col-md-3">
            <b>PAIS PROCEDENCIA:</b>
            <h6>{{ $vehiculo->pais_procedencia }}</h6>
        </div>
        <div class="col-md-3">
            <b>USO DEL BIEN:</b>
            <h6>{{ $vehiculo->uso_bien }}</h6>
        </div>
        <div class="col-md-3">
            <b>NRO. MOTOR:</b>
            <h6>{{ $vehiculo->nro_motor }}</h6>
        </div>
        <div class="col-md-3">
            <b>NRO. CHASIS:</b>
            <h6>{{ $vehiculo->nro_chasis }}</h6>
        </div>
        <div class="col-md-3">
            <b>CILINDRADA Cc:</b>
            <h6>{{ $vehiculo->cilindrada }}</h6>
        </div>
        <div class="col-md-3">
            <b>TRACCION:</b>
            <h6>{{ $vehiculo->traccion }}</h6>
        </div>
        <div class="col-md-3">
            <b>NRO. PLAZAS:</b>
            <h6>{{ $vehiculo->nro_plazas }}</h6>
        </div>
        <div class="col-md-3">
            <b>NRO. PUERTAS:</b>
            <h6>{{ $vehiculo->nro_puertas }}</h6>
        </div>
        <div class="col-md-3">
            <b>CAPACIDAD DE CARGA KL:</b>
            <h6>{{ $vehiculo->capacidad_carga }}</h6>
        </div>
        <div class="col-md-3">
            <b>NRO. POLIZA PROCEDENCIA:</b>
            <h6>{{ $vehiculo->nro_poliza_procedencia }}</h6>
        </div>
        <div class="col-md-3">
            <b>FECHA DE POLIZA:</b>
            <h6>{{ $vehiculo->fecha_poliza }}</h6>
        </div>
        <div class="col-md-3">
            <b>ULTIMO SOAT:</b>
            <h6>{{ $vehiculo->ultimo_soat }}</h6>
        </div>
        <div class="col-md-3">
            <b>ULTIMO I.T.V.:</b>
            <h6>{{ $vehiculo->ultima_itv }}</h6>
        </div>
        <div class="col-md-3">
            <b>B-SISA:</b>
            <h6>{{ $vehiculo->b_sisa }}</h6>
        </div>
        <div class="col-md-3">
            <b>NRO. R.U.A.T.:</b>
            <h6>{{ $vehiculo->nro_ruat }}</h6>
        </div>
        <div class="col-md-3">
            <b>DOC. ADJ. R.U.A.T:</b>
            <h6> {{ $vehiculo->documento }}
                <a href="{{ asset('/public/documentos/' . $vehiculo->documento_ruat) }}" target="_blank">
                    <i class="fas fa-eye fa-xl" style="color: cadetblue"></i>
                </a>
            </h6>
        </div>
        <div class="col-md-3">
            <b>NRO. (CRPVA):</b>
            <h6>{{ $vehiculo->nro_crpva }}</h6>
        </div>
        <div class="col-md-3">
            <b>NRO. POLIZA SEGURO:</b>
            <h6>{{ $vehiculo->nro_poliza_seguro }}</h6>
        </div>
        <div class="col-md-3">
            <b>VENC. POLIZA DEL SEGURO:</b>
            <h6>{{ $vehiculo->vencimiento_poliza_seguro }}</h6>
        </div>
        <div class="col-md-3">
            <b>DEPARTAMENTO:</b>
            <h6>{{ $vehiculo->departamento }}</h6>
        </div>
        <div class="col-md-3">
            <b>PROVINCIA:</b>
            <h6>{{ $vehiculo->provincia }}</h6>
        </div>
        <div class="col-md-3">
            <b>MUNICIPIO:</b>
            <h6>{{ $vehiculo->municipio }}</h6>
        </div>
        <div class="col-md-3">
            <b>LOCALIDAD:</b>
            <h6>{{ $vehiculo->localidad }}</h6>
        </div>
        <div class="col-md-3">
            <b>DISTRITO:</b>
            <h6>{{ $vehiculo->distrito }}</h6>
        </div>
        <div class="col-md-3">
            <b>CANTON:</b>
            <h6>{{ $vehiculo->canton }}</h6>
        </div>
        <div class="col-md-3">
            <b>COMUNIDAD:</b>
            <h6>{{ $vehiculo->comunidad }}</h6>
        </div>
        <div class="col-md-3">
            <b>ZONA:</b>
            <h6>{{ $vehiculo->zona }}</h6>
        </div>
        <div class="col-md-3">
            <b>DIRECCION:</b>
            <h6>{{ $vehiculo->direccion }}</h6>
        </div>
        <div class="col-md-3">
            <b>KARDEX ACLARACION:</b>
            <h6>{{ $vehiculo->kardex_aclaracion }}</h6>
        </div>
        <div class="col-md-3">
            <b>IMAGEN:</b>
            <h6>
              <img src="{{ asset('/public/imagen/' . $vehiculo->imagen) }}" alt="imagen-vehiculo">
            </h6>
        </div>
    </div>
@endsection

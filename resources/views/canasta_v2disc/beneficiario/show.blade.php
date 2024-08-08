<!DOCTYPE html>
@extends('layouts.admin')
<style>
    #img-beneficiario {
        width: 350px;
        height: auto;
        overflow: hidden;
    }
</style>
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>DETALLES DEL BENEFICIARIO DISCAPACIDAD</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="form-group row">
            <div class="col-md-10 pr-1 pl-1">
                <span class="btn btn-outline-primary font-roboto-12" onclick="ir_atras();">
                    <i class="fas fa-arrow-left fa-fw"></i>&nbsp;Ir atras
                </span>
                @can('canasta.beneficiarios.pdf')
                    <span class="tts:left tts-slideIn tts-custom float-right" aria-label="Exportar">
                        <span class="btn btn-outline-danger font-roboto-12" onclick="exportar_pdf();">
                            <i class="fas fa-file-pdf fa-fw"></i>&nbsp;Pdf
                        </span>
                    </span>
                @endcan
                <i class="fa fa-spinner custom-spinner fa-spin fa-fw spinner-btn-send" style="display: none;"></i>
            </div>
        </div>
        <input type="hidden" value="{{ $beneficiario->id }}" id="beneficiario_id">
        <div class="row">
            <div class="col-md-8 pr-1 pl-1">
                <div class="form-group row font-roboto-12">
                    <div class="col-md-3">
                        <label for="" class="d-inline"><b>Nro. de carnet</b></label>
                    </div>
                    <div class="col-md-9">
                        <b>:</b> {{ $beneficiario->ci . ' ' . $beneficiario->expedido }}
                    </div>
                </div>
                <div class="form-group row font-roboto-12">
                    <div class="col-md-3">
                        <label for="" class="d-inline"><b>Nombres</b></label>
                    </div>
                    <div class="col-md-9">
                        <b>:</b> {{ $beneficiario->nombres }}
                    </div>
                </div>
                <div class="form-group row font-roboto-12">
                    <div class="col-md-3">
                        <label for="" class="d-inline"><b>Apellido Paterno</b></label>
                    </div>
                    <div class="col-md-9">
                        <b>:</b> {{ $beneficiario->ap }}
                    </div>
                </div>
                <div class="form-group row font-roboto-12">
                    <div class="col-md-3">
                        <label for="" class="d-inline"><b>Apellido Materno</b></label>
                    </div>
                    <div class="col-md-9">
                        <b>:</b> {{ $beneficiario->am }}
                    </div>
                </div>
                <div class="form-group row font-roboto-12">
                    <div class="col-md-3">
                        <label for="" class="d-inline"><b>Fecha de Nacimiento</b></label>
                    </div>
                    <div class="col-md-9">
                        <b>:</b> {{ \Carbon\Carbon::parse($beneficiario->fecha_nac)->format('d/m/Y') }}
                    </div>
                </div>
                <div class="form-group row font-roboto-12">
                    <div class="col-md-3">
                        <label for="" class="d-inline"><b>Edad</b></label>
                    </div>
                    <div class="col-md-9">
                        <b>:</b> {{ \Carbon\Carbon::parse($beneficiario->fecha_nac)->age }}
                    </div>
                </div>
                <div class="form-group row font-roboto-12">
                    <div class="col-md-3">
                        <label for="" class="d-inline"><b>Estado Civil</b></label>
                    </div>
                    <div class="col-md-9">
                        <b>:</b> {{ $beneficiario->estado_civil }}
                    </div>
                </div>
                <div class="form-group row font-roboto-12">
                    <div class="col-md-3">
                        <label for="" class="d-inline"><b>Genero</b></label>
                    </div>
                    <div class="col-md-9">
                        <b>:</b> {{ $beneficiario->sexo }}
                    </div>
                </div>
                <div class="form-group row font-roboto-12">
                    <div class="col-md-3">
                        <label for="" class="d-inline"><b>Ocupacion</b></label>
                    </div>
                    <div class="col-md-9">
                        <b>:</b> {{ $beneficiario->ocupacion->ocupacion }}
                    </div>
                </div>
                <div class="form-group row font-roboto-12">
                    <div class="col-md-3">
                        <label for="" class="d-inline"><b>Barrio / Comunidad</b></label>
                    </div>
                    <div class="col-md-9">
                        <b>:</b> {{ $beneficiario->barrio->nombre }}
                    </div>
                </div>
                <div class="form-group row font-roboto-12">
                    <div class="col-md-3">
                        <label for="" class="d-inline"><b>Direccion</b></label>
                    </div>
                    <div class="col-md-9">
                        <b>:</b> {{ $beneficiario->direccion }}
                    </div>
                </div>
                <div class="form-group row font-roboto-12">
                    <div class="col-md-3">
                        <label for="" class="d-inline"><b>Firma</b></label>
                    </div>
                    <div class="col-md-9">
                        <b>:</b> {{ $beneficiario->firma }}
                    </div>
                </div>
                <div class="form-group row font-roboto-12">
                    <div class="col-md-3">
                        <label for="" class="d-inline"><b>Fecha de Registro</b></label>
                    </div>
                    <div class="col-md-9">
                        <b>:</b> {{ \Carbon\Carbon::parse($beneficiario->created_att)->format('d/m/Y') }}
                    </div>
                </div>
                <div class="form-group row font-roboto-12">
                    <div class="col-md-3">
                        <label for="" class="d-inline"><b>Estado</b></label>
                    </div>
                    <div class="col-md-9">
                        <b>:</b> {{ $beneficiario->status }}
                    </div>
                </div>
                <div class="form-group row font-roboto-12">
                    <div class="col-md-3">
                        <label for="" class="d-inline"><b>Observaciones</b></label>
                    </div>
                    <div class="col-md-9">
                        <b>:</b> {{ $beneficiario->obs }}
                    </div>
                </div>
            </div>
            <div class="col-md-4 pr-1 pl-1">
                <img src="{{ asset(substr($beneficiario->dir_foto, 2)) }}" alt="img" id="img-beneficiario">
            </div>
        </div>
        @isset($historial)
            <div class="form-group row">
                <div class="col-md-8 pr-1 pl-1 font-roboto-11">
                    <b>HISTORIAL</b>
                </div>
                <div class="col-md-8 pr-1 pl-1">
                    <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="#">
                        <thead>
                            <tr class="font-roboto-11">
                                <th class="text-left p-1">FECHA</th>
                                <th class="text-left p-1">OBSERVACION</th>
                                <th class="text-center p-1">USUARIO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($historial as $datos)
                                <tr class="font-roboto-11">
                                    <td class="text-justify p-1">{{ \Carbon\Carbon::parse($datos->fecha)->format('d/m/Y') }}</td>
                                    <td class="text-justify p-1">{{ strtoupper($datos->observacion) }}</td>
                                    <td class="text-center p-1">{{ $datos->user != null ? $datos->user->name : '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endisset
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        function ir_atras(){
            window.location.href = "{{ route('beneficiariosdisc.index') }}";
        }

        function exportar_pdf(){
            var beneficiario_id = $("#beneficiario_id").val();
            var url = "{{ route('beneficiarios.pdf',':beneficiario_id') }}";
            url = url.replace(':beneficiario_id',beneficiario_id);
            window.location.href = url;
        }
    </script>
@endsection

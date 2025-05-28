<!DOCTYPE html>
@extends('layouts.dashboard')
<style>
    #img-beneficiario {
        width: 350px;
        height: auto;
        overflow: hidden;
    }

    #map {
        height: 500px;
        width: 100%;
    }
</style>
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>DETALLES DEL BENEFICIARIO</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="form-group row">
            <div class="col-md-12 pr-1 pl-1">
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
        <div class="form-group row font-roboto-12">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <img src="{{ asset(substr($beneficiario->dir_foto, 2)) }}" alt="img" id="img-beneficiario">
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-2 pr-1 pl-1">
                <label for="" class="d-inline"><b>Nro. de carnet</b></label>
                <input type="text" value="{{ $beneficiario->ci . ' ' . $beneficiario->expedido }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-4 pr-1 pl-1">
                <label for="" class="d-inline"><b>Nombres</b></label>
                <input type="text" value="{{ $beneficiario->nombres }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-3 pr-1 pl-1">
                <label for="" class="d-inline"><b>Apellido Paterno</b></label>
                <input type="text" value="{{ $beneficiario->ap }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-3 pr-1 pl-1">
                <label for="" class="d-inline"><b>Apellido Materno</b></label>
                <input type="text" value="{{ $beneficiario->am }}" class="form-control font-roboto-12" disabled>
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-2 pr-1 pl-1">
                <label for="" class="d-inline"><b>Fecha de Nacimiento</b></label>
                <input type="text" value="{{ \Carbon\Carbon::parse($beneficiario->fecha_nac)->format('d/m/Y') }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="" class="d-inline"><b>Edad</b></label>
                <input type="text" value="{{ \Carbon\Carbon::parse($beneficiario->fecha_nac)->age }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="" class="d-inline"><b>Estado Civil</b></label>
                <input type="text" value="{{ $beneficiario->estado_civil }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="" class="d-inline"><b>Genero</b></label>
                <input type="text" value="{{ $beneficiario->sexo }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-4 pr-1 pl-1">
                <label for="" class="d-inline"><b>Ocupacion</b></label>
                <input type="text" value="{{ $beneficiario->ocupacion->ocupacion }}" class="form-control font-roboto-12" disabled>
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-5 pr-1 pl-1">
                <label for="" class="d-inline"><b>Barrio / Comunidad</b></label>
                <input type="text" value="{{ $beneficiario->barrio->nombre }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-7 pr-1 pl-1">
                <label for="" class="d-inline"><b>Direccion</b></label>
                <input type="text" value="{{ $beneficiario->direccion }}" class="form-control font-roboto-12" disabled>
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-2 pr-1 pl-1">
                <label for="" class="d-inline"><b>Firma</b></label>
                <input type="text" value="{{ $beneficiario->firma }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="" class="d-inline"><b>Fecha de Registro</b></label>
                <input type="text" value="{{ \Carbon\Carbon::parse($beneficiario->created_att)->format('d/m/Y') }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="" class="d-inline"><b>Estado</b></label>
                <input type="text" value="{{ $beneficiario->status }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-3 pr-1 pl-1">
                <label for="" class="d-inline"><b>Latitud</b></label>
                <input type="text" value="{{ $beneficiario->latitud }}" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-3 pr-1 pl-1">
                <label for="" class="d-inline"><b>Longitud</b></label>
                <input type="text" value="{{ $beneficiario->longitud }}" class="form-control font-roboto-12" disabled>
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-12 pr-1 pl-1">
                <label for="" class="d-inline"><b>Observaciones</b></label>
                <textarea class="form-control font-roboto-12" disabled>{{ $beneficiario->obs }}</textarea>
            </div>
        </div>
        @if ($beneficiario->latitud != null && $beneficiario->longitud != null)
            <div class="form-group row font-roboto-12">
                <div class="col-md-12 pr-1 pl-1 text-center">
                    <strong>MAPA DE UBICACION</strong>
                </div>
                <div class="col-md-12 pr-1 pl-1">
                    <div id="map"></div>
                    <p id="coordinates"></p>
                </div>
            </div>
        @endif
        @isset($historial)
            <div class="form-group row abs-center">
                <div class="col-md-8 pr-1 pl-1 font-roboto-12 text-center">
                    <b>HISTORIAL DE CAMBIOS</b>
                </div>
                <div class="col-md-8 pr-1 pl-1">
                    <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="#">
                        <thead>
                            <tr class="font-roboto-12">
                                <th class="text-left p-1">FECHA</th>
                                <th class="text-left p-1">OBSERVACION</th>
                                <th class="text-center p-1">USUARIO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($historial as $datos)
                                <tr class="font-roboto-12">
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
        $(window).on('load', function(){
            map.invalidateSize();
        });

        let map = L.map('map').setView(["{{ $beneficiario->latitud }}", "{{ $beneficiario->longitud }}"], 15);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://granchaco.gob.bo/copyright">Ir a sitio Oficial</a>'
        }).addTo(map);

        var redIcon = L.icon({
            iconUrl: '/images/marcador_1.png',
            iconSize: [50, 50],
            iconAnchor: [25, 50],
            popupAnchor: [0, -50]
        });

        var marker = L.marker(["{{ $beneficiario->latitud }}", "{{ $beneficiario->longitud }}"], { icon: redIcon }).addTo(map)/*.bindPopup('Ubicacion')*/.openPopup();

        function ir_atras(){
            window.location.href = "{{ route('beneficiarios.index') }}";
        }

        function exportar_pdf(){
            var beneficiario_id = $("#beneficiario_id").val();
            var url = "{{ route('beneficiarios.pdf',':beneficiario_id') }}";
            url = url.replace(':beneficiario_id',beneficiario_id);
            window.location.href = url;
        }
    </script>
@endsection

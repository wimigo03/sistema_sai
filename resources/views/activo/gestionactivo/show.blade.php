@extends('layouts.dashboard')
@section('content')
    <div class="row font-verdana-12">
        <div class="col-md-8 titulo">

                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="javascript:void(0);" onclick="window.history.back()">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>
            <b>ACTIVO {{ $actual->codigo }}</b>
        </div>

        <div class="col-md-12">
            <hr class="hrr">
            <b>ENTIDAD:</b> {{ $entidad->entidad }}-{{ $entidad->desc_ent }}<span></span>
            <hr class="hrr">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <b>CODIGO:</b>
            <h6>{{ $actual->codigo }}</h6>
        </div>
        <div class="col-md-3">
            <b>DESCRIPCION:</b>
            <h6>{{ $actual->descrip }}</h6>
        </div>
        <div class="col-md-3">
            <b>CODIGO CONTABLE:</b>
            <h6>{{ optional($actual->codconts)->nombre }}</h6>
        </div>
        <div class="col-md-3">
            <b>AUXILIAR CONTABLE:</b>
            <h6>{{ optional($auxiliar)->nomaux }}</h6>
        </div>
        <div class="col-md-3">
            <b>FEUL:</b>
            <h6>{{ $actual->ano }}-{{ $actual->mes }}-{{ $actual->dia }}</h6>
        </div>
        <div class="col-md-3">
            <b>USUARIO:</b>
            <h6>{{ $actual->usuar }}</h6>
        </div>
        <div class="col-md-3">
            <b>OFICINA:</b>
            <h6>{{ optional($actual->areas)->nombrearea }}</h6>
        </div>
        <div class="col-md-3">
            <b>RESPONSABLE:</b>
            <h6>{{ optional($actual->empleados)->full_name }}</h6>
        </div>
        <div class="col-md-3">
            <b>CARGO:</b>
            <h6>{{ optional($actual->empleados)->file ? $actual->empleados->file->nombrecargo : null }}</h6>
        </div>
        <div class="col-md-3">
            <b>C.I.:</b>
            <h6>{{ optional($actual->empleados)->ci }}</h6>
        </div>
        <div class="col-md-3">
            <b>COSTO:</b>
            <h6>{{ $actual->costo }}</h6>
        </div>
        <div class="col-md-3">
            <b>VIDA UTIL:</b>
            <h6>{{ $actual->vidautil }}</h6>
        </div>
        <div class="col-md-3">
            <b>ORGANIZMO FINANCIERO:</b>
            <h6>{{ optional($actual->organismofins)->des }}</h6>
        </div>
        <div class="col-md-3">
            <b>ESTADO:</b>
            @if ($actual->codestado == 1)
                <h6>BUENO</h6>
            @elseif($actual->codestado == 2)
                <h6>REGULAR</h6>
            @elseif($actual->codestado == 3)
                <h6>MALO</h6>
            @endif
        </div>
        <div class="col-md-3">
            <b>OBSERVACIONES</b>
            <h6>{{ $actual->observaciones }}</h6>
        </div>
        <div class="col-md-3">
            <b>AMBIENTE</b>
            <h6>{{ optional($actual->ambiente)->nombre }}</h6>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <b>COSTO INICIAL:</b>
            <h6>{{ $actual->costo }}</h6>
        </div>
        <div class="col-md-3">
            <b>FACTOR ACTUAL:</b>
            <h6 id="factor_actual"></h6>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <b>VIDA UTIL:</b>
            <h6>{{ $actual->vidautil }}</h6>
        </div>
        <div class="col-md-2">
            <b>DEPRE ACUM INICIAL:</b>
            <h6 id="depre_acumulada_inicial"></h6>
        </div>
        <div class="col-md-2">
            <b>% DEPRECIACION:</b>
            <h6>
                @if($actual->vidautil != 0)
                    {{ number_format((1 / $actual->vidautil) * 100, 2) }}
                @else
                    0
                @endif
            </h6>
            
        </div>
        <div class="col-md-2">
            <b>DEPRE GESTION:</b>
            <h6 id="depre_gestion"></h6>
        </div>
        <div class="col-md-2">
            <b>DEPRE ACUMULADA:</b>
            <h6 id="depre_acumulada"></h6>
        </div>
        <div class="col-md-2">
            <b>VALOR NETO:</b>
            <h6 id="valor_actual"></h6>
        </div>
        <div class="col-md-2">
            <b>VALOR ACTUAL:</b>
            <h6 id="valor_neto"></h6>
        </div>
        <div class="col-md-3">
            <b>CALCULADO A:</b>
            <h6>{{ date('d-m-Y') }}</h6>
        </div>
        <div class="col-md-3">
            <b>Ufv Inicial:</b>
            <h6>{{ $ufInicial }}</h6>
        </div>
        <div class="col-md-3">
            <b>Ufv Actual:</b>
            <h6>{{ $ufActual }}</h6>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h3>Imagenes</h3>

            <div class="form-group">
                @forelse ($actual->imagenes as $imagen)
                    <img src="{{ asset('public/images/' . $imagen->ruta) }}" alt="Imagen Actual" style="height: 150px;">
                @empty
                    <span class="text-center">No se han cargado imagenes</span>
                @endforelse
            </div>
        </div>
        <div class="col-12">
            <h3>Ubicaciones</h3>
            <table class="table-bordered hoverTable" id="table-ubicaciones" style="width:100%;">
                <thead class="font-courier">
                    <tr>
                        <td class="text-center p-1 font-weight-bold"><b>N°</b></td>
                        <td class="text-center p-1 font-weight-bold"><b>Latitud</b></td>
                        <td class="text-center p-1 font-weight-bold"><b>Longitud</b></td>
                        <td class="text-center p-1 font-weight-bold"><b>Creado por</b></td>
                        <td class="text-center p-1 font-weight-bold"><b>Fecha</b></td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="input-group">
                <div id="mapa" style="height: 420px; width: 100%;"></div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="{{ asset('js/depreciar.js') }}"></script>
        <script>
            $(document).ready(function() {
                var vidaUtil = "{{ $actual->vidautil }}"
                var costoInicial = "{{ $actual->costo }}"
                var fechaInicial = new Date(
                    '{{ $actual->ano }}',
                    '{{ $actual->mes - 1 }}',
                    '{{ $actual->dia }}'
                );
                var ufInicial = '{{ $ufInicial }}';
                var ufActual = '{{ $ufActual }}';
                $('#factor_actual').html(
                    factorActual(ufInicial, ufActual).toFixed(6)
                );
                function roundToTwoDecimals(num) {
                    return Math.ceil(num * 100) / 100;
                }
                $('#depre_acumulada').html(
                    getTwoDecimals(
                        depreciacionAcumulada(costoInicial, vidaUtil, fechaInicial, ufInicial, ufActual)
                    )
                );
                $('#valor_actual').html(
                    valorNeto(costoInicial, vidaUtil, fechaInicial, ufInicial,ufActual).toFixed(2)
                );
                $('#valor_neto').html(
                    valorActual(costoInicial, ufInicial,ufActual).toFixed(2)
                );
                $('#depre_gestion').html(
                    getTwoDecimals(
                        depreciacionAcumuladaGestion(costoInicial, vidaUtil, ufInicial,ufActual)
                    )
                );
                $('#depre_acumulada_inicial').html(
                    getTwoDecimals(
                        depreciacionAcumuladaInicial(costoInicial, vidaUtil, fechaInicial, ufInicial,ufActual)
                    )
                );
            });
            function getTwoDecimals(num) {
                return Math.floor(num * 100) / 100;
            }
        </script>

        <script>
            function initMap() {

            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD73WmrwkgvJi5CLHprURygkrcTJerWGIk&callback=initMap">
        </script>
        <script type="text/javascript">
            let ubicaciones = [];
            $(document).ready(function() {
                $('#table-ubicaciones').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: "{{ route('activo.ubicaciones.listado', $actual->id) }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            class: 'text-justify p-1 font-verdana'
                        },
                        {
                            data: 'latitude',
                            name: 'latitude',
                            class: 'text-justify p-1 font-verdana'
                        },
                        {
                            data: 'longitude',
                            name: 'longitude',
                            class: 'text-justify p-1 font-verdana'
                        },
                        {
                            data: 'user_name',
                            name: 'user_name',
                            class: 'text-justify p-1 font-verdana'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            class: 'text-justify p-1 font-verdana'
                        },
                    ],
                    language: {},
                    createdRow: function(row, data, dataIndex) {
                        var ubicacion = {
                            latitude: parseFloat(data.latitude),
                            longitude: parseFloat(data.longitude),
                            created_at: data.created_at,
                            user_name: data.user_name
                        };
                        ubicaciones.push(ubicacion);
                    },
                    initComplete: function(settings, json) {
                        initMap(ubicaciones);
                    }
                });
            });

            function initMap(ubicaciones) {
                if (!Array.isArray(ubicaciones) || ubicaciones.length === 0) {
                    return;
                }

                var mapa = new google.maps.Map(document.getElementById("mapa"), {
                    center: {
                        lat: ubicaciones[0].latitude,
                        lng: ubicaciones[0].longitude
                    },
                    zoom: 10
                });
                ubicaciones.forEach(function(ubicacion, index) {
                    var latLng = new google.maps.LatLng(ubicacion.latitude, ubicacion.longitude);
                    var marker = new google.maps.Marker({
                        position: latLng,
                        map: mapa,
                        title: 'Creado en: ' + ubicacion.created_at + ' por el usuario: ' + ubicacion.user_name,
                        label: (index + 1).toString()
                    });
                });
            }
        </script>
    @endsection
@endsection

@extends('layouts.admin')
@section('content')
    <style>
        .font-verdana-12 th {
            background-color: white !important;
            color: black;
        }
    </style>

    <div class="row font-verdana-12">
        <div class="titulo col-md-12 mb-3">
            
            <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                <a href="javascript:void(0);" onclick="window.history.back()">
                    <span class="color-icon-1">
                        &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                    </span>
                </a>
            </span>
            <b>{{ $activo->descrip }} - {{ $activo->codigo }}</b>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <center>
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
            </center>
        </div>
    </div>
    <div class="input-group">
        <div id="mapa" style="height: 420px; width: 100%;"></div>
    </div>

    <div class="modal fade" id="modalArchivo" tabindex="-1" aria-labelledby="modalArchivo" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo_modal"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="body-border ">
                        <form method="POST" action="#" enctype="multipart/form-data">
                            <div class="form-group row font-verdana-sm">
                                <input type="hidden" id="id">
                                <input type="hidden" id="activo_id" value="{{ $activo->id }}">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label style="color:black;font-weight: bold;">DESCRIPCION:</label>
                                        <input type="text" id="descripcion" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label style="color:black;font-weight: bold;">ARCHIVO ADJUNTO:</label>
                                        <input class="form-control" type="file" id="ruta" accept="image/*" required>
                                    </div>
                                </div>
                                <div class="btn-group ml-auto">
                                    <button class="btn btn-primary btn-sm" id="btn_store_imagen" type="submit">
                                        <i class="fa-solid fa-paper-plane mr-2"></i>REGISTRAR
                                    </button>
                                    <button class="btn btn-primary btn-sm" id="btn_update_imagen" type="submit">
                                        <i class="fa-solid fa-paper-plane mr-2"></i>ACTUALIZAR
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
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
                ajax: "{{ route('activo.ubicaciones.listado', $id) }}",
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

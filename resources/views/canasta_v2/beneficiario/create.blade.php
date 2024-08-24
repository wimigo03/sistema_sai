<!DOCTYPE html>
@extends('layouts.admin')
<style>
    #map {
            height: 500px;
            width: 100%;
        }

    .locate-btn {
        position: absolute;
        top: 10px;
        left: 95%;
        z-index: 1000;
        background-color: white;
        border: none;
        padding: 0px 5px 0px 5px;
        cursor: pointer;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    }
</style>
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>REGISTRO DE BENEFICIARIO</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('canasta_v2.beneficiario.partials.formCreate')
    </div>
@endsection
@section('scripts')
    <script>
        // Inicializa el mapa
        let map = L.map('map').setView([-22.02887002864307, -63.67736932020581], 15); // Coordenadas iniciales

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://granchaco.gob.bo/copyright">Ir a sitio Oficial</a>'
        }).addTo(map);

        var redIcon = L.icon({
            iconUrl: '/images/marcador_1.png', // Ruta a tu icono rojo
            iconSize: [50, 50], // Tamaño del icono
            iconAnchor: [25, 50], // Punto en el icono que se alineará con el marcador
            popupAnchor: [0, -50] // Punto desde el cual se abrirá el popup
        });

        var marker = L.marker([-22.02887002864307, -63.67736932020581], { icon: redIcon }).addTo(map).bindPopup('Ubicacion actual.').openPopup();

        function centerMapOnLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;

                    // Mueve el mapa y agrega un marcador en la ubicación actual
                    map.setView([lat, lng], 15);
                    marker.setLatLng([lat, lng]);
                    document.getElementById('coordinates').innerText = 'Latitud: ' + lat + ', Longitud: ' + lng;
                    document.getElementById('latitud').value = lat;
                    document.getElementById('longitud').value = lng;
                    //console.log(lat,lng);
                }, function(error) {
                    console.error('Error al obtener la ubicación: ', error);
                    alert('No se pudo obtener la ubicación. Asegúrate de que los permisos de ubicación estén habilitados.');
                });
            } else {
                alert('La geolocalización no es soportada por este navegador.');
            }
        }

        document.querySelector('.locate-btn').addEventListener('click', centerMapOnLocation);

        map.on('click', function(e) {
            var latLng = e.latlng;
            marker.setLatLng(latLng);
            document.getElementById('coordinates').innerText = 'Latitud: ' + latLng.lat + ', Longitud: ' + latLng.lng;
            document.getElementById('latitud').value = latLng.lat;
            document.getElementById('longitud').value = latLng.lng;
            //console.log(latLng.lat,latLng.lng);
        });

        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            var cleave = new Cleave('#fnac', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fnac").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });
        });

        function Modal(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('beneficiarios.index') }}";
        }

        function save() {
            if (validar_formulario() == true) {
                document.getElementById('latitud').disabled = false;
                document.getElementById('longitud').disabled = false;
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        }

        function validar_formulario() {
            if ($("#nombres").val() == "") {
                Modal("El campo <b>[NOMBRES]</b> es obligatorio.");
                return false;
            }

            if ($("#ap").val() == "") {
                if ($("#am").val() == "") {
                    Modal("El campo <b>[Apellido Paterno o Apellido Materno]</b> es obligatorio.");
                    return false;
                }
            }

            if ($("#am").val() == "") {
                if ($("#ap").val() == "") {
                    Modal("El campo <b>[Apellido Paterno o Apellido Materno]</b> es un dato obligatorio.");
                    return false;
                }
            }
            if ($("#fnac").val() == "") {
                Modal("El campo <b>[Fecha de Nacimiento]</b> es obligatorio.");
                return false;
            }

            if ($("#estado_civil>option:selected").val() == "") {
                Modal("El campo <b>[Estado Civil]</b> es obligatorio.");
                return false;
            }
            if ($("#sexo>option:selected").val() == "") {
                Modal("El campo <b>[Sexo]</b> es obligatorio.");
                return false;
            }

            if ($("#ci").val() == "") {
                Modal("El campo <b>[Nro de Carnet]</b> es obligatorio.");
                return false;
            }

            if ($("#expedido").val() == "") {
                Modal("El campo <b>[Expedido]</b> es obligatorio.");
                return false;
            }

            if ($("#firma").val() == "") {
                Modal("El campo <b>[Firma]</b> es obligatorio.");
                return false;
            }

            if ($("#estado>option:selected").val() == "") {
                Modal("El campo <b>[Estado]</b> es obligatorio.");
                return false;
            }

            if ($("#direccion").val() == "") {
                Modal("El campo <b>[Direccion]</b> es obligatorio.");
                return false;
            }

            if ($("#barrio>option:selected").val() == "") {
                Modal("El campo <b>[Barrio]</b> es obligatorio.");
                return false;
            }

            if ($("#ocupacion>option:selected").val() == "") {
                Modal("El campo <b>[Ocupacion]</b> es obligatorio.");
                return false;
            }

            return true;
        }
    </script>
@endsection

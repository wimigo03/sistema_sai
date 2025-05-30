<!DOCTYPE html>
@extends('layouts.dashboard')
<style>
    #map {
            height: 500px;
            width: 100%;
        }

    .locate-btn {
        position: absolute;
        top: 450px;
        left: 13px;
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
    <div class="form-group row">
        <div class="col-md-12 pr-1 pl-1 text-center header">
            <b>REGISTRO DE BENEFICIARIO</b>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 pr-1 pl-1">
            @include('canasta_v2.beneficiario.partials.formUpdate')
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        proj4.defs("EPSG:32720", "+proj=utm +zone=20 +south +datum=WGS84 +units=m +no_defs");
        var _brigadista = "{{ $brigadista }}";
        if(_brigadista){
            document.getElementById('barrio').disabled = true;
            document.getElementById('estado').disabled = true;
            document.getElementById('nombres').disabled = true;
            document.getElementById('ap').disabled = true;
            document.getElementById('am').disabled = true;
            document.getElementById('ci').disabled = true;
            document.getElementById('expedido').disabled = true;
            document.getElementById('fnac').disabled = true;
            document.getElementById('sexo').disabled = true;
            document.getElementById('check_titular').disabled = true;
            document.getElementById('seguro_medico').disabled = true;
            document.getElementById('direccion').disabled = true;
        }
        document.getElementById('latitud').value = "";
        document.getElementById('longitud').value = "";
        document.getElementById('utmy').value = "";
        document.getElementById('utmx').value = "";
        document.getElementById('latitud').disabled = true;
        document.getElementById('longitud').disabled = true;
        document.getElementById('utmy').disabled = true;
        document.getElementById('utmx').disabled = true;
        var _latitud = "{{ isset($beneficiario) ? $beneficiario->latitud : '' }}";
        var _longitud = "{{ isset($beneficiario) ? $beneficiario->longitud : '' }}";
        var _utmy = "{{ isset($beneficiario) ? $beneficiario->utmy : '' }}";
        var _utmx = "{{ isset($beneficiario) ? $beneficiario->utmx : '' }}";
        let map = L.map('map').setView([_latitud, _longitud], 25);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://granchaco.gob.bo/copyright">Ir a sitio Oficial</a>'
        }).addTo(map);

        var redIcon = L.icon({
            iconUrl: '/images/marcador_1.png',
            iconSize: [50, 50],
            iconAnchor: [25, 50],
            popupAnchor: [0, -50]
        });

        var marker = L.marker([_latitud, _longitud], { icon: redIcon }).addTo(map).openPopup();

        if (_latitud !== null && _longitud !== null && _latitud !== "" && _longitud !== "") {
            var marker = L.marker([_latitud, _longitud], { icon: redIcon }).addTo(map).openPopup();
            document.getElementById('latitud').value = _latitud;
            document.getElementById('longitud').value = _longitud;
            document.getElementById('utmy').value = _utmy;
            document.getElementById('utmx').value = _utmx;
        } else {
            InitMapOnLocation();
        }

        function InitMapOnLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    map.setView([lat, lng], 25);
                    marker.setLatLng([lat, lng]);
                    document.getElementById('coordinates').innerText = 'Latitud: ' + lat + ', Longitud: ' + lng;
                }, function(error) {
                    console.error('Error al obtener la ubicación: ', error);
                    alert('No se pudo obtener la ubicación. Asegúrate de que los permisos de ubicación estén habilitados.');
                });
            } else {
                alert('La geolocalización no es soportada por este navegador.');
            }
        }

        function centerMapOnLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;

                    var utmCoords = proj4('EPSG:4326', 'EPSG:32720', [lng, lat]);

                    map.setView([lat, lng], 25);
                    marker.setLatLng([lat, lng]);
                    document.getElementById('coordinates').innerText = 'Latitud: ' + lat + ', Longitud: ' + lng;
                    document.getElementById('latitud').value = lat;
                    document.getElementById('longitud').value = lng;
                    document.getElementById('utmy').value = utmCoords[1];
                    document.getElementById('utmx').value = utmCoords[0];
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
            var _utmCoords = proj4('EPSG:4326', 'EPSG:32720', [latLng.lng, latLng.lat]);
            document.getElementById('coordinates').innerText = 'Latitud: ' + latLng.lat + ', Longitud: ' + latLng.lng;
            document.getElementById('latitud').value = latLng.lat;
            document.getElementById('longitud').value = latLng.lng;
            document.getElementById('utmy').value = _utmCoords[1];
            document.getElementById('utmx').value = _utmCoords[0];
        });

        $("#toggleButton").click(function() {
            $("#form-map").slideToggle();
        });

        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            var cleave = new Cleave('#celular', {
                numeral: true,
                numeralDecimalScale: 0,
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: false
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

            CheckSeguroMedico();

            $('#estado_civil').change(function() {
                var estadoCivil = $(this).val();
                if (estadoCivil === "Casado(a)" || estadoCivil === "Concubino(a)") {
                    $('#form_ci_pareja').show();
                } else {
                    $('#form_ci_pareja').hide();
                }
            });

            $('#estado_civil').trigger('change');
        });

        function CheckSeguroMedico() {
            var checkbox = document.getElementById('check_seguro_medico');
            if (checkbox.checked) {
                document.getElementById('seguro_medico').disabled = false;
                document.getElementById('check_titular').disabled = false;
            } else {
                const checkbox = document.getElementById('check_titular');
                checkbox.checked = false;
                $('#seguro_medico').val('').trigger('change');
                document.getElementById('seguro_medico').disabled = true;
                document.getElementById('check_titular').disabled = true;
            }
        }

        function toggleCheckboxes(clickedCheckbox) {
            const checkboxes = document.querySelectorAll('input[name="informacion"]');

            if (clickedCheckbox.checked) {
                // Desmarcar y deshabilitar todos los checkboxes excepto el clickeado
                checkboxes.forEach((checkbox) => {
                    if (checkbox !== clickedCheckbox) {
                        checkbox.checked = false; // Desmarcar
                        checkbox.disabled = true; // Deshabilitar
                    }
                });
            } else {
                // Habilitar todos los checkboxes si ninguno está seleccionado
                checkboxes.forEach((checkbox) => {
                    checkbox.disabled = false;
                });
            }
        }

        function Modal(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        function brigadista_cancelar(){
            window.location.href = "{{ route('beneficiarios.brigadista.index') }}";
        }

        function cancelar(){
            window.location.href = "{{ route('beneficiarios.index') }}";
        }

        function procesar() {
            var check_informacion = document.getElementById('informacion');
            if (!check_informacion.checked) {
                if(!validar()){
                    return false;
                }
            }else{
                if(_validar()){
                    check_informacion.checked = false;
                }
            }

            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function confirmar(){
            document.getElementById('barrio').disabled = false;
            document.getElementById('estado').disabled = false;
            document.getElementById('nombres').disabled = false;
            document.getElementById('ap').disabled = false;
            document.getElementById('am').disabled = false;
            document.getElementById('ci').disabled = false;
            document.getElementById('expedido').disabled = false;
            document.getElementById('fnac').disabled = false;
            document.getElementById('sexo').disabled = false;
            document.getElementById('direccion').disabled = false;
            document.getElementById('latitud').disabled = false;
            document.getElementById('longitud').disabled = false;
            document.getElementById('utmy').disabled = false;
            document.getElementById('utmx').disabled = false;
            $("#form").submit();
        }

        function validar() {
            if ($("#barrio >option:selected").val() == "") {
                Modal("<b>[Por favor seleccionar un Barrio]</b>");
                return false;
            }
            if ($("#estado>option:selected").val() == "") {
                Modal("El campo <b>[Estado]</b> es obligatorio.");
                return false;
            }
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
            if ($("#ci").val() == "") {
                Modal("El campo <b>[Nro de Carnet]</b> es obligatorio.");
                return false;
            }
            if ($("#expedido").val() == "") {
                Modal("El campo <b>[Expedido]</b> es obligatorio.");
                return false;
            }
            if ($("#celular").val() == "") {
                Modal("El campo <b>[Celular]</b> es obligatorio.");
                return false;
            }
            if ($("#fnac").val() == "") {
                Modal("El campo <b>[Fecha de Nacimiento]</b> es obligatorio.");
                return false;
            }
            if ($("#sexo>option:selected").val() == "") {
                Modal("El campo <b>[Sexo]</b> es obligatorio.");
                return false;
            }
            if ($("#estado_civil>option:selected").val() == "") {
                Modal("El campo <b>[Estado Civil]</b> es obligatorio.");
                return false;
            }
            if ($("#estado_civil>option:selected").val() == "Casado(a)" || $("#estado_civil>option:selected").val() == "Concubino(a)") {
                if ($("#ci_pareja").val() == "") {
                    Modal("El campo <b>[Nro de Carnet Pareja]</b> es obligatorio.");
                    return false;
                }
            }
            if ($("#profesion >option:selected").val() == "") {
                Modal("El campo <b>[Profesion]</b> es obligatorio.");
                return false;
            }
            if ($("#ocupacion >option:selected").val() == "") {
                Modal("El campo <b>[Ocupacion]</b> es obligatorio.");
                return false;
            }
            if ($("#categoria >option:selected").val() == "") {
                Modal("El campo <b>[Categoria]</b> es obligatorio.");
                return false;
            }
            var check_seguro_medico = document.getElementById('check_seguro_medico');
            if (check_seguro_medico.checked) {
                if ($("#seguro_medico >option:selected").val() == "") {
                    Modal("El campo <b>[Seguro Medico]</b> es obligatorio.");
                    return false;
                }
            }
            if ($("#firma").val() == "") {
                Modal("El campo <b>[Firma]</b> es obligatorio.");
                return false;
            }
            if ($("#direccion").val() == "") {
                Modal("El campo <b>[Direccion]</b> es obligatorio.");
                return false;
            }
            return true;
        }

        function _validar() {
            if ($("#barrio >option:selected").val() == "") {
                return false;
            }
            if ($("#estado>option:selected").val() == "") {
                return false;
            }
            if ($("#nombres").val() == "") {
                return false;
            }
            if ($("#ap").val() == "") {
                if ($("#am").val() == "") {
                    return false;
                }
            }
            if ($("#am").val() == "") {
                if ($("#ap").val() == "") {
                    return false;
                }
            }
            if ($("#ci").val() == "") {
                return false;
            }
            if ($("#expedido").val() == "") {
                return false;
            }
            if ($("#celular").val() == "") {
                return false;
            }
            if ($("#fnac").val() == "") {
                return false;
            }
            if ($("#sexo>option:selected").val() == "") {
                return false;
            }
            if ($("#estado_civil>option:selected").val() == "") {
                return false;
            }
            if ($("#profesion >option:selected").val() == "") {
                return false;
            }
            if ($("#ocupacion >option:selected").val() == "") {
                return false;
            }
            var check_seguro_medico = document.getElementById('check_seguro_medico');
            if (check_seguro_medico.checked) {
                if ($("#seguro_medico >option:selected").val() == "") {
                    return false;
                }
            }
            if ($("#firma").val() == "") {
                return false;
            }
            if ($("#direccion").val() == "") {
                return false;
            }
            return true;
        }
    </script>
@endsection

<!DOCTYPE html>
@extends('layouts.admin')
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
            <b><u>ACTUALIZAR REGISTRO DE BENEFICIARIO</u></b>
            @can('canasta.beneficiarios.brigadista.index')
                <span class="font-roboto-12 float-right" onclick="brigadista_cancelar();">
                    <i class="fa-solid fa-xmark fa-fw"></i>
                </span>
            @endcan
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
        document.getElementById('barrio').disabled = true;
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
        document.getElementById('latitud').value = "";
        document.getElementById('longitud').value = "";
        document.getElementById('utmy').value = "";
        document.getElementById('utmx').value = "";
        document.getElementById('latitud').disabled = true;
        document.getElementById('longitud').disabled = true;
        document.getElementById('utmy').disabled = true;
        document.getElementById('utmx').disabled = true;
        var _latitud = "{{ $beneficiario->latitud }}";
        var _longitud = "{{ $beneficiario->longitud }}";
        var _utmy = "{{ $beneficiario->utmy }}";
        var _utmx = "{{ $beneficiario->utmx }}";
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
            /*if ($("#estado>option:selected").val() == "") {
                Modal("El campo <b>[Estado]</b> es obligatorio.");
                return false;
            }*/
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
            if ($("#profesion >option:selected").val() == "") {
                Modal("El campo <b>[Profesion]</b> es obligatorio.");
                return false;
            }
            if ($("#ocupacion >option:selected").val() == "") {
                Modal("El campo <b>[Ocupacion]</b> es obligatorio.");
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
            if ($("#observacion").val() == "") {
                Modal("El campo <b>[Observacion]</b> es obligatorio.");
                return false;
            }
            if ($("#latitud").val() == "") {
                Modal("<b>[Algo anda mal con la ubicacion en el mapa]</b>");
                return false;
            }
            if ($("#longitud").val() == "") {
                Modal("<b>[Algo anda mal con la ubicacion en el mapa]</b>");
                return false;
            }
            if ($("#utmx").val() == "") {
                Modal("<b>[Algo anda mal con la ubicacion en el mapa]</b>");
                return false;
            }
            if ($("#utmy").val() == "") {
                Modal("<b>[Algo anda mal con la ubicacion en el mapa]</b>");
                return false;
            }
            if ($("#detalle_vivienda").val() == "") {
                Modal("<b>[Por favor complete la descripcion de la vivienda]</b>");
                return false;
            }
            if ($("#tipo_vivienda >option:selected").val() == "") {
                Modal("<b>[Por favor seleccione un Tipo de Vivienda]</b>");
                return false;
            }
            if ($("#material_vivienda >option:selected").val() == "") {
                Modal("<b>[Por favor seleccione un Material de Vivienda]</b>");
                return false;
            }
            if ($("#vecino_1").val() == "") {
                if ($("#vecino_2").val() == "") {
                    if ($("#vecino_3").val() == "") {
                        Modal("<b>[Por favor complete los datos de los vecinos que identifican al beneficiario]</b>");
                        return false;
                    }
                }
            }
            if ($("#_file_documento").val() == "") {
                if ($("#file").val() == "") {
                    Modal("<b>[No se encuentra el archivo de imagen del BENEFICIARIO]</b>");
                    return false;
                }
            }
            /*if ($("#_file_documento").val() != "") {
                var fileInput = $("#_file_documento")[0].files[0];
                if (fileInput) {
                    var allowedTypes = ['image/jpeg', 'image/jpg'];
                    var maxSizeInBytes = 10 * 1024 * 1024;

                    if (!allowedTypes.includes(fileInput.type)) {
                        Modal('[BENEFICIARIO] . Formato de archivo no permitido. Por favor, seleccione una imagen JPEG o JPG.');
                        $("#_file_documento").val('');
                        return false;
                    } else if (fileInput.size > maxSizeInBytes) {
                        Modal('[BENEFICIARIO] . El archivo es demasiado grande. El tamaño máximo permitido es de 10MB.');
                        $("#_file_documento").val('');
                        return false;
                    }
                }
            }*/
            if ($("#_file_ci_anverso").val() == "") {
                if ($("#file_ci_anverso").val() == "") {
                    Modal("<b>[No se encuentra el archivo de imagen de la FOTO CARNET - ANVERSO]</b>");
                    return false;
                }
            }
            /*if ($("#file_ci_anverso").val() != "") {
                var fileInput = $("#file_ci_anverso")[0].files[0];
                if (fileInput) {
                    var allowedTypes = ['image/jpeg', 'image/jpg'];
                    var maxSizeInBytes = 10 * 1024 * 1024;

                    if (!allowedTypes.includes(fileInput.type)) {
                        Modal('[FOTO CARNET - ANVERSO] . Formato de archivo no permitido. Por favor, seleccione una imagen JPEG o JPG.');
                        $("#file_ci_anverso").val('');
                        return false;
                    } else if (fileInput.size > maxSizeInBytes) {
                        Modal('[FOTO CARNET - ANVERSO] . El archivo es demasiado grande. El tamaño máximo permitido es de 10MB.');
                        $("#file_ci_anverso").val('');
                        return false;
                    }
                }
            }*/
            if ($("#_file_ci_reverso").val() == "") {
                if ($("#file_ci_reverso").val() == "") {
                    Modal("<b>[No se encuentra el archivo de imagen de la FOTO CARNET - REVERSO]</b>");
                    return false;
                }
            }
            /*if ($("#file_ci_reverso").val() != "") {
                var fileInput = $("#file_ci_reverso")[0].files[0];
                if (fileInput) {
                    var allowedTypes = ['image/jpeg', 'image/jpg'];
                    var maxSizeInBytes = 10 * 1024 * 1024;

                    if (!allowedTypes.includes(fileInput.type)) {
                        Modal('[FOTO CARNET - REVERSO] . Formato de archivo no permitido. Por favor, seleccione una imagen JPEG o JPG.');
                        $("#file_ci_reverso").val('');
                        return false;
                    } else if (fileInput.size > maxSizeInBytes) {
                        Modal('[FOTO CARNET - REVERSO] . El archivo es demasiado grande. El tamaño máximo permitido es de 10MB.');
                        $("#file_ci_reverso").val('');
                        return false;
                    }
                }
            }*/

            return true;
        }

        function _validar() {
            if ($("#barrio >option:selected").val() == "") {
                return false;
            }
            /*if ($("#estado>option:selected").val() == "") {
                return false;
            }*/
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
            if ($("#observacion").val() == "") {
                return false;
            }
            if ($("#latitud").val() == "") {
                return false;
            }
            if ($("#longitud").val() == "") {
                return false;
            }
            if ($("#utmx").val() == "") {
                return false;
            }
            if ($("#utmy").val() == "") {
                return false;
            }
            if ($("#detalle_vivienda").val() == "") {
                return false;
            }
            if ($("#tipo_vivienda >option:selected").val() == "") {
                return false;
            }
            if ($("#material_vivienda >option:selected").val() == "") {
                return false;
            }
            if ($("#vecino_1").val() == "") {
                if ($("#vecino_2").val() == "") {
                    if ($("#vecino_3").val() == "") {
                        return false;
                    }
                }
            }
            if ($("#_file_documento").val() == "") {
                if ($("#file").val() == "") {
                    return false;
                }
            }
            /*if ($("#file_documento").val() != "") {
                var fileInput = $("#file")[0].files[0];
                if (fileInput) {
                    var allowedTypes = ['image/jpeg', 'image/jpg'];
                    var maxSizeInBytes = 10 * 1024 * 1024;

                    if (!allowedTypes.includes(fileInput.type)) {
                        $("#file").val('');
                        return false;
                    } else if (fileInput.size > maxSizeInBytes) {
                        $("#file").val('');
                        return false;
                    }
                }
            }*/
            if ($("#_file_ci_anverso").val() == "") {
                if ($("#file_ci_anverso").val() == "") {
                    return false;
                }
            }
            /*if ($("#file_ci_anverso").val() != "") {
                var fileInput = $("#file_ci_anverso")[0].files[0];
                if (fileInput) {
                    var allowedTypes = ['image/jpeg', 'image/jpg'];
                    var maxSizeInBytes = 10 * 1024 * 1024;

                    if (!allowedTypes.includes(fileInput.type)) {
                        $("#file_ci_anverso").val('');
                        return false;
                    } else if (fileInput.size > maxSizeInBytes) {
                        $("#file_ci_anverso").val('');
                        return false;
                    }
                }
            }*/
            if ($("#_file_ci_reverso").val() == "") {
                if ($("#file_ci_reverso").val() == "") {
                    return false;
                }
            }
            /*if ($("#file_ci_reverso").val() != "") {
                var fileInput = $("#file_ci_reverso")[0].files[0];
                if (fileInput) {
                    var allowedTypes = ['image/jpeg', 'image/jpg'];
                    var maxSizeInBytes = 10 * 1024 * 1024;

                    if (!allowedTypes.includes(fileInput.type)) {
                        $("#file_ci_reverso").val('');
                        return false;
                    } else if (fileInput.size > maxSizeInBytes) {
                        $("#file_ci_reverso").val('');
                        return false;
                    }
                }
            }*/

            return true;
        }

        /**/
        function sendForm(formData) {

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            fetch('/beneficiarios/subir-imagen', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Éxito:', data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        const file_documento = document.getElementById('file_documento');

        file_documento.addEventListener('change', function() {

            var id = $("#idBeneficiario").val();

            const formData = new FormData();
            formData.append('id', id);
            const fileName = file_documento.files[0].name;
            document.getElementById('_file_documento').value = fileName;

            changeFileToBase64(file_documento.files[0]).then(data => {
                let type = data.file.type;
                downscaleImage(data.base64, 1024, type, 0.6).then(image => {
                    urltoFile(image, data.file.name, data.file.type)
                    .then(file => {
                        formData.append(file_documento.id, file);
                        sendForm(formData);
                        //console.log('Archivo agregado al FormData:', file);
                    });
                });
            });
        });

        const file_ci_anverso = document.getElementById('file_ci_anverso');

        file_ci_anverso.addEventListener('change', function() {

            var id = $("#idBeneficiario").val();

            const formData = new FormData();
            formData.append('id', id);
            const fileName = file_ci_anverso.files[0].name;
            document.getElementById('_file_ci_anverso').value = fileName;

            changeFileToBase64(file_ci_anverso.files[0]).then(data => {
                let type = data.file.type;
                downscaleImage(data.base64, 1024, type, 0.6).then(image => {
                    urltoFile(image, data.file.name, data.file.type)
                    .then(file => {
                        formData.append(file_ci_anverso.id, file);
                        sendForm(formData);
                        //console.log('Archivo agregado al FormData:', file);
                    });
                });
            });
        });

        const file_ci_reverso = document.getElementById('file_ci_reverso');

        file_ci_reverso.addEventListener('change', function() {

            var id = $("#idBeneficiario").val();

            const formData = new FormData();
            formData.append('id', id);
            const fileName = file_ci_reverso.files[0].name;
            document.getElementById('_file_ci_reverso').value = fileName;

            changeFileToBase64(file_ci_reverso.files[0]).then(data => {
                let type = data.file.type;
                downscaleImage(data.base64, 1024, type, 0.6).then(image => {
                    urltoFile(image, data.file.name, data.file.type)
                    .then(file => {
                        formData.append(file_ci_reverso.id, file);
                        sendForm(formData);
                        //console.log('Archivo agregado al FormData:', file);
                    });
                });
            });
        });

        function urltoFile(url, filename, mimeType) {
            return fetch(url)
                .then(function (res) {
                    return res.arrayBuffer();
                })
                .then(function (buf) {
                    return new File([buf], filename, {type: mimeType});
                });
        }

        const toBase64 = file => new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = error => reject(error);
        });

        async function changeFileToBase64(file) {
            return {
                'base64': await toBase64(file),
                'file': file,
            };
        }

        function downscaleImage(dataUrl, newWidth, imageType, imageArguments) {
            return new Promise((resolve, reject) => {
                let image = new Image();

                image.onload = function() {
                    let oldWidth = image.width;
                    let oldHeight = image.height;
                    let newHeight = Math.floor(oldHeight / oldWidth * newWidth);

                    // Crear un canvas para dibujar la nueva imagen.
                    let canvas = document.createElement("canvas");
                    canvas.width = newWidth;
                    canvas.height = newHeight;

                    // Dibujar la nueva imagen comprimida en el canvas
                    let ctx = canvas.getContext("2d");
                    ctx.drawImage(image, 0, 0, newWidth, newHeight);

                    // Obtener el dataURL de la nueva imagen comprimida
                    let newDataUrl = canvas.toDataURL(imageType, imageArguments);
                    resolve(newDataUrl);
                };

                image.onerror = reject;
                image.src = dataUrl;
            });
        }


    </script>
@endsection

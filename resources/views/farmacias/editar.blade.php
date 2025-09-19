<!DOCTYPE html>
@extends('layouts.dashboard')
<style>
    .div_detalle, .div_cabecera {
        padding: 15px;
        border-radius: 8px;
        background-color: #f1f1f1;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .div_cabecera {
        margin-bottom: 20px;
    }

    .div_detalle {
        margin-top: 20px;
    }

    .row {
        margin-bottom: 15px;
    }

    .form-control {
        font-size: 14px;
        height: 38px;
    }

    .is-invalid {
        border: 1px solid red;
    }
</style>
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('farmacias.index') }}"> Farmacias</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Registrar</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fa-solid fa-plus fa-fw"></i>&nbsp;<b class="font-verdana-16">MODIFICAR REGISTRO DE FARMACIA</b>
        </div>

        <div class="card-body">
            @include('farmacias.partials.form')
        </div>
    </div>
    @section('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                $('.select2').select2({
                    theme: "bootstrap4",
                    placeholder: "--Seleccionar--",
                    width: '100%'
                });
            });

            var Modal = function(mensaje){
                $("#modal-alert .modal-body").html(mensaje);
                $('#modal-alert').modal({keyboard: false});
            }

            $('.intro').on('keypress', function(event) {
                if (event.which === 13) {
                    procesar();
                    event.preventDefault();
                }
            });

            function procesar() {
                if(!validar()){
                    return false;
                }

                $('#modal_confirmacion').modal({
                    keyboard: false
                })
            }

            function confirmar(){
                var url = "{{ route('farmacias.update') }}";
                $("#form").attr('action', url);
                $(".btn").hide();
                $(".spinner-btn").show();
                $("#form").submit();
            }

            function cancelar(){
                var url = "{{ route('farmacias.index') }}";
                window.location.href = url;
            }

            function validar(){
                if($("#barrio_id >option:selected").val() == ""){
                    Modal("Se debe seleccionar una <b>[BARRIO]</b> para continuar");
                    return false;
                }
                if($("#nombre").val() == ""){
                    Modal("Se debe agregar un <b>[NOMBRE]</b> para continuar.");
                    return false;
                }
                return true;
            }

            // Helpers existentes (sin cambios relevantes)
            async function changeFileToBase64(file) {
            return { base64: await toBase64(file), file };
            }
            const toBase64 = file => new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = error => reject(error);
            });
            function downscaleImage(dataUrl, newWidth, imageType, imageArguments) {
            return new Promise((resolve, reject) => {
                const image = new Image();
                image.onload = function () {
                const oldWidth = image.width;
                const oldHeight = image.height;
                const newHeight = Math.floor(oldHeight / oldWidth * newWidth);
                const canvas = document.createElement("canvas");
                canvas.width = newWidth;
                canvas.height = newHeight;
                const ctx = canvas.getContext("2d");
                ctx.drawImage(image, 0, 0, newWidth, newHeight);
                const newDataUrl = canvas.toDataURL(imageType, imageArguments);
                resolve(newDataUrl);
                };
                image.onerror = reject;
                image.src = dataUrl;
            });
            }
            function urltoFile(url, filename, mimeType) {
            return fetch(url)
                .then(res => res.arrayBuffer())
                .then(buf => new File([buf], filename, { type: mimeType }));
            }

            // NUEVO: lógica principal para farmacias
            const fileInput = document.getElementById('file_img');
            const preview   = document.getElementById('preview_img');

            fileInput.addEventListener('change', function () {
            const farmaciaId = document.getElementById('farmacia_id').value;
            if (!farmaciaId) {
                alert('Falta el ID de la farmacia.');
                fileInput.value = '';
                return;
            }
            if (!fileInput.files || !fileInput.files.length) return;

            const original = fileInput.files[0];
            // Validación básica en cliente
            const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!validTypes.includes(original.type)) {
                alert('Formato inválido. Usa JPG, PNG o WebP.');
                fileInput.value = '';
                return;
            }
            // (opcional) límite 10MB en cliente
            if (original.size > 10 * 1024 * 1024) {
                alert('La imagen supera 10MB.');
                fileInput.value = '';
                return;
            }

            const formData = new FormData();
            formData.append('farmacia_id', farmaciaId);

            changeFileToBase64(original).then(data => {
                const type = data.file.type;
                // Redimensiona a 1024 px de ancho, calidad 0.8
                downscaleImage(data.base64, 1024, type, 0.8).then(image => {
                urltoFile(image, data.file.name, data.file.type).then(file => {
                    formData.append('file_img', file); // IMPORTANTE: 'file_img' = name que espera Laravel
                    sendForm('/farmacias/subir-imagen', formData).then(resp => {
                    if (resp && resp.ok) {
                        // preview
                        if (preview) {
                        preview.src = resp.url;
                        preview.classList.remove('d-none');
                        }
                    } else {
                        alert((resp && resp.message) ? resp.message : 'Error al subir imagen.');
                    }
                    }).catch(() => {
                    alert('Error de red al subir imagen.');
                    });
                });
                });
            });
            });

            function sendForm(url, formData) {
            const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            return fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
                body: formData
            }).then(async (response) => {
                const contentType = response.headers.get('content-type') || '';
                const data = contentType.includes('application/json') ? await response.json() : {};
                if (!response.ok) {
                // Normaliza errores de validación de Laravel (422)
                let msg = data.message || 'Error de servidor.';
                if (data.errors) {
                    msg += '\n' + Object.values(data.errors).flat().join('\n');
                }
                return Promise.resolve({ ok: false, message: msg });
                }
                return data;
            });
            }
        </script>
    @endsection
@endsection

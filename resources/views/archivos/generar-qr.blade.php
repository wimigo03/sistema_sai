<!DOCTYPE html>
@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>GENERAR QR</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="form-group row font-roboto-12">
            <div class="col-md-12 pr-1 pl-1 text-center">
                {{ $qr }}
            </div>
        </div>
        {{--@include('archivos.partials.create-form')--}}
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });

            var cleave = new Cleave('#fecha', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true
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

        $("#procesar").click(function() {
            if (validar() == true) {
                $(".btn").hide();
                $(".spinner-btn").show();
                $("#form").submit();
            }
        });

        $("#atras").click(function() {
            window.location.href = "{{ route('archivos.index') }}";
        });

        $("#cancelar").click(function() {
            window.location.href = "{{ route('archivos.index') }}";
        });

        function validar() {
            if ($("#tipodocumento >option:selected").val() == "") {
                Modal('El <b>[Tipo de documento]</b> es un campo obligatorio');
                return false;
            }

            if ($("#fecha").val() == "") {
                Modal('La <b>[Fecha de recepcion o envio]</b> es un campo obligatorio');
                return false;
            }

            if ($("#nombredocumento").val() == "") {
                Modal('El <b>[Nro. de documento]</b> es un campo obligatorio');
                return false;
            }

            if ($("#referencia").val() == "") {
                Modal('La <b>[Referencia]</b> es un campo obligatorio');
                return false;
            }

            if ($("#file").val() == "") {
                Modal('El <b>[El archivo pdf]</b> es un campo obligatorio');
                return false;
            }

            return true;
        };

        document.getElementById('form').onsubmit = function(event) {
            event.preventDefault();
            uploadFile();
        };

        function uploadFile() {
            var formData = new FormData(document.getElementById('form'));
            var xhr = new XMLHttpRequest();

            xhr.upload.addEventListener('progress', function(e) {
                var percentComplete = e.loaded / e.total * 100;
                document.getElementById('progressBar').firstElementChild.style.width = percentComplete + '%';
                document.getElementById('progressBar').firstElementChild.innerHTML = Math.round(percentComplete) + '%';
            });

            xhr.open('POST', '{{ route('archivos.store') }}', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('input[name="_token"]').value);

            xhr.onload = function() {
                if (xhr.status == 200) {
                    window.location.href = '{{ route('archivos.index') }}';
                } else {
                    alert('Error uploading file');
                }
            };

            xhr.send(formData);
        }
    </script>
@endsection

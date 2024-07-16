@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>ACTUALIZAR CONTROL INTERNO</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('control-interno.partials.editar-form')
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            var cleave = new Cleave('#fecha', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha").datepicker({
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

        $('#tipo_id').change(function() {
            var id = $(this).val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            getCodigo(id,CSRF_TOKEN);
        });

        function getCodigo(tipo_id,CSRF_TOKEN){
            $.ajax({
                type: 'GET',
                url: '/control-interno/get_datos_tipo',
                data: {
                    _token: CSRF_TOKEN,
                    tipo_id: tipo_id
                },
                success: function(data){
                    if(data.tipo){
                        document.getElementById("codigo").value = data.tipo.codigo;
                        document.getElementById("numero").value = data.ultimo_nro;
                    }
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

        function valideNumberSinDecimal(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if ((code >= 48 && code <= 57) || code === 8) {
                return true;
            } else {
                return false;
            }
        }

        function cancelar(){
            window.location.href = "{{ route('control.interno.index') }}";
        }

        function anular(){
            var control_interno_id = $("#control_interno_id").val();
            var url = "{{ route('control.interno.anular', ':id') }}";
            url = url.replace(':id', control_interno_id);
            window.location.href = url;
        }

        function habilitar(){
            var control_interno_id = $("#control_interno_id").val();
            var url = "{{ route('control.interno.habilitar', ':id') }}";
            url = url.replace(':id', control_interno_id);
            window.location.href = url;
        }

        function procesar() {
            if(!validar()){
                return false;
            }
            var url = "{{ route('control.interno.update') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function validar() {
            if ($("#tipo_id >option:selected").val() == "") {
                Modal("<b>[ERROR. Campo obligatorio]</b> tipo de documentacion.");
                return false;
            }
            if ($("#codigo").val() == "") {
                Modal("<b>[ERROR. Campo obligatorio]</b> codigo.");
                return false;
            }
            if ($("#numero").val() == "") {
                Modal("<b>[ERROR. Campo obligatorio]</b> numero.");
                return false;
            }
            if ($("#destinatario_id >option:selected").val() == "") {
                Modal("<b>[ERROR. Campo obligatorio]</b> dirigido a.");
                return false;
            }
            if ($("#referencia").val() == "") {
                Modal("<b>[ERROR. Campo obligatorio]</b> referencia.");
                return false;
            }
            if ($("#fecha").val() == "") {
                Modal("<b>[ERROR. Campo obligatorio]</b> fecha.");
                return false;
            }
            return true;
        }
    </script>
@endsection

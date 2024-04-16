@extends('layouts.admin')
@section('content')
    <link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
    <div class="card card-custom">
        <div class="card-header font-verdana-bgt">
            <b>FORMULARIO REGISTRO</b>
        </div>
        <div class="card-body">
            @include('canasta_v2.beneficiario.partials.formCreate')
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
        });

        function message_alert(mensaje) {
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
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        }



        function validar_formulario() {
            if ($("#nombres").val() == "") {
                message_alert("El campo <b>[NOMBRES]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#ap").val() == "") {
                message_alert("El campo <b>[AP.Paterno]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#am").val() == "") {
                message_alert("El campo <b>[Ap.Materno]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#fnac").val() == "") {
                message_alert("El campo <b>[F.Nacimiento]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#estadoCivil>option:selected").val() == "") {
                message_alert("El campo <b>[Est.Civil]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#sexo>option:selected").val() == "") {
                message_alert("El campo <b>[Sexo]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#ci").val() == "") {
                message_alert("El campo <b>[C.I No]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#expedido").val() == "") {
                message_alert("El campo <b>[Expedido]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#firma").val() == "") {
                message_alert("El campo <b>[Firma]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#direccion").val() == "") {
                message_alert("El campo <b>[Direccion]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#estado>option:selected").val() == "") {
                message_alert("El campo <b>[Estado]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#barrio>option:selected").val() == "") {
                message_alert("El campo <b>[Barrio]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#ocupacion>option:selected").val() == "") {
                message_alert("El campo <b>[Ocupacion]</b> es un dato obligatorio...");
                return false;
            }

            if ($("#fregistro").val() == "") {
                message_alert("El campo <b>[F.Registro]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#observacion").val() == "") {
                message_alert("El campo <b>[Observacion]</b> es un dato obligatorio...");
                return false;
            }

            return true;
        }
    </script>
@endsection

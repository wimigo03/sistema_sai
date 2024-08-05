@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>ACTUALIZAR REGISTRO DE BENEFICIARIO DISC.</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('canasta_v2disc.beneficiario.partials.formUpdate')
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
            window.location.href = "{{ route('beneficiariosdisc.index') }}";
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

            if ($("#observacion").val() == "") {
                Modal("El campo <b>[Observacion]</b> es obligatorio.");
                return false;
            }

            return true;
        }
    </script>
@endsection

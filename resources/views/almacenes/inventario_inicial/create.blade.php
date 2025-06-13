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
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('inventario.inicial.index') }}"> Balances Iniciales</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Registrar</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fa-solid fa-file-lines fa-fw"></i>&nbsp;<b class="title-size">REGISTRAR BALANCE INICIAL</b>
            </div>
        </div>

        <div class="row abs-center">
            <div class="col-md-6">
                <div class="card-body">
                    @include('almacenes.inventario_inicial.partials.form')
                </div>
            </div>
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

                var cleave = new Cleave('#gestion', {
                    numeral: true,
                    numeralDecimalScale: 0,
                    numeralThousandsGroupStyle: 'none',
                    rawValueTrimPrefix: false,
                });
            });

            var input = document.getElementById('gestion');

            input.addEventListener('input', function() {
                if (input.value.length > 4) {
                    input.value = input.value.slice(0, 4);  // Limita a 4 caracteres
                }
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

            function validarGestion() {
                var valor = document.getElementById('gestion').value;

                // Verifica que el valor tenga exactamente 4 caracteres
                if (valor.length !== 4) {
                    Modal("Debe ingresar exactamente 4 dígitos.");
                    return false; // No permite continuar si no tiene 4 caracteres
                }

                // Verifica que el valor sea un número y que sea menor a 2027
                if (isNaN(valor) || parseInt(valor) >= 2027) {
                    Modal("El valor debe ser un número menor a 2027.");
                    return false; // No permite continuar si no es un número menor a 2027
                }

                // Si pasa ambas validaciones, se puede continuar
                return true;
            }

            async function procesar() {
                if(!validar()){
                    return false;
                }

                if(!validarGestion()){
                    return false;
                }

                $('#modal_confirmacion').modal({
                    keyboard: false
                })
            }

            function confirmar(){
                var url = "{{ route('inventario.inicial.store') }}";
                $("#form").attr('action', url);
                $(".btn").hide();
                $(".spinner-btn").show();
                $("#form").submit();
            }

            function cancelar(){
                var url = "{{ route('inventario.inicial.index') }}";
                window.location.href = url;
            }

            function validar(){
                if($("#almacen_id >option:selected").val() == ""){
                    Modal("Se debe seleccionar una <b>[SUCURSAL]</b> para continuar");
                    return false;
                }
                if ($("#gestion").val() == "") {
                    Modal("[El campo <b>[GESTION]</b> no puede estar vacio.]");
                    return false;
                }
                return true;
            }
        </script>
    @endsection
@endsection

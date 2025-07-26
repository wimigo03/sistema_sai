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
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('salida.sucursal.index') }}"> Salida de materiales</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Registrar</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fa-solid fa-file-lines fa-fw"></i>&nbsp;<b class="title-size">REGISTRAR SALIDA DE MATERIAL</b>
            </div>
        </div>

        <div class="card-body">
            @include('almacenes.salida_sucursal.partials.form')
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

                var cleave = new Cleave('#fecha_salida', {
                    date: true,
                    datePattern: ['d', 'm', 'Y'],
                    delimiter: '-'
                });

                $("#fecha_salida").datepicker({
                    inline: false,
                    language: "es",
                    dateFormat: "dd-mm-yyyy",
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

            function validarHeader(){
                if($("#almacen_id >option:selected").val() == ""){
                    Modal("Se debe seleccionar una <b>[SUCURSAL]</b> para continuar");
                    return false;
                }
                if($("#area_id >option:selected").val() == ""){
                    Modal("Se debe seleccionar al <b>[SOLICITANTE]</b> para continuar");
                    return false;
                }
                /*if($("#n_solicitud").val() == ""){
                    Modal("Se debe agregar un <b>[N° DE SOLICITUD]</b> para continuar.");
                    return false;
                }*/
                if($("#codigo").val() == ""){
                    Modal("Se debe agregar un <b>[N° DE SALIDA]</b> para continuar.");
                    return false;
                }
                if ($("#fecha_salida").val() == "") {
                    Modal("[El campo <b>[FECHA DE SALIDA]</b> no puede estar vacio.]");
                    return false;
                }

                var regex = /^(\d{2})-(\d{2})-(\d{4})$/;
                if (!regex.test($("#fecha_salida").val())) {
                    Modal("[El campo <b>[FECHA DE SALIDA]</b> debe tener el formato dd-mm-yyyy.]");
                    return false;
                }
                /*if($("#proveedor_id").val() == ""){
                    Modal("Se debe agregar un <b>[PROVEEDOR]</b> para continuar.");
                    return false;
                }*/
                if($("#glosa").val() == ""){
                    Modal("Se debe agregar una <b>[GLOSA]</b> para continuar.");
                    return false;
                }
                return true;
            }

            function getCodigo() {
                var codigo = $("#codigo").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: 'GET',
                        url: '/salida-sucursal/get_codigo',
                        data: {
                            _token: CSRF_TOKEN,
                            codigo: codigo
                        },
                        success: function(data) {
                            resolve(data.codigo);
                        },
                        error: function(xhr) {
                            reject(xhr.responseText);
                        }
                    });
                });
            }

            async function procesar() {
                if(!validarHeader()){
                    return false;
                }

                const codigoValido = await getCodigo();

                if (!codigoValido) {
                    Modal("[N° DE SALIDA DUPLICADO]");
                    return false;
                }

                $('#modal_confirmacion').modal({
                    keyboard: false
                })
            }

            function confirmar(){
                var submitButton = document.getElementById("confirmar");
                submitButton.disabled = true;
                submitButton.innerHTML = 'Procesando...'

                var url = "{{ route('salida.sucursal.store') }}";
                $("#form").attr('action', url);
                $("#form").submit();
            }

            function cancelar(){
                var url = "{{ route('salida.sucursal.index') }}";
                window.location.href = url;
            }
        </script>
    @endsection
@endsection

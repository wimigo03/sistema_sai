<!DOCTYPE html>
@extends('layouts.dashboard')
<style>
    .div_detalle, .div_cabecera {
        padding: 1px;
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
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('traspaso.sucursal.index') }}"> Traspaso de materiales</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Generar</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fa-solid fa-plus fa-fw"></i>&nbsp;<b class="font-verdana-16">REGISTRO TRASPASO DE MATERIAL</b>
        </div>

        <div class="card-body">
            @include('almacenes.traspaso_sucursal.partials.form')
        </div>
    </div>
    @section('scripts')
        <script type="text/javascript">
            $("#almacen_origen_id").val('').trigger('change');
            $("#almacen_destino_id").val('').trigger('change');

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

            $('#ingreso_almacen_id').on('select2:open', function(e) {
                if($("#almacen_origen_id >option:selected").val() == ""){
                    Modal("Para continuar se debe seleccionar una <br> <b>[SUCURSAL]</b>.");
                }
            });

            $('#almacen_origen_id').change(function() {
                var id = $(this).val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                getIngresosMaterialesPendientes(id,CSRF_TOKEN);
            });

            function getIngresosMaterialesPendientes(id,CSRF_TOKEN){
                $.ajax({
                    type: 'GET',
                    url: '/traspaso-sucursal/get_ingresos_materiales',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id
                    },
                    success: function(data) {
                        if (data.ingresos_materiales) {
                            var arr = Object.values($.parseJSON(data.ingresos_materiales));
                            var select = $("#ingreso_almacen_id");

                            select.empty();
                            select.append($("<option></option>").attr("value", '').text('--Seleccionar--'));

                            $.each(arr, function(index, json) {
                                var opcion = $("<option></option>")
                                    .attr("value", json.id)
                                    .text(json.data_completo);
                                select.append(opcion);
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }

            async function procesar() {
                if(!validar()){
                    return false;
                }

                $('#modal_confirmacion').modal({
                    keyboard: false
                })
            }

            function confirmar(){
                var submitButton = document.getElementById("confirmar");
                submitButton.disabled = true;
                submitButton.innerHTML = 'Procesando...';

                var url = "{{ route('traspaso.sucursal.store') }}";
                $("#form").attr('action', url);
                //$(".btn").hide();
                //$(".spinner-btn").show();
                $("#form").submit();
            }

            function cancelar(){
                var url = "{{ route('traspaso.sucursal.index') }}";
                window.location.href = url;
            }

            function validar(){
                if($("#almacen_origen_id >option:selected").val() == ""){
                    Modal("Se debe seleccionar una <b>[SUCURSAL DE ORIGEN]</b> para continuar");
                    return false;
                }
                if($("#almacen_destino_id >option:selected").val() == ""){
                    Modal("Se debe seleccionar una <b>[SUCURSAL DE DESTINO]</b> para continuar");
                    return false;
                }
                if($("#almacen_origen_id >option:selected").val() == $("#almacen_destino_id >option:selected").val()){
                    Modal("[NO ES PERMITIDO EL TRASPASO ENTRE LOS MISMOS ALMACENES]");
                    return false;
                }
                if($("#ingreso_almacen_id >option:selected").val() == ""){
                    Modal("Se debe seleccionar un <b>[INGRESO]</b> para continuar");
                    return false;
                }
                return true;
            }
        </script>
    @endsection
@endsection

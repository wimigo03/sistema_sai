@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="card card-custom">
    <div class="card-header font-verdana-bgt">
        <b>FORMULARIO DE ORDEN DE COMPRA - {{ $dea->descripcion }}</b>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <div class="col-md-12 font-verdana-bg">
                Los campos <i class="fa-solid fa-xs fa-asterisk"></i> son obligatorios
            </div>
        </div>
        <form action="#" method="post" id="form">
            @csrf
            @include('orden-compras.partials.form-create')
            <div class="row font-verdana-bg">
                <div class="col-md-12 font-verdana-bg text-center">
                    <br>
                    <span class="text-dark"><b>DETALLE DE LA COMPRA</b></span>
                </div>
            </div>
            {{--<div class="card card-body bg-light">
                @include('compras.pedidoparcial.partials.form-create-detalle')
                <div class="form-group row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-outline-primary font-verdana" id="btn-registro" type="button" onclick="procesar();">
                            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>&nbsp;Registrar
                        </button>
                        <button class="btn btn-outline-danger font-verdana" type="button" onclick="cancelar();">
                            &nbsp;<i class="fa-solid fa-xmark"></i>&nbsp;Cancelar
                        </button>
                        <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                    </div>
                </div>
            </div>--}}
        </form>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#btn-registro").hide();
            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
            $("#fecha_preventivo").datepicker({
                inline: false, 
                dateFormat: "dd/mm/yyyy",
                autoClose: true
            });
        });

        function alerta(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        function procesar() {
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function confirmar(){
            if(!validarHeader()){
                return false;
            }
            var url = "{{ route('compras.pedidoparcial.store') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('compras.pedidoparcial.index') }}";
        }

        function validarHeader(){
            if($("#controlinterno").val() == ""){
                alerta("El campo <b>[Control Interno]</b> es un dato obligatorio...");
                return false;
            }
            if($("#controlinterno").val() <= 1){
                alerta("El campo <b>[Control Interno]</b> debe ser mayor que 0...");
                return false;
            }
            if($("#idprograma >option:selected").val() == ""){
                alerta("El campo de seleccion <b>[Programa]</b> es un dato obligatorio...");
                return false;
            }
            if($("#idcatprogramatica >option:selected").val() == ""){
                alerta("El campo de seleccion <b>[Cat. Programatica]</b> es un dato obligatorio...");
                return false;
            }
            if($("#preventivo").val() != ""){
                if($("#fecha_preventivo").val() == ""){
                    alerta("El campo <b>[Fecha Preventivo]</b> se encuentra vacio...");
                    return false;      
                }
                if(!validarFormatoFecha($("#fecha_preventivo").val())){
                    alerta("La <b>[Fecha Preventivo]</b> no tiene formato correcto...");
                    return false;
                }
            }
            if($("#fecha_preventivo").val() != ""){
                if($("#preventivo").val() == ""){
                    alerta("El campo <b>[Preventivo]</b> se encuentra vacio...");
                    return false;
                }
                if(!validarFormatoFecha($("#fecha_preventivo").val())){
                    alerta("La <b>[Fecha Preventivo]</b> no tiene formato correcto...");
                    return false;
                }
            }
            if($("#objeto").val() == ""){
                alerta("El campo <b>[Objeto]</b> es un dato obligatorio...");
                return false;
            }
            if($("#justificacion").val() == ""){
                alerta("El campo <b>[Justificacion]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        }

        function validarFormatoFecha(fecha) {
            var RegExPattern = /^\d{2}\/\d{2}\/\d{4}$/;
            if ((fecha.match(RegExPattern)) && (fecha!='')) {
                    return true;
            } else {
                    return false;
            }
        }

        function valideNumber(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if ((code >= 48 && code <= 57) || code === 46 || code === 8) {
                if (code === 46 && evt.target.value.indexOf('.') !== -1) {
                    return false;
                }
                return true;
            } else {
                return false;
            }
        }
    </script>
@endsection

@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>MODIFICAR ORDEN DE COMPRA</b>
            </div>
        </div>
    </div>
    @include('compras.orden_compra.partials.form-editar')
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

        function validar(){
            if($("#area_solicitante").val() == ""){
                Modal("<center>[ERROR AL VALIDAR EL AREA SOLICITANTE]</center>");
                return false;
            }
            if($("#user").val() == ""){
                Modal("<center>[ERROR AL VALIDAR EL SOLICITANTE]</center>");
                return false;
            }
            if($("#fecha_registro").val() == ""){
                Modal("<center>[ERROR AL VALIDAR LA FECHA DE REGISTRO]</center>");
                return false;
            }
            if($("#nro_oc").val() == ""){
                Modal("<center>[ERROR AL VALIDAR EL NUMERO DE LA ORDEN DE COMPRA]</center>");
                return false;
            }
            if($("#nro_solicitud").val() == ""){
                Modal("<center>[ERROR AL VALIDAR EL NUMERO DE LA SOLICITUD DE COMPRA]</center>");
                return false;
            }
            if($("#almacen").val() == ""){
                Modal("<center>[ERROR AL VALIDAR EL ALMACEN]</center>");
                return false;
            }
            if($("#tipo").val() == ""){
                Modal("<center>[ERROR AL VALIDAR EL TIPO DE ORDEN DE COMPRA]</center>");
                return false;
            }
            if($("#c_interno").val() == ""){
                Modal("<center>[ERROR AL VALIDAR EL NUMERO DE CONTROL INTERNO]</center>");
                return false;
            }
            if($("#nro_preventivo").val() == ""){
                Modal("<center>[ERROR AL VALIDAR EL NUMERO DE PREVENTIVO]</center>");
                return false;
            }
            if($("#categoria_programatica_id").val() == ""){
                Modal("<center>[ERROR AL VALIDAR LA CATEGORIA PROGRAMATICA]</center>");
                return false;
            }
            if($("#programa_id").val() == ""){
                Modal("<center>[ERROR AL VALIDAR EL PROGRAMA]</center>");
                return false;
            }
            if($("#proveedor_id").val() == ""){
                Modal("<center>[ERROR AL VALIDAR EL PROVEEDOR]</center>");
                return false;
            }
            if($("#objeto").val() == ""){
                Modal("<center>[ERROR AL VALIDAR EL OBJETO DE LA ORDEN DE COMPRA]</center>");
                return false;
            }
            if($("#justificacion").val() == ""){
                Modal("<center>[ERROR AL VALIDAR LA JUSTIFICACION DE LA ORDEN DE COMPRA]</center>");
                return false;
            }
            return true;
        }

        function procesar() {
            /*if(!validar()){
                return false;
            }*/
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function confirmar(){
            var url = "{{ route('orden.compra.update') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var url = "{{ route('orden.compra.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection

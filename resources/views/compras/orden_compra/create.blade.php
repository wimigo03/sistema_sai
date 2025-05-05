@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>FORMULARIO ORDEN DE COMPRA</b>
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

            $('.input-precio').each(function() {
                new Cleave(this, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand',
                    numeralDecimalScale: 2,
                });
            });
        });

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        function Calcular(id) {
            var cantidad = $('.detalle-'+id+' .input-cantidad').val();
            /* cantidad = cantidad.replace(/,/g, ''); */
            cantidad = (isNaN(parseFloat(cantidad)))? 0 : parseFloat(cantidad);
            var precio_actual = $('.detalle-'+id+' .input-precio').val();
            precio_actual = (isNaN(parseFloat(precio_actual)))? 0 : parseFloat(precio_actual);
            try{
                var total_precio = cantidad * precio_actual;
                $('.detalle-'+id+' .input-total').each(function() {
                    new Cleave(this, {
                        numeral: true,
                        numeralThousandsGroupStyle: 'thousand'
                    }).setRawValue(total_precio);
                });
                totalSuma();
            }catch(e){
                console.log('ERROR')
            }
        }

        function totalSuma() {
            var total = 0;

            $("#detalle_tabla tbody tr").each(function() {
                var input_total = $(this).find(".input-total").val();
                input_total = isNaN(parseFloat(input_total)) ? 0 : parseFloat(input_total);
                total += input_total;
            });

            $('.input-total-final').each(function() {
                var cleaveInstance = new Cleave(this, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand'
                });
                cleaveInstance.setRawValue(total);
            });
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

        function validarTabla(){
            var productos = $("#detalle_tabla tbody tr");
            if(productos.length>0){
                for(var i=0;i<productos.length;i++){
                    var tr = productos[i];
                    var producto_id = $(tr).find(".input-precio").val();
                    if(producto_id === '' || producto_id === '0'){
                        Modal("<b>[ERROR. ]</b> EXISTE UN PRECION VACIO U IGUAL A 0");
                        return false;
                    }
                }
            }
            return true;
        }

        function procesar() {
            if(!validar()){
                return false;
            }
            if(!validarTabla()){
                return false;
            }
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

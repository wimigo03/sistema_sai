@extends('layouts.dashboard')
@section('content')
<div class="card card-custom">
    <div class="card-header font-verdana-13 bg-secondary text-white">
        <b>FORMULARIO DE SOLICITUD DE COMPRA - {{ $dea->descripcion }}</b>
    </div>
    <div class="card-body">
        <form action="#" method="post" id="form">
            @csrf
            @include('compras.pedidoparcial.partials.form-create')
            @include('compras.pedidoparcial.partials.form-create-detalle')
        </form>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#total_detalle_compra").hide();
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

        function agregarMaterial(){
            if(!validarHeader()){
                return false;
            }
            if(!validarProductos()){
                return false;
            }
            if(!validarRepetidos()){
                return false;
            }
            cargarProductos();
        }

        function cargarProductos(){
            var producto_id = $("#producto >option:selected").val();
            var producto_texto = $("#producto option:selected").text();
            var quitar = /[()]/g;
            var string_texto = producto_texto.replace(quitar, '');
            string_texto = string_texto.split('_');
            var producto = string_texto[1];
            var medida = string_texto[2];
            var precio_bs = string_texto[3];
            var precio = precio_bs.split('.')
            var cantidad = $("#cantidad").val();
            cantidad = parseFloat(cantidad).toFixed(2);
            precio = parseFloat(precio[1]).toFixed(2);
            var subtotal = cantidad * precio;
            subtotal = subtotal.toFixed(2)
            var fila = "<tr class='font-verdana-sm'>"+ 
                            "<td class='text-justify p-1'>"+
                                "<input type='hidden' class='producto_id' name='producto_id[]' value='" + producto_id + "'>" + producto_id +
                            "</td>"+
                            "<td class='text-justify p-1'>"+
                                producto +
                            "</td>"+
                            "<td class='text-center p-1'>"+
                                medida +
                            "</td>"+
                            "<td class='text-right p-1'>"+
                                "<input type='hidden' name='precio[]' value='" + precio + "'>" + precio +
                            "</td>"+
                            "<td class='text-right p-1'>"+
                                "<input type='hidden' name='cantidad[]' value='" + cantidad + "'>" + cantidad +
                            "</td>"+
                            "<td class='text-right p-1'>"+
                                "<input type='hidden' name='subtotal[]' value='" + subtotal + "'>" + subtotal +
                            "</td>"+
                            "<td class='text-center p-1'>"+
                                "<button type='button' class='btn btn-xs btn-danger' onclick='eliminarItem(this);'>" + 
                                      "<i class='fa-solid fa-trash'></i>" +  
                                 "</button>" +
                            "</td>"
                        "</tr>";

            $("#detalle_tabla").append(fila); 
            $('#producto').val('').trigger('change');
            document.getElementById('cantidad').value = '';
            $("#btn-registro").show();
            sumaTotal();
        }

        function eliminarItem(thiss){                  
            var tr = $(thiss).parents("tr:eq(0)");
            tr.remove();
            sumaTotal();
        }

        function sumaTotal(){
            var filas = document.querySelectorAll("#detalle_tabla tbody tr");
            var parcial = 0;
            filas.forEach(function(e) {
                var columnas = e.querySelectorAll("td");
                var subtotal = parseFloat(columnas[5].textContent);
                parcial += subtotal;
            });
            var total = document.getElementById("span_total_con_solicitud");
            total.textContent = parcial.toFixed(2);
            $("#total_detalle_compra").show();
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
            if(!validarRepetidos()){
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

        function validarProductos(){
            if($("#producto >option:selected").val() == ""){
                alerta("El campo de seleccion <b>[Producto]</b> no esta seleccionado...");
                return false;
            }
            if($("#cantidad").val() == ""){
                alerta("El campo <b>[Cantidad]</b> esta vacio...");
                return false;
            }
            if($("#cantidad").val() <= 0){
                alerta("El campo <b>[Cantidad]</b> debe ser mayor a 0...");
                return false;
            }
            return true;
        }

        function validarRepetidos(){
            var productos = $("#detalle_tabla tbody tr");
            if(productos.length>0){
                var producto = $("#producto >option:selected").val(); 
                for(var i=0;i<productos.length;i++){
                    var tr = productos[i];
                    var producto_id = $(tr).find(".producto_id").val();
                    if(producto == producto_id){
                        alerta("El registro ya se encuentra en la tabla actual...");
                        return false;
                    }
                }
            }
            return true;
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

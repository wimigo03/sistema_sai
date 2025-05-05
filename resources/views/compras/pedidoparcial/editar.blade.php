@extends('layouts.dashboard')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="card card-custom">
    <div class="card-header font-verdana-15">
        <b>MODIFICAR FORMULARIO DE SOLICITUD DE COMPRA - {{ $dea->descripcion }}</b>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <div class="col-md-12 font-verdana-12">
                Los campos <i class="fa-solid fa-xs fa-asterisk"></i> son obligatorios
            </div>
        </div>
        <form action="#" method="post" id="form">
            @csrf
            @include('compras.pedidoparcial.partials.form-editar')
            <div class="row font-verdana-12">
                <div class="col-md-12 font-verdana-12 text-center">
                    <br>
                    <span class="text-dark"><b>DETALLE DE LA COMPRA</b></span>
                </div>
            </div>
            <div class="card card-body bg-light">
                @include('compras.pedidoparcial.partials.form-create-detalle')
                <div class="form-group row" id="seccion-especifica">
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
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
    @if(session('scroll_to'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var element = document.getElementById('{{ session('scroll_to') }}');
                if (element) {
                    element.scrollIntoView({ behavior: 'smooth' });
                }
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
            $("#fecha_preventivo").datepicker({
                inline: false, 
                dateFormat: "dd/mm/yyyy",
                autoClose: true
            });
        });

        function confirmarEliminacion(idDetalleCompra) {
            if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
                window.location.href = '{{ url('compras/pedidoparcial/eliminar/', ['id' => '']) }}/' + idDetalleCompra;
            }
        }

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
            var fila = "<tr class='font-verdana'>"+ 
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
                                "<span class='tts:left tts-slideIn tts-custom' aria-label='Eliminar' style='cursor: pointer;'>" +
                                    "<button type='button' class='btn btn-xs btn-danger' onclick='eliminarItem(this);'>" + 
                                        "<i class='fa-solid fa-trash'></i>" +  
                                    "</button>" +
                                "</span>" +
                            "</td>"
                        "</tr>";

            $("#detalle_tabla").append(fila); 
            $('#producto').val('').trigger('change');
            document.getElementById('cantidad').value = '';
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
            $("#total_sin_solicitud").show();
        }

        function procesar(){
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
            var url = "{{ route('compras.pedidoparcial.update') }}";
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

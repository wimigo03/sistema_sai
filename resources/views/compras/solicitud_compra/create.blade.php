@extends('layouts.admin')
@section('content')
    <div class="card-body">
        <div class="row abs-center">
            <div class="col-md-10">
                <div class="form-group row font-roboto-20">
                    <div class="col-md-12 text-center linea-completa">
                        <strong>REGISTRAR SOLICITUD DE COMPRA DE MATERIAL</strong>
                    </div>
                </div>
                @include('compras.solicitud_compra.partials.form-create')
            </div>
        </div>
    </div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#btn-registro").hide();
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            $('#item_id').on('select2:open', function(e) {
                if($("#partida_presupuestaria_id >option:selected").val() == ""){
                    Modal("Para continuar se debe seleccionar una <b>[PARTIDA PRESUPUESTARIA]</b>.");
                }
            });

            if($("#partida_presupuestaria_id >option:selected").val() != ''){
                var id = $("#partida_presupuestaria_id >option:selected").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                getItems(id,CSRF_TOKEN);
            }

            var cleave = new Cleave('#cantidad', {
                numeral: true,
                numeralDecimalScale: 2,
                numeralThousandsGroupStyle: 'thousand'
            });
        });

        $('#partida_presupuestaria_id').change(function() {
            var id = $(this).val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            getItems(id,CSRF_TOKEN);
        });

        function getItems(id,CSRF_TOKEN){
            $.ajax({
                type: 'GET',
                url: '/solicitud-compra/get_items',
                data: {
                    _token: CSRF_TOKEN,
                    id: id
                },
                success: function(data){
                    if(data.items){
                        var arr = Object.values($.parseJSON(data.items));
                        $("#item_id").empty();
                        var select = $("#item_id");
                        select.append($("<option></option>").attr("value", '').text('--Item--'));
                        $.each(arr, function(index, json) {
                            var opcion = $("<option></option>").attr("value", json.item_id).text(json.producto);
                            select.append(opcion);
                        });
                    }
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
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

        function validarHeader(){
            if($("#c_interno").val() == ""){
                Modal("Se debe agregar un numero de <b>[CONTROL INTERNO]</b> para continuar.");
                return false;
            }
            if($("#detalle").val() == ""){
                Modal("Se debe agregar un <b>[DETALLE]</b> para continuar.");
                return false;
            }
            return true;
        }

        function validarProductos(){
            if($("#item_id >option:selected").val() == ""){
                Modal("Se debe seleccionar un <b>[MATERIAL]</b> para continuar.");
                return false;
            }
            if($("#cantidad").val() == ""){
                Modal("Se debe agregar una <b>[CANTIDAD]</b> para continuar.");
                return false;
            }
            if($("#cantidad").val() === '0'){
                Modal("La <b>[CANTIDAD]</b> debe ser mayor a 0.");
                return false;
            }
            return true;
        }

        function validarRepetidos(){
            var productos = $("#detalle_tabla tbody tr");
            if(productos.length>0){
                var producto = $("#item_id >option:selected").val();
                for(var i=0;i<productos.length;i++){
                    var tr = productos[i];
                    var producto_id = $(tr).find(".item_id").val();
                    if(producto == producto_id){
                        Modal("<b>[ERROR. ]</b> El Item seleccionado ya se encuentra en la tabla actual.");
                        return false;
                    }
                }
            }
            return true;
        }

        function cargarProductos(){
            var partida_presupuestaria_id = $("#partida_presupuestaria_id >option:selected").val();
            var partida_presupuestaria_texto = $("#partida_presupuestaria_id option:selected").text();
            var texto_partida_presupuestaria = partida_presupuestaria_texto.replace(/[()]/g, '');
            texto_partida_presupuestaria = texto_partida_presupuestaria.split(' ');
            var partida_presupuestaria = texto_partida_presupuestaria[0];
            var _partida_presupuestaria = texto_partida_presupuestaria[2];

            var producto_id = $("#item_id >option:selected").val();
            var producto_texto = $("#item_id option:selected").text();
            var quitar = /[()]/g;
            var string_texto = producto_texto.replace(quitar, '');
            string_texto = string_texto.split('_');
            var producto = string_texto[0];
            var medida = string_texto[1];
            var cantidad = $("#cantidad").val();
            var fila = "<tr class='font-roboto-11'>"+
                            "<td class='text-justify p-1' style='vertical-align: middle;'>"+
                                "<span class='tts:right tts-slideIn tts-custom' aria-label='" + _partida_presupuestaria + "' style='cursor: pointer;'>" +
                                    "<input type='hidden' name='partida_presupuestaria_id[]' value='" + partida_presupuestaria_id + "'>" + partida_presupuestaria +
                                "</span>" +
                            "</td>" +
                            "<td class='text-justify p-1' style='vertical-align: middle;'>"+
                                "<input type='hidden' class='item_id' name='item_id[]' value='" + producto_id + "'>" + producto +
                            "</td>" +
                            "<td class='text-justify p-1' style='vertical-align: middle;'>"+
                                medida +
                            "</td>" +
                            "<td class='text-right p-1' width='80px'>"+
                                "<input type='text' name='cantidad[]' value='" + cantidad + "' class='form-control form-control-sm font-roboto-12 text-right input-cantidad' disabled>" +
                            "</td>" +
                            "<td class='text-center p-1' style='vertical-align: middle;'>"+
                                "<span class='badge-with-padding badge badge-danger' onclick='eliminarItem(this);'>" +
                                      "<i class='fa-solid fa-trash fa-fw'></i>" +
                                 "</span>" +
                            "</td>"
                        "</tr>";

            $("#detalle_tabla").append(fila);
            $('#item_id').val('').trigger('change');
            document.getElementById('cantidad').value = '';
            contar_registros();
        }

        function eliminarItem(thiss){
            var tr = $(thiss).parents("tr:eq(0)");
            tr.remove();
            contar_registros();
        }

        function contar_registros(){
            var table = document.getElementById("detalle_tabla");
            var registros = table.rows.length - 1;
            if(registros === 0){
                $("#btn-registro").hide();
            }else{
                $("#btn-registro").show();
            }
        }

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        function procesar() {
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function confirmar(){
            $('.input-cantidad').removeAttr('disabled');
            var url = "{{ route('solicitud.compra.store') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('solicitud.compra.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection

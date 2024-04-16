@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1">
                <b>REGISTRAR SOLICITUD DE COMPRA</b>
            </div>
        </div>
    </div>
    @include('compras.solicitud_compra.partials.form-create')
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            localStorage.clear();
            $("#btn-registro").hide();
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            if($("#tipo >option:selected").val() != ''){
                var id = $("#tipo >option:selected").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                getItems(id,CSRF_TOKEN);
            }

            var cleave = new Cleave('#cantidad', {
                numeral: true,
                numeralDecimalScale: 2,
                numeralThousandsGroupStyle: 'thousand'
            });
        });

        $('#tipo').change(function() {
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
                        var itemIdSeleccionado = localStorage.getItem('itemIdSeleccionado');
                        $.each(arr, function(index, json) {
                            var opcion = $("<option></option>").attr("value", json.item_id).text(json.producto);
                            if (json.item_id == itemIdSeleccionado) {
                                opcion.attr('selected', 'selected');
                            }
                            select.append(opcion);
                        });
                        select.on('change', function() {
                            localStorage.setItem('itemIdSeleccionado', $(this).val());
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
            if($("#tipo >option:selected").val() == ""){
                Modal("Se debe seleccionar el [TIPO] de producto para continuar");
                return false;
            }
            if($("#c_interno").val() == ""){
                Modal("Se debe agregar un numero de [CONTRO INTERNO] para continuar.");
                return false;
            }
            if($("#detalle").val() == ""){
                Modal("Se debe agregar un [DETALLE] para continuar.");
                return false;
            }
            return true;
        }

        function validarProductos(){
            if($("#item_id >option:selected").val() == ""){
                Modal("Se debe seleccionar un [ITEM PRODUCTO / SERVICIO] para continuar.");
                return false;
            }
            if($("#cantidad").val() == ""){
                Modal("Se debe agregar una [CANTIDAD] para continuar.");
                return false;
            }
            if($("#cantidad").val() === '0'){
                Modal("La [CANTIDAD] debe ser mayor a 0.");
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
                        Modal("El registro ya se encuentra en la tabla actual.");
                        return false;
                    }
                }
            }
            return true;
        }

        function cargarProductos(){
            var producto_id = $("#item_id >option:selected").val();
            var producto_texto = $("#item_id option:selected").text();
            var quitar = /[()]/g;
            var string_texto = producto_texto.replace(quitar, '');
            string_texto = string_texto.split('_');
            var producto = string_texto[0];
            var medida = string_texto[1];
            var cantidad = $("#cantidad").val();
            var fila = "<tr class='font-roboto-11'>"+
                            "<td class='text-justify p-1'>"+
                                "<input type='hidden' class='item_id' name='item_id[]' value='" + producto_id + "'>" + producto +
                            "</td>"+
                            "<td class='text-justify p-1'>"+
                                medida +
                            "</td>"+
                            "<td class='text-right p-1'>"+
                                "<input type='hidden' name='cantidad[]' value='" + cantidad + "'>" + cantidad +
                            "</td>"+
                            "<td class='text-center p-1'>"+
                                "<button type='button' class='btn btn-xs btn-danger' onclick='eliminarItem(this);'>" +
                                      "<i class='fa-solid fa-trash'></i>" +
                                 "</button>" +
                            "</td>"
                        "</tr>";

            $("#detalle_tabla").append(fila);
            $('#item_id').val('').trigger('change');
            document.getElementById('cantidad').value = '';
            $("#btn-registro").show();
            document.getElementById("tipo").disabled = true;
        }

        function eliminarItem(thiss){
            var tr = $(thiss).parents("tr:eq(0)");
            tr.remove();
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
            document.getElementById("tipo").disabled = false;
            var url = "{{ route('solicitud.compra.store') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('solicitud.compra.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection

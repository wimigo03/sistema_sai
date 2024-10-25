@extends('layouts.admin')
@section('content')
    <div class="card-body">
        <div class="row abs-center">
            <div class="col-md-10">
                <div class="form-group row font-roboto-20">
                    <div class="col-md-12 text-center linea-completa">
                        <strong>FORMULARIO - SOLICITUD DE MATERIALES</strong>
                    </div>
                </div>
                @include('almacenes.solicitud_material.partials.form-create')
            </div>
        </div>
    </div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            @if (!isset($old_cont))
                $("#btn-registro").hide();
            @endif
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            var cleave = new Cleave('#cantidad', {
                numeral: true,
                numeralDecimalScale: 2,
                numeralThousandsGroupStyle: 'thousand'
            });
        });

        function agregarMaterial(){
            if(!validarProductos()){
                return false;
            }
            if(!validarRepetidos()){
                return false;
            }
            cargarProductos();
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

        var cont = {{ isset($old_cont) ? $old_cont : $cont }};

        function cargarProductos(){
            var producto_id = $("#item_id >option:selected").val();
            var producto_texto = $("#item_id option:selected").text();
            var quitar = /[()]/g;
            var string_texto = producto_texto.replace(quitar, '');
            string_texto = string_texto.split('_');
            var producto = string_texto[0];
            var medida = string_texto[1];
            var cantidad = $("#cantidad").val();
            cont++;
            var fila = "<tr class='font-roboto-11'>"+
                            "<td class='text-justify p-1' style='vertical-align: middle;'>"+
                                cont +
                            "</td>" +
                            "<td class='text-justify p-1' style='vertical-align: middle;'>"+
                                "<input type='hidden' class='item_id' name='item_id[]' value='" + producto_id + "'>" + producto +
                            "</td>" +
                            "<td class='text-center p-1' style='vertical-align: middle;'>"+
                                medida +
                            "</td>" +
                            "<td class='text-right p-1' width='80px'>"+
                                "<input type='text' name='cantidad[]' value='" + cantidad + "' class='form-control form-control-sm font-roboto-12 text-right input-cantidad' disabled>" +
                            "</td>" +
                            "<td class='text-center p-1' style='vertical-align: middle;'>"+
                                "<span class='badge-with-padding badge badge-danger tts:left tts-slideIn tts-custom'" +
                                    " style='cursor: pointer;'" +
                                    " aria-label='Eliminar'" +
                                    " onclick=\"if(confirm('¿Estás seguro de que quieres eliminar este ítem?')) { eliminarItem(this); }\">" +
                                    "<i class='fas fa-trash fa-fw'></i>" +
                                "</span>" +
                            "</td>"
                        "</tr>";

            $("#detalle_tabla").append(fila);
            $('#item_id').val('').trigger('change');
            document.getElementById('cantidad').value = '';
            contar_registros();
        }

        function eliminarItem(thiss,id){
            var tr = $(thiss).parents("tr:eq(0)");
            tr.remove();
            if (typeof id !== "undefined") {
                eliminar_registro(id);
            }
            contar_registros();
        }

        function eliminar_registro(id){
            $.ajax({
                type: 'GET',
                url: '/solicitud-material/eliminar_registro/'+id,
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(json){
                    console.log('Eliminado');
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
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
            $('#cod_solicitud').removeAttr('disabled');
            @if(isset($detalles))
                var url = "{{ route('solicitud.material.update') }}";
            @else
                var url = "{{ route('solicitud.material.store') }}";
            @endif
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('solicitud.material.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection

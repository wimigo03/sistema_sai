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
    <li class="breadcrumb-item font-roboto-14 active">Modificar</li>
@endsection
@section('content')
    <div id="loadingOverlay" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; display: flex; justify-content: center; align-items: center;">
        <div style="background-color: white; padding: 20px; border-radius: 8px; text-align: center;">
            <p>Por favor, espere mientras se cargan los datos...</p>
            <div class="spinner"></div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-dark">
            <i class="fa-solid fa-edit fa-fw"></i>&nbsp;<b class="font-verdana-16">REGISTRO SALIDA DE MATERIAL</b>
        </div>

        <div class="card-body">
            @include('almacenes.salida_sucursal.partials.form')
        </div>

        <!-- Modal -->
        <form action="#" method="post" id="form-cargar-datos">
        @csrf
            <div class="modal fade" id="modalCargarMaterialesCustom" tabindex="-1" aria-labelledby="modalCargarMaterialesCustomLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCargarMaterialesCustomLabel">Seleccionar Ingreso de Almacén</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 col-md-6 col-lg-12 mb-2">
                                <label for="ingreso_almacen_id" class="form-label d-inline font-roboto-14">Ingresos</label>
                                <input type="hidden" name="salida_almacen_id" id="salida_almacen_id" value="{{ $salida_almacen->id }}">
                                <select id="ingreso_almacen_id" name="ingreso_almacen_id" class="form-control select2">
                                    <option value="">--Seleccionar--</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary font-verdana-12 text-white" type="button" data-dismiss="modal">
                                <i class="fa-solid fa-xmark"></i>&nbsp;Cancelar
                            </button>
                            <button type="button" class="btn btn-primary" onclick="procesar_cargar_datos();">Cargar datos</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @section('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                if(contarRegistrosInsertados() == 0){
                    document.getElementById('btnCargarMateriales').disabled = false;
                }else{
                    document.getElementById('btnCargarMateriales').disabled = true;
                }

                $('#miFormulario').find('input, select, textarea, button').prop('disabled', true);

                $("#categoria_programatica_id").val('').trigger('change');
                $("#stock_actual").val('');
                $("#stock_reserva").val('');
                $("#inventario_almacen_id").val('');

                var table = $('#detalle_tabla').DataTable({
                    "responsive": true,
                    //"stateSave": true,
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "_MENU_",
                        "sZeroRecords": "",
                        "sEmptyTable": "",
                        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sSearch": "",
                        "sSearchPlaceholder": "Buscar",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sPrevious": "Anterior",
                            "sNext": "Siguiente",
                            "sLast": "Último"
                        }
                    },
                    "paging": false,
                    "dom": '<"top">rt<"bottom"p><"clear">',
                    "pageLength": 10000,
                    "lengthChange": false,
                    "initComplete": function() {
                        $(".dataTables_info").addClass("font-roboto-13");
                        $(".dataTables_length").find("label").addClass("font-roboto-13");
                        $(".dataTables_filter").find("label").addClass("font-roboto-13");
                        $(".dataTables_paginate").find("a").addClass("font-roboto-13");

                        $('#loadingOverlay').hide();
                        $('#miFormulario').find('input, select, textarea, button').prop('disabled', false);
                    }
                });

                $('#custom-search input').on('keydown', function(e) {
                    if (e.key === 'Enter') {
                        table.search(this.value).draw();
                    }
                });

                $('#custom-search input').on('keydown', function(e) {
                    if (e.key === 'Enter') {
                        actualizarTotal();
                        contarRegistrosInsertados();
                    }
                });

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

                $(".input-cantidad").each(function() {
                    new Cleave(this, {
                        numeral: true,
                        numeralDecimalMark: '.',
                        delimiter: ',',
                        numeralDecimalScale: 4,
                        numeralThousandsGroupStyle: 'thousand',
                    });
                });

                $(".input-precio-unitario").each(function() {
                    new Cleave(this, {
                        numeral: true,
                        numeralDecimalMark: '.',
                        delimiter: ',',
                        numeralDecimalScale: 4,
                        numeralThousandsGroupStyle: 'thousand',
                    });
                });
            });

            var Modal = function(mensaje){
                $("#modal-alert .modal-body").html(mensaje);
                $('#modal-alert').modal({keyboard: false});
            }

            $('#partida_presupuestaria_id').on('select2:open', function(e) {
                if($("#categoria_programatica_id >option:selected").val() == ""){
                    Modal("Para continuar se debe seleccionar una <br> <b>[CATEGORIA PROGRAMATICA]</b>.");
                }
            });

            $('#producto_id').on('select2:open', function(e) {
                if($("#partida_presupuestaria_id >option:selected").val() == ""){
                    Modal("Para continuar se debe seleccionar una <br> <b>[PARTIDA PRESUPUESTARIA]</b>.");
                }
            });

            $('#categoria_programatica_id').change(function() {
                //$('#producto_id').val('').trigger('change');
                var id = $(this).val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                getPartidasPresupuestarias(id,CSRF_TOKEN);
            });

            function getPartidasPresupuestarias(id,CSRF_TOKEN){
                $.ajax({
                    type: 'GET',
                    url: '/salida-sucursal/get_partidas_presupuestarias',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id
                    },
                    success: function(data) {
                        if (data.partidas_presupuestarias) {
                            var arr = Object.values($.parseJSON(data.partidas_presupuestarias));
                            var select = $("#partida_presupuestaria_id");

                            select.empty();
                            select.append($("<option></option>").attr("value", '').text('--Seleccionar--'));
                            //select.append($("<option></option>").attr("value", '_lonely_').text('--Partida Presupuestaria--'));

                            $.each(arr, function(index, json) {
                                var opcion = $("<option></option>")
                                    .attr("value", json.partida_presupuestaria_id)
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

            $('#partida_presupuestaria_id').change(function() {
                var id = $(this).val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                getProductos(id,CSRF_TOKEN);
            });

            function getProductos(id,CSRF_TOKEN){
                $.ajax({
                    type: 'GET',
                    url: '/salida-sucursal/get_productos',
                    data: {
                        _token: CSRF_TOKEN,
                        id: id
                    },
                    success: function(data){
                        if (data.productos) {
                            var arr = Object.values($.parseJSON(data.productos));
                            var select = $("#producto_id");

                            select.empty();
                            select.append($("<option></option>").attr("value", '').text('--Seleccionar--'));
                            //select.append($("<option></option>").attr("value", '_lonely_').text('--Material--'));

                            $.each(arr, function(index, json) {
                                var opcion = $("<option></option>")
                                    .attr("value", json.producto_id)
                                    .text(json.data_completo);
                                select.append(opcion);
                            });
                        }
                    },
                    error: function(xhr){
                        console.log(xhr.responseText);
                    }
                });
            }

            $('#producto_id').change(function() {
                var almacen_id = $("#almacen_id >option:selected").val();
                var categoria_programatica_id = $("#categoria_programatica_id >option:selected").val();
                var partida_presupuestaria_id = $("#partida_presupuestaria_id >option:selected").val();
                var producto_id = $(this).val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                getStockDisponible(almacen_id,categoria_programatica_id,partida_presupuestaria_id,producto_id,CSRF_TOKEN);
            });

            function getStockDisponible(almacen_id,categoria_programatica_id,partida_presupuestaria_id,producto_id,CSRF_TOKEN){
                $.ajax({
                    type: 'GET',
                    url: '/salida-sucursal/get_stock_disponible',
                    data: {
                        _token: CSRF_TOKEN,
                        almacen_id: almacen_id,
                        categoria_programatica_id: categoria_programatica_id,
                        partida_presupuestaria_id: partida_presupuestaria_id,
                        producto_id: producto_id
                    },
                    success: function(data){
                        if(data){
                            $('#inventario_almacen_id').val(data.inventario_almacen_id);
                            $('#stock_actual').val(data.stock_actual);
                            $('#stock_reserva').val(data.stock_reserva);
                        }
                    },
                    error: function(xhr){
                        console.log(xhr.responseText);
                    }
                });
            }

            function validarProductos(){
                if($("#categoria_programatica_id >option:selected").val() == ""){
                    Modal("Se debe seleccionar un <b>[CATEGORIA PROGRAMATICA]</b> para continuar.");
                    return false;
                }
                if($("#partida_presupuestaria_id >option:selected").val() == ""){
                    Modal("Se debe seleccionar un <b>[PARTIDA PRESUPUESTARIA]</b> para continuar.");
                    return false;
                }
                if($("#producto_id >option:selected").val() == ""){
                    Modal("Se debe seleccionar un <b>[MATERIAL]</b> para continuar.");
                    return false;
                }
                if($("#stock_actual").val() === '0'){
                    Modal("<b>[0]</b> El material seleccionado no tiene existencia disponible.");
                    return false;
                }
                if($("#inventario_almacen_id").val() === '0' || $("#inventario_almacen_id").val() === ''){
                    Modal("<b>[ERROR] - INVENTARIO</b>");
                    return false;
                }
                return true;
            }

            function validarRepetidos(){
                var productos = $("#detalle_tabla tbody tr");
                if(productos.length > 0){
                    var categoria_programatica_id = $("#categoria_programatica_id > option:selected").val();
                    var partida_presupuestaria_id = $("#partida_presupuestaria_id > option:selected").val();
                    var producto_id = $("#producto_id > option:selected").val();

                    for(var i = 0; i < productos.length; i++){
                        var tr = productos[i];
                        var categoria_programatica = $(tr).find(".categoria_programatica_id").val();
                        var partida_presupuestaria = $(tr).find(".partida_presupuestaria_id").val();
                        var producto = $(tr).find(".producto_id").val();

                        if(categoria_programatica == categoria_programatica_id &&
                        partida_presupuestaria == partida_presupuestaria_id &&
                        producto == producto_id){
                            Modal("[REGISTRO DUPLICADO]");
                            return false;
                        }
                    }
                }
                return true;
            }

            function agregarMaterial(){
                if(!validarProductos()){
                    return false;
                }

                if(!validarRepetidos()){
                    return false;
                }

                cargarProductos();
            }

            function insertarProductos() {
                var categoria_programatica_id = $("#categoria_programatica_id >option:selected").val();
                var partida_presupuestaria_id = $("#partida_presupuestaria_id >option:selected").val();
                var producto_id = $("#producto_id >option:selected").val();
                var salida_almacen_id = $("#salida_almacen_id").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('salida.sucursal.insertar.producto') }}",
                        data: {
                            _token: CSRF_TOKEN,
                            categoria_programatica_id: categoria_programatica_id,
                            partida_presupuestaria_id: partida_presupuestaria_id,
                            producto_id: producto_id,
                            salida_almacen_id: salida_almacen_id,
                        },
                        success: function(data) {
                            resolve(data.salida_almacen_detalle_id);
                        },
                        error: function(xhr) {
                            reject(xhr.responseText);
                        }
                    });
                });
            }

            function cargarMateriales(){
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var almacen_id = $("#almacen_id >option:selected").val();

                $.ajax({
                    type: 'GET',
                    url: '/salida-sucursal/get_cargar_materiales',
                    data: {
                        _token: CSRF_TOKEN,
                        almacen_id: almacen_id
                    },
                    success: function(data) {
                        if (data.ingresos_almacen) {
                            var arr = Object.values($.parseJSON(data.ingresos_almacen));
                            var select = $("#ingreso_almacen_id");

                            select.empty();
                            select.append($("<option></option>").attr("value", '').text('--Seleccionar--'));

                            $.each(arr, function(index, json) {
                                var opcion = $("<option></option>")
                                    .attr("value", json.ingreso_almacen_id)
                                    .text(json.data_completo);
                                select.append(opcion);
                            });
                        }

                        $('#modalCargarMaterialesCustom').modal('show');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }

            function getProductoData(id) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: 'GET',
                        url: '/salida-sucursal/get_producto_data',
                        data: {
                            _token: CSRF_TOKEN,
                            id: id
                        },
                        success: function(data) {
                            resolve(data.producto);
                        },
                        error: function(xhr) {
                            reject(xhr.responseText);
                        }
                    });
                });
            }

            function actualizarTotal() {
                var total = 0;

                $(".input-subtotal").each(function() {
                    var subtotal = parseFloat($(this).val().replace(/,/g, '')) || 0;
                    total += subtotal;
                });

                var totalRedondeado = Math.round(total * 100) / 100;

                var totalFormateado = totalRedondeado.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                var totalFila = $("#total_fila");
                if (totalFila.length > 0) {
                    totalFila.find("input").val('Bs. ' + totalFormateado);
                }
            }

            function parseInputValue(selector) {
                return parseFloat(selector.replace(/,/g, '')) || 0;
            }

            function cantidadPrecio(element) {
                var tr = $(element).closest('tr');

                var cantidad = parseInputValue(tr.find('.input-cantidad').val());
                var precioUnitario = parseInputValue(tr.find('.input-precio-unitario').val());
                var stock_actual = parseInputValue(tr.find('.input-stock-actual').val());
                var stock_reserva = parseInputValue(tr.find('.input-stock-reserva').val());
                var cantidad_anterior = parseInputValue(tr.find('.input-cantidad-anterior').val());
                var input_subtotal_anterior = parseInputValue(tr.find('.input-subtotal-anterior').val());

                var stock_total = stock_actual + stock_reserva;

                if (cantidad > stock_total) {
                    Modal("[La cantidad solicitada supera el stock disponible]");
                    tr.find('.input-cantidad').val(cantidad_anterior);
                    tr.find('.input-subtotal').val(input_subtotal_anterior.toFixed(2));
                } else {
                    if (cantidad !== cantidad_anterior) {
                        let diferencia = Math.abs(cantidad - cantidad_anterior);

                        if (cantidad > cantidad_anterior) {
                            if (stock_actual >= diferencia) {
                                stock_actual -= diferencia;
                                stock_reserva += diferencia;
                            } else {
                                stock_reserva += stock_actual;
                                stock_actual = 0;
                            }
                        } else {
                            if (stock_reserva >= diferencia) {
                                stock_reserva -= diferencia;
                                stock_actual += diferencia;
                            } else {
                                stock_actual += stock_reserva;
                                stock_reserva = 0;
                            }
                        }
                    }

                    var subtotal = (cantidad * precioUnitario).toFixed(2);
                    tr.find('.input-stock-actual').val(stock_actual);
                    tr.find('.input-stock-reserva').val(stock_reserva);
                    tr.find('.input-cantidad-anterior').val(cantidad);
                    tr.find('.input-subtotal').val(subtotal);
                }

                actualizarTotal();
            }

            function contarRegistrosInsertados() {
                var cantidadRegistros = $("#detalle_tabla tr:not(.ignore-row)").length;
                $("#cantidad-registros b").text(cantidadRegistros);
                return cantidadRegistros;
            }


            function eliminar_registro(id,inventario_almacen_id,cantidad){
                $.ajax({
                    type: 'GET',
                    url: '/salida-sucursal/eliminar_registro/' + id + '/' + inventario_almacen_id + '/' + cantidad,
                    dataType: 'json',
                    data: {
                        id: id,
                        inventario_almacen_id: inventario_almacen_id,
                        cantidad: cantidad
                    },
                    success: function(json){
                        console.log(json);
                    },
                    error: function(xhr){
                        console.log(xhr.responseText);
                    }
                });
            }

            function eliminarItem(thiss,id,inventario_almacen_id,cantidad){
                if(cantidad === 0){
                    var fila = thiss.closest('tr');
                    var cantidad = parseFloat(fila.querySelector('.input-cantidad').value.replace(",", "")) || 0;
                }
                console.log(id);
                var tr = $(thiss).parents("tr:eq(0)");
                tr.remove();

                if (typeof id !== "undefined") {
                    eliminar_registro(id, inventario_almacen_id, cantidad);
                }

                /*$('#detalle_tabla').DataTable().row(tr).remove().draw();*/

                actualizarTotal();

                if(contarRegistrosValidos()){
                    document.getElementById('btnCargarMateriales').disabled = false;
                }else{
                    document.getElementById('btnCargarMateriales').disabled = true;
                }

                contarRegistrosInsertados();
            }

            function updateRegistroCantidad(idRegistro, idInventarioAlmacen, valorCantidad, valorCantidadAnterior) {

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('salida.sucursal.update.registro.cantidad') }}",
                        data: {
                            _token: CSRF_TOKEN,
                            id: idRegistro,
                            inventario_almacen_id: idInventarioAlmacen,
                            cantidad: valorCantidad,
                            cantidad_anterior: valorCantidadAnterior,
                        },
                        success: function(data) {
                            //resolve(data.ingreso_almacen_detalle_id);
                        },
                        error: function(xhr) {
                            reject(xhr.responseText);
                        }
                    });
                });
            }

            function updateRegistroPrecioUnitario(idRegistro, valorPrecioUnitario) {

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('salida.sucursal.update.registro.precio.unitario') }}",
                        data: {
                            _token: CSRF_TOKEN,
                            id: idRegistro,
                            precio_unitario: valorPrecioUnitario,
                        },
                        success: function(data) {
                            //resolve(data.ingreso_almacen_detalle_id);
                        },
                        error: function(xhr) {
                            reject(xhr.responseText);
                        }
                    });
                });
            }

            document.getElementById('detalle_tabla').addEventListener('blur', function(event) {
                if (event.target && event.target.classList.contains('input-cantidad')) {
                    const idRegistro = event.target.getAttribute('data-id');
                    const inputInventarioAlmacen = event.target.closest('tr').querySelector('.input-inventario-almacen-id');
                    const idInventarioAlmacen = inputInventarioAlmacen ? inputInventarioAlmacen.value : null;
                    const inputCantidadAnterior = event.target.closest('tr').querySelector('.input-cantidad-anterior');
                    const valorCantidadAnterior = inputCantidadAnterior ? inputCantidadAnterior.value : null;
                    const valorCantidad = event.target.value;

                    updateRegistroCantidad(idRegistro, idInventarioAlmacen, valorCantidad, valorCantidadAnterior);
                }
            }, true);

            document.getElementById('detalle_tabla').addEventListener('blur', function(event) {
                if (event.target && event.target.classList.contains('input-precio-unitario')) {
                    const idRegistro = event.target.getAttribute('data-id');
                    const inputInventarioAlmacen = event.target.closest('tr').querySelector('.input-inventario-almacen-id');
                    const idInventarioAlmacen = inputInventarioAlmacen ? inputInventarioAlmacen.value : null;
                    const valorPrecioUnitario = event.target.value;

                    updateRegistroPrecioUnitario(idRegistro, valorPrecioUnitario);
                }
            }, true);

            document.getElementById('detalle_tabla').addEventListener('blur', function(event) {
                if (event.target && (event.target.classList.contains('input-precio-unitario') || event.target.classList.contains('input-cantidad'))) {

                    const valor = event.target.value;

                    if (valor === '0' || valor === 0 || valor === '') {
                        event.target.classList.add('is-invalid');
                    } else {
                        event.target.classList.remove('is-invalid');
                    }

                    if (event.target.classList.contains('input-precio-unitario')) {
                        const fila = event.target.closest('tr');
                        const inputCantidad = fila.querySelector('.input-cantidad');
                        const valorCantidad = inputCantidad ? inputCantidad.value : '';

                        if (valorCantidad === '0' || valorCantidad === 0 || valorCantidad === '') {
                            inputCantidad.classList.add('is-invalid');
                        } else {
                            inputCantidad.classList.remove('is-invalid');
                        }
                    }

                    if (event.target.classList.contains('input-cantidad')) {
                        const fila = event.target.closest('tr');
                        const inputPrecioUnitario = fila.querySelector('.input-precio-unitario');
                        const valorPrecioUnitario = inputPrecioUnitario ? inputPrecioUnitario.value : '';

                        if (valorPrecioUnitario === '0' || valorPrecioUnitario === 0 || valorPrecioUnitario === '') {
                            inputPrecioUnitario.classList.add('is-invalid');
                        } else {
                            inputPrecioUnitario.classList.remove('is-invalid');
                        }
                    }
                }
            }, true);

            async function cargarProductos(){
                var salida_almacen_detalle_id = await insertarProductos();
                var categoria_programatica_id = $("#categoria_programatica_id >option:selected").val();
                var categoria_programatica_codigo = $("#categoria_programatica_id option:selected").text().split(' - ')[0];
                var categoria_programatica_nombre = $("#categoria_programatica_id option:selected").text().split(' - ')[1];
                var partida_presupuestaria_id = $("#partida_presupuestaria_id >option:selected").val();
                var partida_presupuestaria_codigo = $("#partida_presupuestaria_id option:selected").text().split(' - ')[0];
                var partida_presupuestaria_nombre = $("#partida_presupuestaria_id option:selected").text().split(' - ')[1];
                var producto_id = $("#producto_id >option:selected").val();
                var producto = await getProductoData(producto_id);
                var stock_actual = $("#stock_actual").val();
                var stock_reserva = $("#stock_reserva").val();
                var inventario_almacen_id = $("#inventario_almacen_id").val();
                var cantidad = 0;
                var fila = "<tr class='font-roboto-13'>"+
                                "<td class='text-center p-2 text-nowrap' style='vertical-align: middle;'>" +
                                    "<span class='tts:right tts-slideIn tts-custom' aria-label='" + categoria_programatica_nombre + "' style='cursor: pointer;'>" +
                                        "<input type='hidden' class='input-inventario-almacen-id' name='inventario_almacen_id[]' value='" + inventario_almacen_id + "'>" +
                                        "<input type='hidden' class='categoria_programatica_id' name='categoria_programatica_id[]' value='" + categoria_programatica_id + "'>" + categoria_programatica_codigo +
                                        "<input type='hidden' class='partida_presupuestaria_id' name='partida_presupuestaria_id[]' value='" + partida_presupuestaria_id + "'>" +
                                    "</span>" +
                                "</td>" +
                                "<td class='text-center p-2 text-nowrap' style='vertical-align: middle;'>" +
                                    "<input type='hidden' class='producto_id' name='producto_id[]' value='" + producto_id + "'>" + producto.codigo +
                                "</td>" +
                                "<td class='text-justify p-2 text-nowrap' style='vertical-align: middle;'>" +
                                    producto.nombre +
                                "</td>" +
                                "<td class='text-center p-2 text-nowrap' style='vertical-align: middle;'>" +
                                    producto.alias +
                                "</td>" +
                                "<td class='text-right p-2 text-nowrap' width='100px'>"+
                                    "<input type='hidden' placeholder='0' value='" + stock_actual + "' data-id='" + salida_almacen_detalle_id + "' class='form-control font-roboto-14 text-right input-stock-actual-anterior' disabled>" +
                                    "<input type='text' placeholder='0' value='" + stock_actual + "' data-id='" + salida_almacen_detalle_id + "' class='form-control font-roboto-14 text-right input-stock-actual' disabled>" +
                                "</td>" +
                                "<td class='text-right p-2 text-nowrap' width='100px'>"+
                                    "<input type='hidden' placeholder='0' value='" + stock_reserva + "' data-id='" + salida_almacen_detalle_id + "' class='form-control font-roboto-14 text-right input-stock-reserva-anterior' disabled>" +
                                    "<input type='text' placeholder='0' value='" + stock_reserva + "' data-id='" + salida_almacen_detalle_id + "' class='form-control font-roboto-14 text-right input-stock-reserva' disabled>" +
                                "</td>" +
                                "<td class='text-right p-2 text-nowrap' width='100px'>"+
                                    "<input type='hidden' placeholder='0' data-id='" + salida_almacen_detalle_id + "' class='form-control font-roboto-14 text-right input-cantidad-anterior'>" +
                                    "<input type='text' placeholder='0' data-id='" + salida_almacen_detalle_id + "' class='form-control font-roboto-14 text-right input-cantidad is-invalid' onblur='cantidadPrecio(this);'>" +
                                "</td>" +
                                "<td class='text-right p-2 text-nowrap' width='100px'>"+
                                    "<input type='text' placeholder='0' data-id='" + salida_almacen_detalle_id + "' class='form-control font-roboto-14 text-right input-precio-unitario is-invalid' onblur='cantidadPrecio(this);'>" +
                                "</td>" +
                                "<td class='text-right p-2 text-nowrap' width='100px'>"+
                                    "<input type='hidden' placeholder='0' class='form-control font-roboto-14 text-right input-subtotal-anterior'>" +
                                    "<input type='text' placeholder='0' class='form-control font-roboto-14 text-right input-subtotal' disabled>" +
                                "</td>" +
                                "<td class='text-center p-2 text-nowrap' style='vertical-align: middle;'>" +
                                    "<span class='btn btn-sm btn-danger tts:left tts-slideIn tts-custom' style='cursor: pointer;' aria-label='Eliminar' onclick='if(confirm(\"¿Estás seguro de que quieres eliminar el registro?\")) { eliminarItem(this, " + salida_almacen_detalle_id + ", " + inventario_almacen_id + ", " + cantidad + "); }'>" +
                                        "<i class='fa-solid fa-trash fa-fw'></i>" +
                                    "</span>" +
                                "</td>"
                            "</tr>";

                //$("#detalle_tabla").append(fila);
                $("#detalle_tabla tbody").prepend(fila);

                $(".input-cantidad").each(function() {
                    new Cleave(this, {
                        numeral: true,
                        numeralDecimalMark: '.',
                        delimiter: ',',
                        numeralDecimalScale: 4,
                        numeralThousandsGroupStyle: 'thousand',
                    });
                });

                $(".input-precio-unitario").each(function() {
                    new Cleave(this, {
                        numeral: true,
                        numeralDecimalMark: '.',
                        delimiter: ',',
                        numeralDecimalScale: 4,
                        numeralThousandsGroupStyle: 'thousand',
                    });
                });

                $("#detalle_tabla td:nth-child(4)").css({
                    "max-width": "250px",
                    "overflow": "hidden",
                    "text-overflow": "ellipsis"
                });

                //$('#categoria_programatica_id').val('').trigger('change');
                //$('#partida_presupuestaria_id').val('').trigger('change');
                //$('#producto_id').val('').trigger('change');

                if(contarRegistrosInsertados() == 0){
                    document.getElementById('btnCargarMateriales').disabled = false;
                }else{
                    document.getElementById('btnCargarMateriales').disabled = true;
                }

                contarRegistrosValidos();
            }

            async function procesar() {
                if(!validarHeader()){
                    return false;
                }

                if(!contarRegistros()){
                    return false;
                }

                if(!validarInputCantidadPrecio()){
                    return false;
                }

                const codigoValido = await getCodigo();

                if (!codigoValido) {
                    Modal("[N° DE SALIDA DUPLICADO]");
                    return false;
                }

                const data_editar = await getStockDisponibleValidoEditar();
                var stockDisponibleValidoEditar = data_editar.stock_disponible_valido;

                if (!stockDisponibleValidoEditar) {
                    Modal("[La cantidad solicitante de un producto no es suficiente.<br>Por favor consulte el stock disponible]");
                    return false;
                }

                confirmar();

                /*$('#modal_confirmacion').modal({
                    keyboard: false
                });*/
            }

            function getStockDisponibleValidoEditar() {
                var inventario_almacen_ids = [];
                var cantidads = [];

                $("#detalle_tabla .input-inventario-almacen-id").each(function() {
                    var inventario_almacen_id = $(this).val();
                    if (inventario_almacen_id) {
                        inventario_almacen_ids.push(inventario_almacen_id);
                    }
                });

                $("#detalle_tabla .input-cantidad").each(function() {
                    var cantidad = $(this).val();
                    if (cantidad) {
                        cantidads.push(cantidad);
                    }
                });

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: 'GET',
                        url: '/salida-sucursal/get_stock_disponible_valido',
                        data: {
                            _token: CSRF_TOKEN,
                            inventario_almacen_ids: inventario_almacen_ids,
                            cantidads: cantidads
                        },
                        success: function(data) {
                            resolve(data);
                        },
                        error: function(xhr) {
                            reject(xhr.responseText);
                        }
                    });
                });
            }

            function getCodigo() {
                var codigo = $("#codigo").val();
                var salida_almacen_id = $("#salida_almacen_id").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: 'GET',
                        url: '/salida-sucursal/get_codigo_editar',
                        data: {
                            _token: CSRF_TOKEN,
                            codigo: codigo,
                            salida_almacen_id: salida_almacen_id
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

            function validarInputCantidadPrecio() {
                var esValido = true;

                $("#detalle_tabla tr:not(.ignore-row)").each(function() {
                    var cantidad = $(this).find('.input-cantidad').val();
                    var precioUnitario = $(this).find('.input-precio-unitario').val();

                    cantidad = parseFloat(cantidad.replace(/,/g, '').trim()) || 0;
                    precioUnitario = parseFloat(precioUnitario.replace(/,/g, '').trim()) || 0;

                    if (isNaN(cantidad) || cantidad <= 0 || isNaN(precioUnitario) || precioUnitario <= 0) {
                        esValido = false;
                        $(this).find('.input-cantidad, .input-precio-unitario').addClass('is-invalid');
                        Modal("Unos de los campos de <br><b>[EGRESO O PRECIO UNITARIO]</b> <br>no son validos");
                    } else {
                        $(this).find('.input-cantidad, .input-precio-unitario').removeClass('is-invalid');
                    }
                });

                return esValido;
            }

            function contarRegistros(){
                var esValido = true;
                var table = document.querySelectorAll("#detalle_tabla tr:not(.ignore-row)");
                var registros = table.length;

                if(registros === 0){
                    var esValido = false;
                    Modal("[SE DEBE TENER AL MENOS UN REGISTRO PARA CONTINUAR]");
                }

                return esValido;
            }

            function contarRegistrosValidos(){
                var esValido = true;
                var table = document.querySelectorAll("#detalle_tabla tr:not(.ignore-row)");
                var registros = table.length;

                if(registros === 0){
                    $("#total_fila").hide();
                }else{
                    $("#total_fila").show();
                }

                return esValido;
            }

            function procesar_cargar_datos(){
                var url = "{{ route('salida.sucursal.cargar.datos') }}";
                $("#form-cargar-datos").attr('action', url);
                $(".btn").hide();
                $(".spinner-btn").show();
                $("#form-cargar-datos").submit();
            }

            function confirmar(){
                var url = "{{ route('salida.sucursal.update') }}";
                $("#form").attr('action', url);
                $(".btn").hide();
                $(".spinner-btn").show();
                $("#form").submit();
            }

            function cancelar(){
                var url = "{{ route('salida.sucursal.index') }}";
                window.location.href = url;
            }

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
        </script>
    @endsection
@endsection

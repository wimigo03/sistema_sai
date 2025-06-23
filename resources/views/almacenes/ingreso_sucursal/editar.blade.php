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

    .table-responsive {
        max-height: 600px;
        overflow-y: auto;
        overflow-x: auto;
    }
</style>
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('ingreso.sucursal.index') }}"> Ingresos de materiales</a></li>
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
            <i class="fa-solid fa-edit fa-fw"></i>&nbsp;<b class="font-verdana-16">REGISTRO INGRESO DE MATERIAL</b>
        </div>

        <div class="card-body">
            @include('almacenes.ingreso_sucursal.partials.form')
        </div>
    </div>
    @section('scripts')
        <script type="text/javascript">
            $(document).ready(function() {

                //$('#loadingOverlay').show();
                $('#miFormulario').find('input, select, textarea, button').prop('disabled', true);

                $("#categoria_programatica_id").val('').trigger('change');

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
                    }
                });

                //$('#custom-search input').on('input', function() {
                    //table.search(this.value).draw();
                    /*var searchTerm = this.value;
                    if (searchTerm.length > 0) {
                        bloquearCampos();
                    } else {
                        desbloquearCampos();
                    }*/
                //});

                /*$('#_detalle_tabla_filter').on('input', function() {
                    actualizarTotal();
                });*/

                $('.select2').select2({
                    theme: "bootstrap4",
                    placeholder: "--Seleccionar--",
                    width: '100%'
                });

                var cleave = new Cleave('#fecha_ingreso', {
                    date: true,
                    datePattern: ['d', 'm', 'Y'],
                    delimiter: '-'
                });

                $("#fecha_ingreso").datepicker({
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

            function updateRegistroCantidad(idRegistro, valorCantidad) {

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('ingreso.sucursal.update.registro.cantidad') }}",
                        data: {
                            _token: CSRF_TOKEN,
                            id: idRegistro,
                            cantidad: valorCantidad,
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
                        url: "{{ route('ingreso.sucursal.update.registro.precio.unitario') }}",
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
                    const valorCantidad = event.target.value;
                    //const fila = event.target.closest('tr');
                    //const inputPrecioUnitario = fila.querySelector('.input-precio-unitario');
                    //const valorPrecioUnitario = inputPrecioUnitario ? inputPrecioUnitario.value : '';

                    updateRegistroCantidad(idRegistro, valorCantidad);
                }
            }, true);

            document.getElementById('detalle_tabla').addEventListener('blur', function(event) {
                if (event.target && event.target.classList.contains('input-precio-unitario')) {
                    const idRegistro = event.target.getAttribute('data-id');
                    const valorPrecioUnitario = event.target.value;
                    //const fila = event.target.closest('tr');
                    //const inputCantidad = fila.querySelector('.input-cantidad');
                    //const valorCantidad = inputCantidad ? inputCantidad.value : '';

                    updateRegistroPrecioUnitario(idRegistro, valorPrecioUnitario);
                }
            }, true);

            document.getElementById('detalle_tabla').addEventListener('blur', function(event) {
                // Verificamos que el evento proviene de un input con las clases 'input-precio-unitario' o 'input-cantidad'
                if (event.target && (event.target.classList.contains('input-precio-unitario') || event.target.classList.contains('input-cantidad'))) {

                    // Obtener el valor del input que disparó el evento
                    const valor = event.target.value;

                    // Verificar si el valor es igual a 0 o si el campo está vacío y agregar o quitar la clase 'is-invalid'
                    if (valor === '0' || valor === 0 || valor === '') {
                        event.target.classList.add('is-invalid');  // Agregar la clase 'is-invalid' al input
                    } else {
                        event.target.classList.remove('is-invalid');  // Quitar la clase 'is-invalid' del input
                    }

                    // Si el input es 'input-precio-unitario', verificamos también el 'input-cantidad'
                    if (event.target.classList.contains('input-precio-unitario')) {
                        // Obtener la fila (tr) que contiene los inputs
                        const fila = event.target.closest('tr');
                        const inputCantidad = fila.querySelector('.input-cantidad');
                        const valorCantidad = inputCantidad ? inputCantidad.value : '';

                        // Verificar el valor del 'input-cantidad' y agregar o quitar la clase 'is-invalid' según corresponda
                        if (valorCantidad === '0' || valorCantidad === 0 || valorCantidad === '') {
                            inputCantidad.classList.add('is-invalid');
                        } else {
                            inputCantidad.classList.remove('is-invalid');
                        }
                    }
                }
            }, true);

            function bloquearCampos() {
                $('#detalle_tabla input[name="cantidad[]"]').prop('disabled', true).css('background-color', '#ccc');
                $('#detalle_tabla input[name="precio_unitario[]"]').prop('disabled', true).css('background-color', '#ccc');
            }

            function desbloquearCampos() {
                $('#detalle_tabla input[name="cantidad[]"]').prop('disabled', false).css('background-color', '');
                $('#detalle_tabla input[name="precio_unitario[]"]').prop('disabled', false).css('background-color', '');
            }

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
                $('#producto_id').val('').trigger('change');
                var id = $(this).val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                getPartidasPresupuestarias(id,CSRF_TOKEN);
            });

            function getPartidasPresupuestarias(id,CSRF_TOKEN){
                $.ajax({
                    type: 'GET',
                    url: '/ingreso-sucursal/get_partidas_presupuestarias',
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
                    url: '/ingreso-sucursal/get_productos',
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

            function getProductoData(id) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: 'GET',
                        url: '/ingreso-sucursal/get_producto_data',
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

            function insertarProductos() {
                var categoria_programatica_id = $("#categoria_programatica_id >option:selected").val();
                var partida_presupuestaria_id = $("#partida_presupuestaria_id >option:selected").val();
                var producto_id = $("#producto_id >option:selected").val();
                var ingreso_almacen_id = $("#ingreso_almacen_id").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('ingreso.sucursal.insertar.producto') }}",
                        data: {
                            _token: CSRF_TOKEN,
                            categoria_programatica_id: categoria_programatica_id,
                            partida_presupuestaria_id: partida_presupuestaria_id,
                            producto_id: producto_id,
                            ingreso_almacen_id: ingreso_almacen_id,
                        },
                        success: function(data) {
                            resolve(data.ingreso_almacen_detalle_id);
                        },
                        error: function(xhr) {
                            reject(xhr.responseText);
                        }
                    });
                });
            }

            async function cargarProductos(){
                var ingreso_almacen_detalle_id = await insertarProductos();
                var categoria_programatica_id = $("#categoria_programatica_id >option:selected").val();
                var categoria_programatica_codigo = $("#categoria_programatica_id option:selected").text().split(' - ')[0];
                var categoria_programatica_nombre = $("#categoria_programatica_id option:selected").text().split(' - ')[1];
                var partida_presupuestaria_id = $("#partida_presupuestaria_id >option:selected").val();
                var partida_presupuestaria_codigo = $("#partida_presupuestaria_id option:selected").text().split(' - ')[0];
                var partida_presupuestaria_nombre = $("#partida_presupuestaria_id option:selected").text().split(' - ')[1];
                var producto_id = $("#producto_id >option:selected").val();
                var producto = await getProductoData(producto_id);
                var fila = "<tr class='font-roboto-13'>"+
                                "<td class='text-center p-2 text-nowrap' style='vertical-align: middle;'>" +
                                    "<span class='tts:right tts-slideIn tts-custom' aria-label='" + categoria_programatica_nombre + "' style='cursor: pointer;'>" +
                                        //"<input type='hidden' name='ingreso_almacen_detalle_id[]' value='" + ingreso_almacen_detalle_id + "'>" +
                                        "<input type='hidden' class='categoria_programatica_id' name='categoria_programatica_id[]' value='" + categoria_programatica_id + "'>" + categoria_programatica_codigo +
                                        "<input type='hidden' class='partida_presupuestaria_id' name='partida_presupuestaria_id[]' value='" + partida_presupuestaria_id + "'>" + partida_presupuestaria_codigo +
                                    "</span>" +
                                "</td>" +
                                //"<td class='text-center p-2 text-nowrap' style='vertical-align: middle;'>" +
                                //    "<span class='tts:right tts-slideIn tts-custom' aria-label='" + partida_presupuestaria_nombre + "' style='cursor: pointer;'>" +
                                //        "<input type='hidden' class='partida_presupuestaria_id' name='partida_presupuestaria_id[]' value='" + partida_presupuestaria_id + "'>" + partida_presupuestaria_codigo +
                                //    "</span>" +
                                //"</td>" +
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
                                    //"<input type='text' placeholder='0' name='cantidad[]' data-id='" + ingreso_almacen_detalle_id + "' class='form-control font-roboto-14 text-right input-cantidad' oninput='cantidadPrecio(this);'>" +
                                    "<input type='text' placeholder='0' data-id='" + ingreso_almacen_detalle_id + "' class='form-control font-roboto-14 text-right input-cantidad is-invalid' oninput='cantidadPrecio(this);'>" +
                                "</td>" +
                                "<td class='text-right p-2 text-nowrap' width='100px'>"+
                                    //"<input type='text' placeholder='0' name='precio_unitario[]' data-id='" + ingreso_almacen_detalle_id + "' class='form-control font-roboto-14 text-right input-precio-unitario' oninput='cantidadPrecio(this);'>" +
                                    "<input type='text' placeholder='0' data-id='" + ingreso_almacen_detalle_id + "' class='form-control font-roboto-14 text-right input-precio-unitario is-invalid' oninput='cantidadPrecio(this);'>" +
                                "</td>" +
                                "<td class='text-right p-2 text-nowrap' width='100px'>"+
                                    "<input type='text' placeholder='0' class='form-control font-roboto-14 text-right input-subtotal' disabled>" +
                                "</td>" +
                                "<td class='text-center p-2 text-nowrap' style='vertical-align: middle;'>"+
                                    "<span class='btn btn-sm btn-danger' onclick='eliminarItem(this," + ingreso_almacen_detalle_id + ");'>" +
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

                contarRegistrosInsertados();

                contarRegistrosValidos();
            }

            function cantidadPrecio(element) {
                var tr = $(element).closest('tr');
                var cantidad = parseFloat(tr.find('.input-cantidad').val().replace(/,/g, '')) || 0;
                var precioUnitario = parseFloat(tr.find('.input-precio-unitario').val().replace(/,/g, '')) || 0;
                var subtotal = cantidad * precioUnitario;

                tr.find('.input-subtotal').val(subtotal.toFixed(2));
                actualizarTotal();
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

            function eliminarItem(thiss,id){
                var tr = $(thiss).parents("tr:eq(0)");
                tr.remove();

                if (typeof id !== "undefined") {
                    eliminar_registro(id);
                }

                $('#detalle_tabla').DataTable().row(tr).remove().draw();

                actualizarTotal();
                contarRegistrosValidos();
                contarRegistrosInsertados();
            }

            function eliminar_registro(id){
                $.ajax({
                    type: 'GET',
                    url: '/ingreso-sucursal/eliminar_registro/'+id,
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    /*success: function(json){
                        console.log('Eliminado');
                    },*/
                    error: function(xhr){
                        console.log(xhr.responseText);
                    }
                });
            }

            async function procesar() {
                if(!validarHeader()){
                    return false;
                }

                if(!contarRegistros()){
                    return false;
                }

                /*DESACTIVANDO LA OPCION DE REVISION DE 0 Y NULOS POR EDICION.*/
                /*if(!validarInputCantidadPrecio()){
                    return false;
                }*/

                const nroPreventivoValido = await getNroPreventivo();

                if (!nroPreventivoValido) {
                    Modal("[N° DE PREVENTIVO DUPLICADO]");
                    return false;
                }

                if($("#n_orden_compra").val() != ''){
                    const nroOrdenCompraValido = await getNroOrdenCompra();

                    if (!nroOrdenCompraValido) {
                        Modal("[N° DE ORDEN DE COMPRA DUPLICADO]");
                        return false;
                    }
                }

                const codigoValido = await getCodigo();

                if (!codigoValido) {
                    Modal("[N° DE INGRESO DUPLICADO]");
                    return false;
                }

                confirmar();

                /*$('#modal_confirmacion').modal({
                    keyboard: false
                });*/
            }

            function getNroPreventivo() {
                var nro_preventivo = $("#n_preventivo").val();
                var ingreso_almacen_id = $("#ingreso_almacen_id").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: 'GET',
                        url: '/ingreso-sucursal/get_nro_preventivo_editar',
                        data: {
                            _token: CSRF_TOKEN,
                            nro_preventivo: nro_preventivo,
                            ingreso_almacen_id: ingreso_almacen_id
                        },
                        success: function(data) {
                            resolve(data.n_preventivo);
                        },
                        error: function(xhr) {
                            reject(xhr.responseText);
                        }
                    });
                });
            }

            function getNroOrdenCompra() {
                var nro_orden_compra = $("#n_orden_compra").val();
                var ingreso_almacen_id = $("#ingreso_almacen_id").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: 'GET',
                        url: '/ingreso-sucursal/get_nro_orden_compra_editar',
                        data: {
                            _token: CSRF_TOKEN,
                            nro_orden_compra: nro_orden_compra,
                            ingreso_almacen_id: ingreso_almacen_id
                        },
                        success: function(data) {
                            resolve(data.n_orden_compra);
                        },
                        error: function(xhr) {
                            reject(xhr.responseText);
                        }
                    });
                });
            }

            function getCodigo() {
                var codigo = $("#codigo").val();
                var ingreso_almacen_id = $("#ingreso_almacen_id").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                return new Promise((resolve, reject) => {
                    $.ajax({
                        type: 'GET',
                        url: '/ingreso-sucursal/get_codigo_editar',
                        data: {
                            _token: CSRF_TOKEN,
                            codigo: codigo,
                            ingreso_almacen_id: ingreso_almacen_id
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

            function contarRegistrosInsertados() {
                var cantidadRegistros = $("#detalle_tabla tr:not(.ignore-row)").length;
                $("#cantidad-registros b").text(cantidadRegistros);
                return cantidadRegistros;
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
                        Modal("Unos de los campos de  <b>[INGRESO O PRECIO UNITARIO]</b> no son validos");
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

            function confirmar(){
                var url = "{{ route('ingreso.sucursal.update') }}";
                $("#form").attr('action', url);
                $(".btn").hide();
                $(".spinner-btn").show();
                $("#form").submit();
            }

            function cancelar(){
                var url = "{{ route('ingreso.sucursal.index') }}";
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
                if($("#n_preventivo").val() == ""){
                    Modal("Se debe agregar un <b>[N° PREVENTIVO]</b> para continuar.");
                    return false;
                }
                /*if($("#n_orden_compra").val() == ""){
                    Modal("Se debe agregar un <b>[N° DE ORDEN DE COMPRA]</b> para continuar.");
                    return false;
                }*/
                if($("#n_solicitud").val() == ""){
                    Modal("Se debe agregar un <b>[N° DE SOLICITUD]</b> para continuar.");
                    return false;
                }
                /*if($("#proveedor_id").val() == ""){
                    Modal("Se debe agregar un <b>[PROVEEDOR]</b> para continuar.");
                    return false;
                }*/
                if($("#codigo").val() == ""){
                    Modal("Se debe agregar un <b>[N° DE INGRESO]</b> para continuar.");
                    return false;
                }
                if ($("#fecha_ingreso").val() == "") {
                    Modal("[El campo <b>[FECHA DE INGRESO]</b> no puede estar vacio.]");
                    return false;
                }

                var regex = /^(\d{2})-(\d{2})-(\d{4})$/;
                if (!regex.test($("#fecha_ingreso").val())) {
                    Modal("[El campo <b>[FECHA DE INGRESO]</b> debe tener el formato dd-mm-yyyy.]");
                    return false;
                }
                if($("#glosa").val() == ""){
                    Modal("Se debe agregar una <b>[GLOSA]</b> para continuar.");
                    return false;
                }
                return true;
            }
        </script>
    @endsection
@endsection

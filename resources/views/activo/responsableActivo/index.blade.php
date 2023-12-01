@extends('layouts.admin')
@section('content')
    <style>
        .font-verdana-bg th {
            background-color: white !important;
            color: black;
        }

        .encabezadoCodigoBarras {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 2px solid #000;
            padding: 5px;
        }

        .descripcionStyle {
            color: #000 !important;
            font-size: 16px;
            font-weight: 400;
            border: 2px solid #000;
            padding: 5px;
        }
    </style>

    <div class="row font-verdana-bg flex justify-content-between align-items-center">
        <div class="col-md-8 titulo mb-4">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                <a href="javascript:void(0);" onclick="window.history.back()">
                    <span class="color-icon-1">
                        &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                    </span>
                </a>
            </span>
            <b>LISTA DE ACTIVOS DE {{ $empleado->nombres }} {{ $empleado->ap_pat }} {{ $empleado->ap_mat }}</b>
        </div>
        <button id="abrirModal" class="btn btn-primary mb-0" style="display: none;" data-toggle="modal"
            data-target="#miModal">
            Transferir
        </button>
    </div>


    <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Cambiar responsable</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="empleadoOrigen" value="{{ $empleado->idemp }}">
                        <div class="col-md-4 mb-3">
                            <label style="color:black;font-weight: bold;">OFICINA:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <select name="idarea" id="area" class="form-control">
                                    <option value=""> Seleccione Oficina</option>
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->idarea }}">
                                            <h1 color:blue;>{{ $area->nombrearea }}</h1>
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="color:black;font-weight: bold;">RESPONSABLE:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <select name="idemp" id="empleado" class="form-control">
                                    <option value=""> Seleccione Responsable</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="color:black;font-weight: bold;">CARGO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <select name="idcargo" id="cargo" class="form-control">
                                </select>
                            </div>
                        </div>
                    </div>
                    <h4>Activos seleccionados</h4>
                    <table id="tablaSeleccionadas" class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descripcion</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary font-verdana-bg" id="btn_actualizar" type="submit">
                        <i class="fa-solid fa-paper-plane mr-2"></i>Transferir
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row font-verdana-sm">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table-bordered hoverTable" id="table-activos" style="width:100%;">
                    <thead>
                        <tr class="font-verdana-bg">
                            <th class="text-center p-1 font-weight-bold bg-info"><b>N°</b></th>
                            <th class="text-center p-1 font-weight-bold bg-info"><b>CODIGO</b></th>
                            <th class="text-center p-1 font-weight-bold bg-info"><b>DESCRIPCION</b></th>
                            <th class="text-center p-1 font-weight-bold bg-info"><b>GRUPO CONTABLE</b></th>
                            <th class="text-center p-1 font-weight-bold bg-info"><b>AUXILIAR</b></th>
                          
                            <th class="text-center p-1 font-weight-bold bg-info"><b>OFICINA</b></th>
                            <th class="text-center p-1 font-weight-bold bg-info"><b>EMPLEADO</b></th>
                            <th class="text-center p-1 font-weight-bold bg-info"><b>CARGO</b></th>
                           
                    
                            <th class="text-center p-1 font-weight-bold bg-info"><b>ESTADO</b></th>
                            <th class="text-center p-1 font-weight-bold bg-info"><i class="fa fa-bars"
                                    aria-hidden="true"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalArchivo" tabindex="-1" aria-labelledby="modalArchivo" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Codigo de barras</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="body-border ">
                        <div class="encabezadoCodigoBarras mt-2">
                            <h5 class="mb-0">GAR. Gran Chaco</h5>
                            <h6 class="mb-0" id="codigoActivo"></h6>
                        </div>
                        <div id="codigoImagen" class="text-center">
                            <svg id="codigoDeBarras"></svg>
                            <div id="codigoBarra"></div>
                        </div>
                        <p class="descripcionStyle" id="description"></p>

                        <div class="btn-group ml-auto">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('scripts')
    <script src="/js/JsBarcode.all.min.js"></script>
    <script type="text/javascript">
        $(function() {
            var table = $('#table-activos').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                autoWidth: false,
                ajax: "{{ route('activo.responsable.activo.listado', $id) }}",
                columns: [{
                        data: null,
                        render: function(data, type, row) {
                            return '<input type="checkbox" class="seleccionarFila" value="' + row
                                .id + '">';
                        },
                        orderable: false, // Para evitar que la columna sea ordenable
                        searchable: false, // Para evitar que la columna sea searchable
                        class: 'text-justify px-3 py-1 font-verdana'
                    },
                    {
                        data: 'codigo',
                        name: 'codigo',
                        class: 'text-justify py-0 font-verdana'
                    },
                    {
                        data: 'descrip',
                        name: 'descrip',
                        class: 'text-justify py-0 font-verdana'
                    },
                    {
                        data: 'codconts',
                        name: 'codconts.nombre',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'auxiliars',
                        name: 'auxiliars.nomaux',
                        class: 'text-justify p-1 font-verdana'
                    },
                 
                    {
                        data: 'areas',
                        name: 'areas.nombrearea',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'empleados',
                        name: 'empleados.nombres',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'cargo',
                        name: 'cargo',
                        class: 'text-justify p-1 font-verdana'
                    },
                   
                   
                    {
                        data: 'estado_texto',
                        name: 'estado_texto',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'btn',
                        name: 'btn',
                        class: 'text-justify py-0 font-verdana',
                        orderable: false,
                        searchable: false,
                    },
                ],
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
            $('#table-activos').on('click', '#ver-codigo', function(e) {
                e.preventDefault();
                $('#codigoActivo').html($(this).data('codigo'));
                $('#description').html($(this).data('descripcion'));

                var svg = document.getElementById('codigoDeBarras');
                svg.setAttribute('width', '80%');
                JsBarcode(svg, $(this).data('codigo'), {
                    format: 'CODE128',
                    displayValue: false,
                    width: 3,
                    height: 100,
                    font: 'verdana',
                    textAlign: 'center',
                    fontOptions: "italic"
                });
                $('#modalArchivo').modal('show');
            });
            var filasSeleccionadasArray = [];
            // Agrega un evento para seleccionar todo
            $('#seleccionarTodo').on('change', function() {
                $('.seleccionarFila').prop('checked', this.checked);
                if (this.checked) {
                    $('.seleccionarFila').closest('tr').addClass('selected');
                } else {
                    $('.seleccionarFila').closest('tr').removeClass('selected');
                }
                mostrarBotonAbrirModal();
            });
            // Agrega un evento para actualizar el checkbox "Seleccionar todo" cuando se seleccionan todas las filas manualmente
            $(document).on('click', '.seleccionarFila', function() {
                var fila = $(this).closest('tr');
                if ($(this).is(':checked')) {
                    fila.addClass('selected');
                } else {
                    fila.removeClass('selected');
                }
                var todasSeleccionadas = $('.seleccionarFila:checked').length === $('.seleccionarFila')
                    .length;
                $('#seleccionarTodo').prop('checked', todasSeleccionadas);
                mostrarBotonAbrirModal();
            });
            // Función para mostrar u ocultar el botón "Abrir Modal"
            function mostrarBotonAbrirModal() {
                var filasSeleccionadas = $('.seleccionarFila:checked').length;
                if (filasSeleccionadas > 0) {
                    $('#abrirModal').show();
                } else {
                    $('#abrirModal').hide();
                }
            }
            $('#abrirModal').on('click', function() {
                mostrarFilasSeleccionadasEnModal();
            });
            // Función para mostrar las filas seleccionadas en el modal
            function mostrarFilasSeleccionadasEnModal() {
                var filasSeleccionadas = $('.seleccionarFila:checked'); // Obtener las filas seleccionadas

                filasSeleccionadasArray = []; // Vaciar el array antes de llenarlo nuevamente

                filasSeleccionadas.each(function() {
                    var fila = $(this).closest('tr');
                    var rowData = table.row(fila).data();
                    filasSeleccionadasArray.push(rowData);
                });
                llenarTablaModal();
            }
            // Función para llenar la tabla y abrir el modal
            function llenarTablaModal() {
                var tablaSeleccionadas = $('#tablaSeleccionadas tbody');
                tablaSeleccionadas.empty();
                filasSeleccionadasArray.forEach(function(rowData) {
                    tablaSeleccionadas.append('<tr><td>' + rowData.codigo + '</td><td>' + rowData.descrip +
                        '</td></tr>');
                });
            }
            // seleccionar area
            $('#area').change(function() {
                var areaId = $(this).val();
                // Realizar una petición AJAX para obtener los empleados de la oficina seleccionada
                $.ajax({
                    url: '/gestionactivo/getResponsables',
                    type: 'GET',
                    data: {
                        area_id: areaId,
                        emp_id: {{ $id }}
                    },
                    success: function(data) {
                        var empleados = data.empleados;
                        var $empleadosSelect = $('#empleado');

                        // Limpiar el selector de empleados y agregar las nuevas opciones
                        $empleadosSelect.empty();
                        $empleadosSelect.append(
                            '<option value="">Elige un responsable</option>'); // Opción inicial

                        $.each(empleados, function(index, empleado) {
                            var ap_pat = empleado.ap_pat ? empleado.ap_pat : '';
                            var ap_mat = empleado.ap_mat ? empleado.ap_mat : '';
                            $empleadosSelect.append('<option value="' + empleado.idemp +
                                '">' +
                                empleado.nombres + " " + ap_pat + " " + ap_mat +
                                '</option>');
                        });
                    }
                });
            });
            $('#empleado').change(function() {
                var empId = $(this).val();

                // Realizar una petición AJAX para obtener los empleados de la oficina seleccionada
                $.ajax({
                    url: '/gestionactivo/getCargo',
                    type: 'GET',
                    data: {
                        emp_id: empId
                    },
                    success: function(data) {
                        var cargo = data.files;
                        var $cargoSelect = $('#cargo');

                        // Limpiar el selector de empleados y agregar las nuevas opciones
                        $cargoSelect.empty();

                        $.each(cargo, function(index, cargo) {
                            $cargoSelect.append('<option value="' + cargo.idfile +
                                '">' + cargo.nombrecargo + '</option>');
                        });
                    }
                });
            });

            $('#btn_actualizar').click(function() {
                var idEmpleado = $('#empleado').val();
                var empleadoOrigen = $('#empleadoOrigen').val();
                var oficina_id = $('#area').val();
                $.ajax({
                    url: '/Activo/responsable/update/activo',
                    type: 'POST',
                    data: {
                        empleadoOrigen: empleadoOrigen,
                        emp_id: idEmpleado,
                        oficina_id: oficina_id,
                        activos: filasSeleccionadasArray,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        var nuevaURL = '/Activo/responsable/index/' + idEmpleado +
                            '/activo';
                        window.location.href = nuevaURL;
                    }
                });
            });

        });
    </script>
@endsection
@endsection

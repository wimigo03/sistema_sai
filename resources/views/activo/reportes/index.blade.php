@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1 class="text-3xl font-bold mb-6">Reportes</h1>
        <div class="body-border">
            <div class="row">
                <div class="col-12">
                    <div class="row mb-2">
                        <label style="color:black;font-weight: bold;" class="col-md-2">ENTIDAD:</label>
                        <div class="input-group col-md-8">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ $entidad->entidad }}</span>
                            </div>
                            <input type="text" name="sigla" readonly class="form-control"
                                value="{{ $entidad->entidad }}">
                        </div>
                    </div>
                    <div class="row">
                        <label style="color:black;font-weight: bold;" class="col-md-2">UNIDAD:</label>
                        <div class="input-group col-md-8">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ $unidad->unidad }}</span>
                            </div>
                            <select id="unidad_admin" class="form-control">
                                @foreach ($unidades as $uni)
                                    <option value="{{ $uni->unidad }}"
                                        {{ $uni->idunidadadmin === $unidad->idunidadadmin ? 'selected' : '' }}>
                                        {{ $uni->descrip }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body-border">
            <div class="row">
                <div class="col-12">
                    <div class="row mb-2">
                        <label style="color:black;font-weight: bold;" class="col-md-2">GRUPO:</label>
                        <div class="input-group col-md-8">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="cantidad_grupo">0</span>
                            </div>
                            <select name="codcont" id="codcont" class="form-control">
                                <option value="">Seleccione Grupo Contable</option>
                                @foreach ($codcont as $grupo)
                                    <option value="{{ $grupo->codcont }}">
                                        {{ $grupo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="grupoError" class="error-message"></div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-sm btn-block btn-primary" id="grupoTodos" disabled>Todos</button>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label style="color:black;font-weight: bold;" class="col-md-2">AUXILIAR:</label>
                        <div class="input-group col-md-8">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="cantidad_auxiliar">0</span>
                            </div>
                            <select name="idaux" id="codaux" class="form-control">
                                <option value=""> Seleccione Auxiliar </option>
                            </select>
                            <div id="auxiliarError" class="error-message"></div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-sm btn-block" id="auxiliarTodos" disabled>Todos</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body-border">
            <div class="row">
                <div class="col-12">
                    <div class="row mb-2">
                        <label style="color:black;font-weight: bold;" class="col-md-2">OFICINA:</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="cantidad_oficina">0</span>
                                </div>
                                <select name="idarea" id="area" class="form-control">
                                    <option value="">Seleccione Oficina</option>
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->idarea }}"
                                            {{ old('idarea') == $area->idarea ? 'selected' : '' }}>
                                            {{ $area->nombrearea }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="oficinaError" class="text-danger text-sm"></div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-sm btn-block" id="oficinaTodos" disabled>Todos</button>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label style="color:black;font-weight: bold;" class="col-md-2">RESPONSABLE:</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="cantidad_responsable">0</span>
                                </div>
                                <select name="idemp" id="empleado" class="form-control">
                                    <option value=""> Seleccione Responsable</option>
                                </select>
                                <div id="responsableError" class="error-message"></div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-sm btn-block" id="empleadoTodos" disabled>Todos</button>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label style="color:black;font-weight: bold;" class="col-md-2">ACTIVOS:</label>
                        <div class="input-group col-md-8">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="cantidad_activos">{{ count($activos) }}</span>
                            </div>
                            <input type="text" class="form-control"
                                value="{{ count($activos) }} activo(s) seleccionados" readonly id="activos">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="modalActivos">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </div>
                        <div id="activosError" class="error-message"></div>
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-sm btn-block" id="activoTodos" disabled>Todos</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="body-border">
                    <div class="row mb-2">
                        <label style="color:black;font-weight: bold;" class="col-md-3">DE: AÑO:</label>
                        <div class="input-group col-md-3">
                            <input type="number" id="anio_ini" class="form-control" min="2004" value="2004">
                        </div>
                        <label style="color:black;font-weight: bold;" class="col-md-6">Año Inicial De Los Reportes A
                            Generar:</label>
                    </div>
                    <div class="row">
                        <label style="color:black;font-weight: bold;" class="col-md-3">A: AÑO:</label>
                        <div class="input-group col-md-3">
                            <input type="number" max="{{ date('Y') }}" id="anio_fin" class="form-control"
                                value="2023">
                        </div>
                        <label style="color:black;font-weight: bold;" class="col-md-6">Año Final De Los Reportes A
                            Generar:</label>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center my-auto">
                <button class="btn btn-primary btn-sm px-5">Todos</button>
            </div>
        </div>
        <div class="body-border">
            <div class="row">
                <label style="color:black;font-weight: bold; margin: auto 0px" class="col-md-2">CALCULADO A :</label>
                <div class="input-group col-md-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">DÍA </span>
                    </div>
                    <input type="text" name="dia" class="form-control" value="{{ date('d') }}" required>
                </div>
                <div class="input-group col-md-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">MES </span>
                    </div>
                    <input type="text" name="mes" class="form-control" value="{{ date('m') }}" required>
                </div>
                <div class="input-group col-md-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">AÑO </span>
                    </div>
                    <input type="text" name="año" class="form-control" value="{{ date('Y') }}" required>
                </div>
                <div class="input-group col-md-2">
                    <label style="color:black;font-weight: bold; margin: auto 12px">UFV :</label>
                    <input type="text" name="año" class="form-control" readonly value="2.35998">
                </div>
                <div class="input-group col-md-2">
                    <button class="btn btn-primary btn-sm btn-block">Hoy</button>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <div class="body-border">
                <button type="button" class="btn btn-primary" id="abrirReportesModal">
                    Reportes
                </button>
            </div>
        </div>
    </div>
    {{-- MODAL ACTIVOS --}}
    <div class="modal fade" id="activosModal" tabindex="-1" aria-labelledby="activosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="activosModalLabel">Activos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="activosTable" class="table">
                        <thead>
                            <tr>
                                <th>
                                    <label for="selectAllCheckbox">
                                        <input type="checkbox" id="selectAllCheckbox" checked>
                                    </label>
                                </th>
                                <th>Codigo</th>
                                <th>Descripcion</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL REPORTES --}}
    <div class="modal fade" id="reportesModal" tabindex="-1" aria-labelledby="reportesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportesModalLabel">Reportes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" style="max-height: 400px; overflow-y: auto;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>rep1</td>
                                <td>Inventario ordenado por Código de Activo</td>
                                <td>
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Exportar Pdf">
                                        <a href="#" onclick="generarReportePdf1()">
                                            <span class="text-primary">
                                                <i class="fa-solid fa-file-pdf fa-xl text-danger"></i>
                                            </span>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>rep2</td>
                                <td>Inventario ordenado por Grupo Contable</td>
                                <td>
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Exportar Pdf">
                                        <a href="#" onclick="generarReportePdf2()">
                                            <span class="text-primary">
                                                <i class="fa-solid fa-file-pdf fa-xl text-danger"></i>
                                            </span>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>rep3</td>
                                <td>Inventario ordenado por Grupo y Auxiliar Contable</td>
                                <td>
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Exportar Pdf">
                                        <a href="#" onclick="generarReportePdf3()">
                                            <span class="text-primary">
                                                <i class="fa-solid fa-file-pdf fa-xl text-danger"></i>
                                            </span>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>rep4</td>
                                <td>Inventario ordenado por Oficina</td>
                                <td>
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Exportar Pdf">
                                        <a href="#" onclick="generarReportePdf4()">
                                            <span class="text-primary">
                                                <i class="fa-solid fa-file-pdf fa-xl text-danger"></i>
                                            </span>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>rep5</td>
                                <td>Inventario ordenado por Oficina y Responsable</td>
                                <td>
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Exportar Pdf">
                                        <a href="#" onclick="generarReportePdf5()">
                                            <span class="text-primary">
                                                <i class="fa-solid fa-file-pdf fa-xl text-danger"></i>
                                            </span>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>rep6</td>
                                <td>Resumen de Activos Fijos por Grupo</td>
                                <td>
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Exportar Pdf">
                                        <a href="#" onclick="generarReportePdf6()">
                                            <span class="text-primary">
                                                <i class="fa-solid fa-file-pdf fa-xl text-danger"></i>
                                            </span>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>rep7</td>
                                <td>Detalle de Responsables por Oficina</td>
                                <td>
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Exportar Pdf">
                                        <a href="#" onclick="generarReportePdf7()">
                                            <span class="text-primary">
                                                <i class="fa-solid fa-file-pdf fa-xl text-danger"></i>
                                            </span>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>rep8</td>
                                <td>Reporte de Transferencia de Activos</td>
                                <td>
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Exportar Pdf">
                                        <a href="#" onclick="generarReportePdf8()">
                                            <span class="text-primary">
                                                <i class="fa-solid fa-file-pdf fa-xl text-danger"></i>
                                            </span>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>rep9</td>
                                <td>Reporte Historico de Activos dados de Baja</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>rep10</td>
                                <td>Inventario de Activos Fijos por Grupo Contable</td>
                                <td>
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Exportar Pdf">
                                        <a href="#" onclick="generarReportePdf10()">
                                            <span class="text-primary">
                                                <i class="fa-solid fa-file-pdf fa-xl text-danger"></i>
                                            </span>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>rep11</td>
                                <td>Reporte de Indices UFV</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>rep12</td>
                                <td>Reporte Historico de Activos Revaluados</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>rep13</td>
                                <td>Asignacion individual de Bienes</td>
                                <td>
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Exportar Pdf">
                                        <a href="#" onclick="generarReportePdf13()">
                                            <span class="text-primary">
                                                <i class="fa-solid fa-file-pdf fa-xl text-danger"></i>
                                            </span>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>rep14</td>
                                <td>Reporte de Bajas por Error de Transcripción</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>rep15</td>
                                <td>Resumen de Activos Fijos Ordenados por Grupo</td>
                                <td>
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Exportar Pdf">
                                        <a href="#" onclick="generarReportePdf15()">
                                            <span class="text-primary">
                                                <i class="fa-solid fa-file-pdf fa-xl text-danger"></i>
                                            </span>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>rep16</td>
                                <td>Acta de Devolucion de Bienes</td>
                                <td>
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Exportar Pdf">
                                        <a href="#" onclick="generarReportePdf16()">
                                            <span class="text-primary">
                                                <i class="fa-solid fa-file-pdf fa-xl text-danger"></i>
                                            </span>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>rep17</td>
                                <td>Inventario ordenado por Grupo Contable y Organismo</td>
                                <td>
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Exportar Pdf">
                                        <a href="#" onclick="generarReportePdf17()">
                                            <span class="text-primary">
                                                <i class="fa-solid fa-file-pdf fa-xl text-danger"></i>
                                            </span>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>rep18</td>
                                <td>Kardex correlativo</td>
                                <td>
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Exportar Pdf">
                                        <a href="#" onclick="generarReportePdf18()">
                                            <span class="text-primary">
                                                <i class="fa-solid fa-file-pdf fa-xl text-danger"></i>
                                            </span>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/toastr/toastr.min.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('admin_assets/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        var activo_ids = [];
        var unidad = "{{ $unidad->unidad }}";
        var oficina_id = null;
        var empleado_id = null;
        var grupo_id = null;
        var auxiliar_id = null;
        var getActivos = null
        var activosSeleccionados = null
        var activos_ids = null
        var anio_ini = null;
        var anio_fin = null;
        $(document).ready(function() {
            // UNIDADES ADMINISTRATIVAS
            $('#unidad_admin').change(function() {
                unidad = $(this).val();
                $.ajax({
                    url: '/Activo/reportes/filtroUnidad',
                    type: 'GET',
                    data: {
                        unidad: unidad
                    },
                    success: function(data) {
                        cambiarUnidadAdmin();
                        llenarGrupos(data.grupos)
                        llenarOficinas(data.oficinas)
                        llenarTabla(data.activos);
                        mostrarCantidadActivos(data.activos)
                    }
                });
            });
            // GRUPOS
            function getGrupos(grupo_id) {
                $.ajax({
                    url: "/Activo/reportes/filtroTodos",
                    type: "GET",
                    data: {
                        grupo_id: grupo_id,
                        unidad: unidad,
                        oficina_id: oficina_id,
                        empleado_id: empleado_id,
                    },
                    success: function(data) {
                        llenarAuxiliares(data.auxiliares);
                        llenarOficinas(data.oficinas);
                        llenarEmpleados(data.empleados)
                        llenarTabla(data.activos);
                        mostrarCantidadActivos(data.activos);
                    },
                });
            }

            $("#codcont").change(function() {
                grupo_id = $(this).val();
                getGrupos(grupo_id);
                $("#grupoTodos").prop("disabled", false);
                $("#auxiliarTodos").prop("disabled", true);
            });

            $("#grupoTodos").click(function() {
                grupo_id = null;
                getGrupos(grupo_id);
                $("#grupoTodos").prop("disabled", true);
                $("#codcont").val("");
            });

            function llenarGrupos(grupos) {
                var $idGrupoSelected = $('#codcont');
                var grupoSeleccionado = $idGrupoSelected.val();
                $('#cantidad_grupo').html(grupos.length);
                $idGrupoSelected.empty();
                $idGrupoSelected.append('<option value="">Seleccione un grupo</option>');
                $.each(grupos, function(index, grupo) {
                    $idGrupoSelected.append('<option value="' + grupo.codcont + '">' + grupo.nombre +
                        '</option>');
                });
                if (grupoSeleccionado) {
                    $idGrupoSelected.val(grupoSeleccionado);
                }
            }

            // Auxiliares
            function getAuxiliares(auxiliar_id) {
                $.ajax({
                    url: '/Activo/reportes/filtroTodos',
                    type: 'GET',
                    data: {
                        unidad: unidad,
                        grupo_id: grupo_id,
                        auxiliar_id: auxiliar_id,
                        oficina_id: oficina_id,
                        empleado_id: empleado_id,
                    },
                    success: function(data) {
                        llenarGrupos(data.grupos);
                        llenarOficinas(data.oficinas);
                        llenarEmpleados(data.empleados)
                        llenarTabla(data.activos);
                        mostrarCantidadActivos(data.activos);
                    }
                });
            }

            $('#codaux').change(function() {
                auxiliar_id = $(this).val();
                getAuxiliares(auxiliar_id);
                $('#auxiliarTodos').prop('disabled', false);
            });

            $('#auxiliarTodos').click(function() {
                auxiliar_id = null;
                getAuxiliares(auxiliar_id);
                $('#auxiliarTodos').prop('disabled', true);
                $('#codaux').val('');

            });

            function llenarAuxiliares(auxiliares) {
                var $codauxselect = $('#codaux');
                var auxiliarSeleccionado = $codauxselect.val();

                if (auxiliar_id === null && grupo_id !== null) {
                    $('#cantidad_grupo').html(auxiliares.length);
                    $codauxselect.empty();
                    $codauxselect.append('<option value="">Seleccione Auxiliar</option>'); // Opción inicial

                    $.each(auxiliares, function(index, auxiliar) {
                        $codauxselect.append('<option value="' + auxiliar.codaux + '">' +
                            ' ' + auxiliar.nomaux + '</option>');
                    })
                }

                // Verificar si ya hay un auxiliar seleccionado y restaurarlo
                if (auxiliarSeleccionado) {
                    $codauxselect.val(auxiliarSeleccionado);
                }
            }

            // Oficinas 
            function getOficinas(oficina_id) {
                $.ajax({
                    url: '/Activo/reportes/filtroTodos',
                    type: 'GET',
                    data: {
                        unidad: unidad,
                        grupo_id: grupo_id,
                        auxiliar_id: auxiliar_id,
                        oficina_id: oficina_id,
                        empleado_id: empleado_id,
                    },
                    success: function(data) {
                        llenarEmpleados(data.empleados)
                        llenarGrupos(data.grupos)
                        llenarAuxiliares(data.auxiliares)
                        llenarTabla(data.activos);
                        mostrarCantidadActivos(data.activos);
                    }
                });
            }

            $('#area').change(function() {
                oficina_id = $(this).val();
                getOficinas(oficina_id);
                $('#oficinaTodos').prop('disabled', false);
            });

            $('#oficinaTodos').click(function() {
                oficina_id = null;
                getOficinas(oficina_id);
                $('#oficinaTodos').prop('disabled', true);
                $('#area').val('');
            });

            function llenarOficinas(oficinas) {
                var $idareaSelect = $('#area');
                var oficinaSeleccionada = $idareaSelect.val();

                $('#cantidad_oficina').html(oficinas.length);
                $idareaSelect.empty();
                $idareaSelect.append('<option value="">Seleccione Oficina</option>');
                $.each(oficinas, function(index, oficina) {
                    $idareaSelect.append('<option value="' + oficina.idarea + '">' + oficina
                        .nombrearea + '</option>');
                });

                // Verificar si ya hay una oficina seleccionada y restaurarla
                if (oficinaSeleccionada) {
                    $idareaSelect.val(oficinaSeleccionada);
                }
            }

            // Empleados 
            function getEmpleados(empleado_id) {
                $.ajax({
                    url: '/Activo/reportes/filtroTodos',
                    type: 'GET',
                    data: {
                        unidad: unidad,
                        grupo_id: grupo_id,
                        auxiliar_id: auxiliar_id,
                        oficina_id: oficina_id,
                        empleado_id: empleado_id,
                    },
                    success: function(data) {
                        llenarGrupos(data.grupos);
                        llenarOficinas(data.oficinas);
                        llenarAuxiliares(data.auxiliares)
                        llenarTabla(data.activos);
                        mostrarCantidadActivos(data.activos);
                    }
                });
            }

            $('#empleado').change(function() {
                empleado_id = $(this).val();
                getEmpleados(empleado_id);
                $('#empleadoTodos').prop('disabled', false);
            });

            $('#empleadoTodos').click(function() {
                empleado_id = null;
                getEmpleados(empleado_id);
                $('#empleadoTodos').prop('disabled', true);
                $('#empleado').val('');
            });

            function llenarEmpleados(empleados) {
                var $empleadosSelect = $('#empleado');
                var empleadoSeleccionado = $empleadosSelect.val();

                $empleadosSelect.empty();
                $empleadosSelect.append('<option value="">Elige un responsable</option>');
                $.each(empleados, function(index, empleado) {
                    $empleadosSelect.append('<option value="' + empleado.idemp + '">' +
                        empleado.nombres +
                        (empleado.ap_pat ? " " + empleado.ap_pat : "") +
                        (empleado.ap_mat ? " " + empleado.ap_mat : "") +
                        '</option>');
                });

                // Verificar si ya hay un empleado seleccionado y restaurarlo
                if (empleadoSeleccionado) {
                    $empleadosSelect.val(empleadoSeleccionado);
                }
            }

            // Llenar activos
            function llenarTabla(activos) {
                getActivos = activos
                activosSeleccionados = activos;
                activos_ids = activosSeleccionados.map(function(activo) {
                    return activo.id;
                });
                getActivos.forEach(function(activo) {
                    activo.checked = true;
                });
                $('#activosTable tbody').empty();
                for (var i = 0; i < getActivos.length; i++) {
                    var isChecked = getActivos[i].checked ? 'checked' : '';
                    var rowData = '<tr>' +
                        '<td><input type="checkbox" class="itemCheckbox" ' + isChecked +
                        '></td>' +
                        '<td>' + getActivos[i].codigo + '</td>' +
                        '<td>' + getActivos[i].descrip + '</td>' +
                        '</tr>';
                    $('#activosTable tbody').append(rowData);
                }
            }

            function cambiarUnidadAdmin() {
                oficina_id = null;
                empleado_id = null;
                grupo_id = null;
                auxiliar_id = null;

                $('#grupoTodos').prop('disabled', true);
                $('#auxiliarTodos').prop('disabled', true);
                $('#oficinaTodos').prop('disabled', true);
                $('#empleadoTodos').prop('disabled', true);
                $('#activoTodos').prop('disabled', true);
            }

            $('#modalActivos').click(function() {
                $('#activosModal').modal('show');
            });

            $('#selectAllCheckbox').change(function() {
                var checked = $(this).prop('checked');
                $('.itemCheckbox').prop('checked', checked);
                for (var i = 0; i < getActivos.length; i++) {
                    getActivos[i].checked = checked;
                }
                mostrarCantidadActivos(getActivos)
                $('#activoTodos').prop('disabled', true);
            });

            $('#activosTable').on('change', '.itemCheckbox', function() {
                var index = $(this).closest('tr').index();
                getActivos[index].checked = $(this).prop('checked');
                $('#activoTodos').prop('disabled', false);
                updateSelectAllCheckbox();
                activosSeleccionados = getActivos.filter(function(activo) {
                    return activo.checked;
                });
                activos_ids = activosSeleccionados.map(function(activo) {
                    return activo.id;
                });
                mostrarCantidadActivos(activosSeleccionados)
            });

            function mostrarCantidadActivos(activos) {
                $('#cantidad_activos').html(activos.length)
                $('#activos').val(activos.length + " activo(s) seleccionados")
            }


            function updateSelectAllCheckbox() {
                var allChecked = true;
                for (var i = 0; i < getActivos.length; i++) {
                    if (!getActivos[i].checked) {
                        allChecked = false;
                        break;
                    }
                }
                $('#selectAllCheckbox').prop('checked', allChecked);
            }

            $('#activoTodos').click(function() {
                $('.itemCheckbox').prop('checked', true);
                $('#selectAllCheckbox').prop('checked', true);
                mostrarCantidadActivos(getActivos);
                $('#activoTodos').prop('disabled', true);
            });

            $('#abrirReportesModal').click(function() {
                $('#reportesModal').modal('show');
                anio_ini = $('#anio_ini').val();
                anio_fin = $('#anio_fin').val();
            });
        });

        function errorActivos(activos) {
            if (activos == null || activos.length < 1) {
                toastr.error('No ha seleccionado ningún activo');
                throw new Error('No ha seleccionado ningún activo');
            }
        }

        function errorGrupo(grupo_id) {
            if (grupo_id == null) {
                toastr.error('Debe seleccionar un grupo contable')
                throw new Error('Debe seleccionar un grupo contable');
            }
        }

        function errorAuxiliar(auxiliar_id) {
            if (auxiliar_id == null) {
                toastr.error('Debe seleccionar un auxiliar contable')
                throw new Error('Debe seleccionar un auxiliar contable');
            }
        }

        function errorOficina(oficina_id) {
            if (oficina_id == null) {
                toastr.error('Debe seleccionar un oficina')
                throw new Error('Debe seleccionar un oficina');
            }
        }

        function errorEmpleado(empleado_id) {
            if (empleado_id == null) {
                toastr.error('Debe seleccionar un empleado')
                throw new Error('Debe seleccionar un oficina');
            }
        }

        const generarReportePdf1 = () => {
            try {
                errorActivos(activosSeleccionados);
                const activosSeleccionadosJSON = JSON.stringify(activos_ids);
                const url =
                    `/reportes/rep1-pdf?unidad=${unidad}&anio_ini=${anio_ini}&anio_fin=${anio_fin}&activos=${activosSeleccionadosJSON}`;
                window.open(url, '_blank');
            } catch (error) {
                console.error(error);
            }
        };

        const generarReportePdf2 = () => {
            try {
                errorActivos(activosSeleccionados)
                errorGrupo(grupo_id)
                const activosSeleccionadosJSON = JSON.stringify(activos_ids);
                const url =
                    `/reportes/rep2-pdf?unidad=${unidad}&anio_ini=${anio_ini}&anio_fin=${anio_fin}&grupo_id=${grupo_id}&activos=${activosSeleccionadosJSON}`;
                window.open(url, '_blank');
            } catch (error) {
                console.error(error);
            }
        };
        const generarReportePdf3 = () => {
            try {
                errorActivos(activosSeleccionados)
                errorGrupo(grupo_id)
                errorGrupo(auxiliar_id)
                const activosSeleccionadosJSON = JSON.stringify(activos_ids);
                const url =
                    `/reportes/rep3-pdf?unidad=${unidad}&anio_ini=${anio_ini}&anio_fin=${anio_fin}&grupo_id=${grupo_id}&auxiliar_id=${auxiliar_id}&activos=${activosSeleccionadosJSON}`;
                window.open(url, '_blank');
            } catch (error) {
                console.error(error);
            }
        };
        const generarReportePdf4 = () => {
            try {
                errorActivos(activosSeleccionados)
                errorOficina(oficina_id)
                const activosSeleccionadosJSON = JSON.stringify(activos_ids);
                const url =
                    `/reportes/rep4-pdf?unidad=${unidad}&anio_ini=${anio_ini}&anio_fin=${anio_fin}&oficina_id=${oficina_id}&activos=${activosSeleccionadosJSON}`;
                window.open(url, '_blank');
            } catch (error) {
                console.error(error);
            }
        };
        const generarReportePdf5 = () => {
            try {
                errorActivos(activosSeleccionados)
                errorOficina(oficina_id)
                errorEmpleado(empleado_id)
                const activosSeleccionadosJSON = JSON.stringify(activos_ids);
                const url =
                    `/reportes/rep5-pdf?unidad=${unidad}&anio_ini=${anio_ini}&anio_fin=${anio_fin}&oficina_id=${oficina_id}&empleado_id=${empleado_id}&activos=${activosSeleccionadosJSON}`;
                window.open(url, '_blank');
            } catch (error) {
                console.error(error);
            }
        };
        const generarReportePdf6 = () => {
            try {
                errorActivos(activosSeleccionados)
                const activosSeleccionadosJSON = JSON.stringify(activos_ids);
                const url =
                    `/reportes/rep6-pdf?unidad=${unidad}&anio_ini=${anio_ini}&anio_fin=${anio_fin}&activos=${activosSeleccionadosJSON}`;
                window.open(url, '_blank');
            } catch (error) {
                console.error(error);
            }
        };
        const generarReportePdf7 = () => {
            try {
                errorOficina(oficina_id)
                errorEmpleado(empleado_id)
                const url =
                    `/reportes/rep7-pdf?unidad=${unidad}&anio_ini=${anio_ini}&anio_fin=${anio_fin}&oficina_id=${oficina_id}&empleado_id=${empleado_id}`;
                window.open(url, '_blank');
            } catch (error) {
                console.error(error);
            }
        };
        const generarReportePdf8 = () => {
            try {
                errorActivos(activosSeleccionados)
                const activosSeleccionadosJSON = JSON.stringify(activos_ids);
                const url =
                    `/reportes/rep8-pdf?unidad=${unidad}&anio_ini=${anio_ini}&anio_fin=${anio_fin}&activos=${activosSeleccionadosJSON}`;
                window.open(url, '_blank');
            } catch (error) {
                console.error(error);
            }
        };
        const generarReportePdf10 = () => {
            try {
                errorActivos(activosSeleccionados)
                errorGrupo(grupo_id)
                const activosSeleccionadosJSON = JSON.stringify(activos_ids);
                const url =
                    `/reportes/rep10-pdf?unidad=${unidad}&anio_ini=${anio_ini}&anio_fin=${anio_fin}&grupo_id=${grupo_id}&activos=${activosSeleccionadosJSON}`;
                window.open(url, '_blank');
            } catch (error) {
                console.error(error);
            }
        };
        const generarReportePdf13 = () => {
            try {
                errorActivos(activosSeleccionados)
                errorEmpleado(empleado_id)
                const activosSeleccionadosJSON = JSON.stringify(activos_ids);
                const url =
                    `/reportes/rep13-pdf?unidad=${unidad}&anio_ini=${anio_ini}&anio_fin=${anio_fin}&empleado_id=${empleado_id}&activos=${activosSeleccionadosJSON}`;
                window.open(url, '_blank');
            } catch (error) {
                console.error(error);
            }
        };
        const generarReportePdf15 = () => {
            try {
                errorActivos(activosSeleccionados)
                const activosSeleccionadosJSON = JSON.stringify(activos_ids);
                const url =
                    `/reportes/rep15-pdf?unidad=${unidad}&anio_ini=${anio_ini}&anio_fin=${anio_fin}&activos=${activosSeleccionadosJSON}`;
                window.open(url, '_blank');
            } catch (error) {
                console.error(error);
            }
        };
        const generarReportePdf16 = () => {
            try {
                errorActivos(activosSeleccionados)
                errorEmpleado(empleado_id)
                const activosSeleccionadosJSON = JSON.stringify(activos_ids);
                const url =
                    `/reportes/rep16-pdf?unidad=${unidad}&anio_ini=${anio_ini}&anio_fin=${anio_fin}&empleado_id=${empleado_id}&activos=${activosSeleccionadosJSON}`;
                window.open(url, '_blank');
            } catch (error) {
                console.error(error);
            }
        };
        const generarReportePdf17 = () => {
            try {
                errorActivos(activosSeleccionados)
                errorGrupo(grupo_id)
                const activosSeleccionadosJSON = JSON.stringify(activos_ids);
                const url =
                    `/reportes/rep17-pdf?unidad=${unidad}&anio_ini=${anio_ini}&anio_fin=${anio_fin}&grupo_id=${grupo_id}&activos=${activosSeleccionadosJSON}`;
                window.open(url, '_blank');
            } catch (error) {
                console.error(error);
            }
        };
        const generarReportePdf18 = () => {
            try {
                errorActivos(activosSeleccionados)
                errorGrupo(grupo_id)
                errorEmpleado(empleado_id)
                const activosSeleccionadosJSON = JSON.stringify(activos_ids);
                const url =
                    `/reportes/rep18-pdf?unidad=${unidad}&anio_ini=${anio_ini}&anio_fin=${anio_fin}&grupo_id=${grupo_id}&empleado_id=${empleado_id}&activos=${activosSeleccionadosJSON}`;
                window.open(url, '_blank');
            } catch (error) {
                console.error(error);
            }
        };
    </script>
@endsection

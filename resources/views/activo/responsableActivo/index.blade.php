@extends('layouts.admin')
@section('content')
<<<<<<< HEAD
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.0/css/fixedColumns.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/2.0.0/css/select.dataTables.css">
=======
    <style>
        .font-verdana-12 th {
            background-color: white !important;
            color: black;
        }
>>>>>>> 3edb64968420d77fd93f44287fe518a940cbb99d

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

<<<<<<< HEAD
.descripcionStyle {
    color: #000 !important;
    font-size: 16px;
    font-weight: 400;
    border: 2px solid #000;
    padding: 5px;
}
</style>
=======
    <div class="row font-verdana-12 flex justify-content-between align-items-center">
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
        <div class="">
            <span class="tts:left tts-slideIn tts-custom" aria-label="Asignacion Interna de Bienes">
                <button onclick="generarReporteAsignacion()" id="asignacion" class="btn btn-primary" disabled>
                    <i class="fa-duotone fa-arrows-turn-right"></i>
                </button>
            </span>
            <span class="tts:left tts-slideIn tts-custom" aria-label="Devolucion Interna de Bienes">
                <button onclick="generarReporteDevolucion()" id="devolucion" class="btn btn-primary" disabled>
                    <i class="fa-solid fa-left"></i>
                </button>
            </span>
            <span class="tts:left tts-slideIn tts-custom" aria-label="Kardex de Activos">
                <button onclick="generarReporteKardex()" id="kardex" class="btn btn-primary" disabled>
                    <i class="fa-light fa-files"></i>
                </button>
            </span>
            <span class="tts:left tts-slideIn tts-custom" aria-label="Transferir Activos">
                <button id="abrirModal" class="btn btn-primary mb-0" data-toggle="modal" data-target="#miModal" disabled>
                    <i class="fa-solid fa-right-left"></i>
                </button>
            </span>
        </div>
    </div>
>>>>>>> 3edb64968420d77fd93f44287fe518a940cbb99d



@include('activo.responsableActivo.btn_reportes')

@include('activo.responsableActivo.search')

@include('activo.responsableActivo.table')

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
                <h4>Activos seleccionados <span id="totalSeleccionados"></span> </h4>
                <table id="tablaSeleccionadas" class="table table-striped">
                    <thead>
<<<<<<< HEAD
                        <tr>
                            <th>ID</th>
                            <th>Descripcion</th>
                            <th>Estado</th>
=======
                        <tr class="font-verdana-12">
                            <th class="text-center p-1 font-weight-bold bg-info"><input type="checkbox"
                                    id="seleccionarTodo"></th>
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
>>>>>>> 3edb64968420d77fd93f44287fe518a940cbb99d
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
<<<<<<< HEAD
            <div class="modal-footer">
                <button class="btn btn-primary font-verdana-bg" id="btn_actualizar" type="submit">
                    <i class="fa-solid fa-paper-plane mr-2"></i>Transferir
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
=======
        </div>
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
                    <button class="btn btn-primary font-verdana-12" id="btn_actualizar" type="submit">
                        <i class="fa-solid fa-paper-plane mr-2"></i>Transferir
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
>>>>>>> 3edb64968420d77fd93f44287fe518a940cbb99d
            </div>
        </div>
    </div>
</div>

@include('activo.responsableActivo.modal')

@endsection

@section('scripts')
<script src="/js/JsBarcode.all.min.js"></script>
<script type="text/javascript">
var filasSeleccionadasArray = [];
var idsFilasSeleccionadas = [];
var filasSeleccionadas = new Set();
var totalSeleccionados = 0;
var empleado = {!! json_encode($empleado) !!};
function search() {
    var url = "{{ route('activo.responsable.activo.search', $empleado->idemp) }}";
    $("#form").attr('action', url);
    $(".btn").hide();
    $(".btn-importar").hide();
    $(".spinner-btn").show();
    $("#form").submit();
}

function limpiar() {
    $(".btn").hide();
    $(".btn-importar").hide();
    $(".spinner-btn").show();
    window.location.href = "{{ route('activo.responsable.activo.index', $empleado->idemp) }}";
}
$(function() {
    $('.ver-codigo').on('click', function(e){
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
    // Agrega un evento para seleccionar todo
    $(document).ready(function() {
        $('#seleccionarTodo').click(function() {
            $('.seleccionarFila').prop('checked', this.checked);

            llenarIds();
            mostrarBotonAbrirModal();

        });

        $('.seleccionarFila').click(function() {
            if ($('.seleccionarFila:checked').length == $('.seleccionarFila').length) {
                $('#seleccionarTodo').prop('checked', true);
            } else {
                $('#seleccionarTodo').prop('checked', false);
            }
            mostrarBotonAbrirModal();
            llenarIds();
        });
    });

    // Función para habilitar u desabilitar los botones
    function mostrarBotonAbrirModal() {
        var filasSeleccionadas = $('.seleccionarFila:checked').length;
        if (filasSeleccionadas > 0) {
            $('#abrirModal').prop('disabled', false);
            $('#asignacion').prop('disabled', false);
            $('#devolucion').prop('disabled', false);
            $('#kardex').prop('disabled', false);
        } else {
            $('#abrirModal').prop('disabled', true);
            $('#asignacion').prop('disabled', true);
            $('#devolucion').prop('disabled', true);
            $('#kardex').prop('disabled', true);
        }
    }


    $(document).on('change', '.seleccionarFila', function() {
        var id = $(this).val();
        if ($(this).prop('checked')) {
            filasSeleccionadas.add(id);
        } else {
            filasSeleccionadas.delete(id);
        }
    });

    $('#abrirModal').on('click', function() {
        llenarTablaModal();
    });
    totalSeleccionados = filasSeleccionadasArray.length;
    $("#totalSeleccionados").text(totalSeleccionados);

    function llenarIds() {
       var filasSeleccionadas = $('.seleccionarFila:checked');
       if (filasSeleccionadas.length > 0) {
           filasSeleccionadasArray = [];
           idsFilasSeleccionadas = [];
           filasSeleccionadas.each(function() {
               var rowData = {
                   id: $(this).closest('tr').find('.id').text(),
                   codigo: $(this).closest('tr').find('.codigo').text(),
                   descrip: $(this).closest('tr').find('.descrip').text(),
                   estado: $(this).closest('tr').find('.codestado').text(),
                   codemp: $(this).closest('tr').find('.codemp').text(),
               };
               filasSeleccionadasArray.push(rowData);
               idsFilasSeleccionadas.push(rowData.id);
               console.log(filasSeleccionadasArray)
           });
           totalSeleccionados = filasSeleccionadas.length;
           $("#totalSeleccionados").text(totalSeleccionados)
       }
   }
    function llenarTablaModal() {
        var tablaSeleccionadas = $('#tablaSeleccionadas tbody');
        tablaSeleccionadas.empty();
        filasSeleccionadasArray.forEach(function(rowData) {
            tablaSeleccionadas.append('<tr><td>' + rowData.codigo + '</td><td>' + rowData.descrip +
                '</td><td>' + rowData.estado + '</td></tr>');
        });
    }


    $('#area').change(function() {
        var areaId = $(this).val();
        // Realizar una petición AJAX para obtener los empleados de la oficina seleccionada
        $.ajax({
            url: '/gestionactivo/getResponsables',
            type: 'GET',
            data: {
                area_id: areaId,
                emp_id: "{{ $empleado->id }}"
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

    function generarReporteAsignacion() {
        const activosSeleccionadosJSON = JSON.stringify(idsFilasSeleccionadas);
        const url =
        `/reportes/asignacion?activos=${activosSeleccionadosJSON}&empleado=${empleado.idemp}`;
        window.open(url, '_blank');
    };

    function generarReporteDevolucion() {
        const activosSeleccionadosJSON = JSON.stringify(idsFilasSeleccionadas);
        const url =
        `/reportes/devolucion?activos=${activosSeleccionadosJSON}&empleado=${empleado.idemp}`;
        window.open(url, '_blank');
    };

    function generarReporteKardex() {
        const activosSeleccionadosJSON = JSON.stringify(idsFilasSeleccionadas);
        const url =
        `/reportes/kardex?activos=${activosSeleccionadosJSON}&empleado=${empleado.idemp}`;
        window.open(url, '_blank');
    };
    </script>
    @endsection

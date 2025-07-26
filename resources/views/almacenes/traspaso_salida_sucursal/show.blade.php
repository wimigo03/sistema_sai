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
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('traspaso.salida.sucursal.index') }}"> Traspaso de materiales</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Detalle</li>
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
            <i class="fa-solid fa-eye fa-fw"></i>&nbsp;<b class="font-verdana-16">TRASPASO DE MATERIALES - SALIDA</b>
        </div>

        <div class="card-body">
            <form action="#" method="post" id="form">
                @csrf
                <input type="hidden" name="traspaso_almacen_id" value="{{ $traspaso_almacen->id }}" id="traspaso_almacen_id">
            </form>

            <div class="div_cabecera mb-2">
                <div class="card card-body">
                    <div class="row mb-2">
                        <div class="col-12 col-md-6 col-lg-2 mb-2">
                            <label for="show" class="form-label d-inline font-roboto-14">N°</label>
                            <input type="text" id="codigo" value="{{ $traspaso_almacen->codigo }}" class="form-control font-roboto-14" disabled>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-2">
                            <label for="origen" class="form-label d-inline font-roboto-14">Origen</label>
                            <input type="text" id="almacen_origen_id" value="{{ $traspaso_almacen->almacen_origen->nombre }}" class="form-control font-roboto-14" disabled>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mb-2">
                            <label for="destino" class="form-label d-inline font-roboto-14">Destino</label>
                            <input type="text" id="almacen_destino_id" value="{{ $traspaso_almacen->almacen_destino->nombre }}" class="form-control font-roboto-14" disabled>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2 mb-2">
                            <br>
                            <button class="btn btn-outline-danger w-100 w-md-auto py-2 mr-2 font-roboto-14 font-weight-bold" type="button" onclick="cancelar()";>
                                <i class="fas fa-times fa-fw"></i> Cancelar
                            </button>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12 mb-2">
                            <label for="obs" class="form-label d-inline font-roboto-14">Observaciones</label>
                            <textarea id="obs" class="form-control font-roboto-14" disabled>{{ $traspaso_almacen->obs }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div_detalle mb-4">
                <div class="row" style="display: flex; justify-content: space-between;">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                            @can('traspaso.sucursal.aprobar')
                                {{-- SI ESTA EN ESTADO GENERADO MOSTRAR BOTON DE APROBAR --}}
                                @if ($traspaso_almacen->estado == '1')
                                    <button class="btn btn-outline-success w-100 w-md-auto py-2 mr-2 font-roboto-14 font-weight-bold" type="button" onclick="aprobar();">
                                        <i class="fas fa-paper-plane fa-fw"></i> Aprobar
                                    </button>

                                    <button class="btn btn-outline-warning w-100 w-md-auto py-2 mr-2 font-roboto-14 font-weight-bold text-dark" type="button" onclick="rechazar();">
                                        <i class="fas fa-times fa-fw"></i> Rechazar
                                    </button>
                                @endif
                            @endcan
                        </div>
                        <div class="text-center mt-3">
                            <i class="fa fa-spinner fa-spin fa-lg spinner-btn" style="display: none;"></i>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3" id='total_fila'>
                        <div class="input-group">
                            <span class="input-group-text font-roboto-14 border-dark bg-dark"><b>TOTAL</b></span>
                            <input type='text' value="{{ 'Bs. ' . number_format($total,2,'.',',') }}" class='form-control font-roboto-15 border-dark' style="text-align: right; font-weight: bold;" disabled>
                        </div>
                    </div>
                </div>
                <div class="card card-body">
                    <div class="row mb-3">
                        <div class="col-12 table-responsive">
                            <table id="detalle_tabla" class="table table-striped table-hover display responsive hover-orange">
                                <thead class="bg-dark text-white">
                                    <tr class="font-roboto-13 ignore-row">
                                        <td class="text-center p-2 text-nowrap"><b>PROYECTO</b></td>
                                        <td class="text-center p-2 text-nowrap"><b>CODIGO</b></td>
                                        <td class="text-justify p-2 text-nowrap"><b>DETALLE</b></td>
                                        <td class="text-center p-2 text-nowrap"><b>UNIDAD</b></td>
                                        <td class="text-right p-2 text-nowrap"><b>INGRESO</b></td>
                                        <td class="text-right p-2 text-nowrap"><b>P. U.</b></td>
                                        <td class="text-right p-2 text-nowrap"><b>TOTAL</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($traspaso_almacen_detalles as $datos)
                                        @php
                                            $subtotal = $datos->cantidad * $datos->precio_unitario;
                                        @endphp
                                        <tr class="font-roboto-13">
                                            <td class="text-center p-2 text-nowrap">
                                                <span class="tts:right tts-slideIn tts-custom" aria-label="{{ $datos->categoria_programatica->nombre }}" style="cursor: pointer;">
                                                    {{ $datos->categoria_programatica->codigo }}
                                                </span>
                                            </td>
                                            <td class="text-center p-2 text-nowrap">
                                                {{ $datos->producto->codigo }}
                                            </td>
                                            <td class="text-justify p-2 text-nowrap" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $datos->producto->nombre }}
                                            </td>
                                            <td class="text-center p-2 text-nowrap">
                                                {{ $datos->producto->unidad_medida->alias }}
                                            </td>
                                            <td class="text-right p-2 text-nowrap" width='100px'>
                                                <input type='text' value="{{ $datos->cantidad }}" class='form-control font-roboto-14 text-right input-cantidad' readonly>
                                            </td>
                                            <td class="text-right p-2 text-nowrap" width='100px'>
                                                <input type='text' value="{{ $datos->precio_unitario }}" class='form-control font-roboto-14 text-right input-precio-unitario' readonly>
                                            </td>
                                            <td class="text-right p-2 text-nowrap" width='100px'>
                                                <input type='text' value="{{ number_format($subtotal, 2, '.', ',') }}" class='form-control font-roboto-13 text-right input-subtotal' readonly>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script type="text/javascript">
            $(document).ready(function() {

                $('.card').find('input, select, textarea, button').prop('disabled', true);

                var table = $('#detalle_tabla').DataTable({
                    "responsive": true,
                    //"stateSave": true,
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "_MENU_",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
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
                        $('.card').find('input, select, textarea, button').prop('disabled', false);
                    }
                });
            });

            var Modal = function(mensaje){
                $("#modal-alert .modal-body").html(mensaje);
                $('#modal-alert').modal({keyboard: false});
            }

            function aprobar() {
                if(!validarInputCantidadPrecio()){
                    return false;
                }

                $('#modal_confirmacion').modal({
                    keyboard: false
                })
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
                        Modal("Uno de los campos <br> <b>[INGRESO] O [PRECIO UNITARIO]</b> <br> no son validos");
                    } else {
                        $(this).find('.input-cantidad, .input-precio-unitario').removeClass('is-invalid');
                    }
                });

                return esValido;
            }

            function confirmar(){
                var submitButton = document.getElementById("confirmar");
                submitButton.disabled = true;
                submitButton.innerHTML = 'Procesando...';

                var url = "{{ route('traspaso.salida.sucursal.aprobar') }}";
                $("#form").attr('action', url);
                $("#form").submit();
            }

            function cancelar(){
                var url = "{{ route('ingreso.sucursal.index') }}";
                window.location.href = url;
            }

            function cancelar_balance(){
                var url = "{{ route('balance.inicial.index') }}";
                window.location.href = url;
            }
        </script>
    @endsection
@endsection

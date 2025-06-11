<!DOCTYPE html>
@extends('layouts.dashboard')
<style>
    .section-title {
        font-size: 1.25rem;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }

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
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('ingreso.sucursal.index') }}"> Ingresos de materiales</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Detalle</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fa-solid fa-file-lines fa-fw"></i>&nbsp;<b class="title-size">DETALLE REGISTRO DE @if($ingreso_almacen->codigo != 1) MATERIALES @else INVENTARIO @endif</b>
            </div>
        </div>

        <div class="card-body">
            <form action="#" method="post" id="form">
                @csrf
                <input type="hidden" name="ingreso_almacen_id" value="{{ $ingreso_almacen->id }}" id="ingreso_almacen_id">
            </form>

            <div class="div_cabecera mb-4">
                <div class="row mb-2">
                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <label for="" class="form-label d-inline font-roboto-14">Sucursal</label>
                        <input type="text" id="almacen_id" value="{{ $ingreso_almacen->almacen->nombre }}" class="form-control font-roboto-14" disabled>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        @isset($ingreso_almacen->area)
                            <label for="" class="form-label d-inline font-roboto-14">Solicitante</label>
                            <input type="text" id="area_id" value="{{ isset($ingreso_almacen->area) ? $ingreso_almacen->area->nombrearea : '' }}" class="form-control font-roboto-14" disabled>
                        @endisset
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <br>
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                            @can('ingreso.sucursal.ingresar')
                                {{-- SI ESTA EN ESTADO PENDIENTE MOSTRAR BOTON DE INGRESAR --}}
                                @if ($ingreso_almacen->estado == '1')
                                    <button class="btn btn-primary w-100 w-md-auto btn-size mr-1 mb-2 mb-md-0 font-roboto-14" type="button" onclick="procesar();">
                                        <i class="fas fa-paper-plane fa-fw"></i> Ingresar
                                    </button>
                                @endif
                            @endcan
                            <button class="btn btn-danger w-100 w-md-auto btn-size  mr-1 mb-2 mb-md-0 font-roboto-14" type="button" @if($ingreso_almacen->codigo != 1) onclick="cancelar();" @else onclick="cancelar_i();" @endif>
                                <i class="fas fa-times fa-fw"></i> Cancelar
                            </button>
                            @can('ingreso.sucursal.pdf')
                                <button class="btn btn-warning w-100 w-md-auto btn-size mr-1 mb-2 mb-md-0 font-roboto-14" type="button" onclick="pdf();">
                                    <i class="fas fa-print fa-fw"></i> Exportar
                                </button>
                            @endcan
                        </div>
                        <div class="text-center mt-3">
                            <i class="fa fa-spinner fa-spin fa-lg spinner-btn" style="display: none;"></i>
                        </div>
                    </div>
                    @if ($ingreso_almacen->codigo != 1)
                        <div class="col-12 col-md-6 col-lg-2 mb-2">
                            <label for="show" class="form-label d-inline font-roboto-14">N° Preventivo</label>
                            <input type="text" id="n_preventivo" value="{{ $ingreso_almacen->n_preventivo }}" class="form-control font-roboto-14" disabled>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2 mb-2">
                            <label for="show" class="form-label d-inline font-roboto-14">N° de O.C.</label>
                            <input type="text" id="n_orden_compra" value="{{ $ingreso_almacen->n_orden_compra }}" class="form-control font-roboto-14" disabled>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2 mb-2">
                            <label for="show" class="form-label d-inline font-roboto-14">N° de Solicitud</label>
                            <input type="text" id="n_solicitud" value="{{ $ingreso_almacen->n_solicitud }}" class="form-control font-roboto-14" disabled>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6 mb-2">
                            <label for="show" class="form-label d-inline font-roboto-14">Proveedor</label>
                            <input type="text" id="proveedor_id" value="{{ isset($ingreso_almacen->proveedor) ? $ingreso_almacen->proveedor->nombre : '' }}" class="form-control font-roboto-14" disabled>
                        </div>
                    @endif
                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <label for="show" class="form-label d-inline font-roboto-14">N° de Ingreso</label>
                        <input type="text" id="codigo" value="{{ $ingreso_almacen->codigo }}" class="form-control font-roboto-14" disabled>
                    </div>
                    <div class="col-12 col-md-6 col-lg-2 mb-2">
                        <label for="show" class="form-label d-inline font-roboto-14">Fecha de Registro</label>
                        <input type="text" id="fecha_registro" value="{{ $ingreso_almacen->created_at != null ? \Carbon\Carbon::parse($ingreso_almacen->created_at)->format('d-m-Y') : '' }}" class="form-control font-roboto-14" disabled>
                    </div>
                    <div class="col-12 col-md-6 col-lg-2 mb-2">
                        <label for="show" class="form-label d-inline font-roboto-14">Fecha de Ingreso</label>
                        <input type="text" id="fecha_ingreso" value="{{ $ingreso_almacen->fecha_ingreso != null ? \Carbon\Carbon::parse($ingreso_almacen->fecha_ingreso)->format('d-m-Y') : '' }}" class="form-control font-roboto-14" disabled>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-2">
                        <label for="glosa" class="form-label d-inline font-roboto-14">Glosa</label>
                        <textarea id="glosa" class="form-control font-roboto-14" disabled>{{ $ingreso_almacen->obs }}</textarea>
                    </div>
                    {{--<div class="col-12 col-md-6 col-lg-2 mb-2">
                        <label for="n_cotizacion" class="form-label d-inline font-roboto-14">N° Cotización</label>
                        <input type="text" name="n_cotizacion" id="n_cotizacion" value="{{ old('n_cotizacion') }}" class="form-control font-roboto-14">
                    </div>--}}
                    {{--<div class="col-12 col-md-6 col-lg-2 mb-2">
                        <label for="n_factura" class="form-label d-inline font-roboto-14">N° de Factura</label>
                        <input type="text" name="n_factura" id="n_factura" value="{{ old('n_factura') }}" class="form-control font-roboto-14">
                    </div>--}}
                </div>
            </div>

            <div class="div_detalle mb-4">
                <div class="row mb-3">
                    <div class="col-12 table-responsive">
                        <table id="detalle_tabla" class="table table-striped table-hover display responsive hover-orange">
                            <thead class="bg-dark text-white">
                                <tr class="font-roboto-13 ignore-row">
                                    <td class="text-center p-2 text-nowrap"><b>PROYECTO</b></td>
                                    <td class="text-center p-2 text-nowrap"><b>P. PRES.</b></td>
                                    <td class="text-center p-2 text-nowrap"><b>CODIGO</b></td>
                                    <td class="text-justify p-2 text-nowrap"><b>DETALLE</b></td>
                                    <td class="text-center p-2 text-nowrap"><b>UNIDAD</b></td>
                                    <td class="text-right p-2 text-nowrap"><b>INGRESO</b></td>
                                    <td class="text-right p-2 text-nowrap"><b>P. U.</b></td>
                                    <td class="text-right p-2 text-nowrap"><b>TOTAL</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ingreso_almacen_detalles as $datos)
                                    @php
                                        $subtotal = $datos->cantidad * $datos->precio_unitario;
                                        $total += $subtotal;
                                    @endphp
                                    <tr class="font-roboto-14">
                                        <td class="text-center p-2 text-nowrap">
                                            <span class="tts:right tts-slideIn tts-custom" aria-label="{{ $datos->categoria_programatica->nombre }}" style="cursor: pointer;">
                                                {{ $datos->categoria_programatica->codigo }}
                                            </span>
                                        </td>
                                        <td class="text-center p-2 text-nowrap">
                                            <span class="tts:right tts-slideIn tts-custom" aria-label="{{ $datos->partida_presupuestaria->nombre }}" style="cursor: pointer;">
                                                {{ $datos->partida_presupuestaria->numeracion }}
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
                                        <td class="text-right p-2 text-nowrap">
                                            {{ $datos->cantidad }}
                                        </td>
                                        <td class="text-right p-2 text-nowrap">
                                            {{ $datos->precio_unitario }}
                                        </td>
                                        <td class="text-right p-2 text-nowrap">
                                            {{ number_format($subtotal, 2, '.', ',') }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="font-roboto-14">
                                    <td class="text-right p-2 text-nowrap" colspan="7">
                                        <b>TOTAL</b>
                                    </td>
                                    <td class="text-right p-2 text-nowrap">
                                        <b>{{ number_format($total, 2, '.', ',') }}</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

        });

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
            var url = "{{ route('ingreso.sucursal.ingresar') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function pdf(){
            var id = $("#ingreso_almacen_id").val();
            var url = "{{ route('inventario.inicial.pdf',':id') }}";
            url = url.replace(':id',id);
            window.open(url, '_blank');
        }

        function cancelar(){
            var url = "{{ route('ingreso.sucursal.index') }}";
            window.location.href = url;
        }

        function cancelar_i(){
            var url = "{{ route('inventario.inicial.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection

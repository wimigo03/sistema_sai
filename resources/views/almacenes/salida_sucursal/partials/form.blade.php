<form action="#" method="post" id="form">
    @csrf
    @isset($salida_almacen)
        <input type="hidden" name="salida_almacen_id" id="salida_almacen_id" value="{{ $salida_almacen->id }}">
    @endisset
    <div class="div_cabecera mb-4">
        <div class="row mb-2">
            <div class="col-12 col-md-6 col-lg-4 mb-2">
                <label for="almacen_id" class="form-label d-inline font-roboto-14">Sucursal</label>
                <select name="almacen_id" id="almacen_id" class="form-control select2">
                    @foreach ($almacenes as $index => $value)
                        <option value="{{ $index }}"
                            @if (isset($salida_almacen) && $salida_almacen->almacen_id == $index)
                                selected
                            @elseif (old('almacen_id') == $index)
                                selected
                            @endif>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-2">
                <label for="area_id" class="form-label d-inline font-roboto-14">Solicitante</label>
                <select name="area_id" id="area_id" class="form-control select2">
                    <option value="">-</option>
                    @foreach ($areas as $index => $value)
                        <option value="{{ $index }}"
                            @if (isset($salida_almacen) && $salida_almacen->area_id == $index)
                                selected
                            @elseif (old('area_id') == $index)
                                selected
                            @endif>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-2">
                <br>
                <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                    <button class="btn btn-primary w-100 w-md-auto btn-size mr-1 mb-2 mb-md-0 font-roboto-14" type="button" onclick="procesar();">
                        <i class="fas fa-paper-plane fa-fw"></i> {{ isset($salida_almacen) ? 'Modificar Cambios' : 'Procesar' }}
                    </button>
                    <button class="btn btn-danger w-100 w-md-auto btn-size font-roboto-14" type="button" onclick="cancelar();">
                        <i class="fas fa-times fa-fw"></i> Cancelar
                    </button>
                </div>
                <div class="text-center mt-3">
                    <i class="fa fa-spinner fa-spin fa-lg spinner-btn" style="display: none;"></i>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-2 mb-2">
                <label for="n_solicitud" class="form-label d-inline font-roboto-14">N° de Solicitud</label>
                <input type="text" name="n_solicitud" id="n_solicitud" value="{{ isset($salida_almacen) ? $salida_almacen->n_solicitud : old('n_solicitud') }}" class="form-control font-roboto-14 intro">
            </div>
            <div class="col-12 col-md-6 col-lg-6 mb-2">
                <label for="proveedor_id" class="form-label d-inline font-roboto-14">Proveedor</label>
                <select name="proveedor_id" id="proveedor_id" class="form-control select2">
                    <option value="">-</option>
                    @foreach ($proveedores as $index => $value)
                        <option value="{{ $index }}"
                            @if (isset($salida_almacen) && $salida_almacen->proveedor_id == $index)
                                selected
                            @elseif (old('proveedor_id') == $index)
                                selected
                            @endif>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-2">
                <label for="codigo" class="form-label d-inline font-roboto-14">N° de Salida</label>
                <input type="text" name="codigo" id="codigo" value="{{ isset($salida_almacen) ? $salida_almacen->codigo : old('codigo') }}" class="form-control font-roboto-14 intro">
            </div>
            <div class="col-12 col-md-6 col-lg-2 mb-2">
                <label for="fecha_salida" class="form-label d-inline font-roboto-14">Fecha de Salida</label>
                <input type="text" name="fecha_salida" placeholder="dd-mm-yyyy" id="fecha_salida" value="{{ isset($salida_almacen) ? \Carbon\Carbon::parse($salida_almacen->fecha_salida)->format('d-m-Y') : old('fecha_salida') }}" class="form-control font-roboto-14 intro">
            </div>
            <div class="col-12 col-md-6 col-lg-12 mb-2">
                <label for="glosa" class="form-label d-inline font-roboto-14">Glosa</label>
                <textarea name="glosa" id="glosa" class="form-control font-roboto-14">{{ isset($salida_almacen) ? $salida_almacen->obs : old('glosa') }}</textarea>
            </div>
        </div>
    </div>

    <div class="div_detalle mb-4">
        <div class="row mb-2">
            <div class="col-12 col-md-6 col-lg-11 mb-2">
                <label for="categoria_programatica_id" class="form-label d-inline font-roboto-14">Categoria Programatica</label>
                <select name="categoria_programatica_id" id="categoria_programatica_id" class="form-control select2">
                    <option value="">-</option>
                    @foreach ($categorias_programaticas as $index => $value)
                        <option value="{{ $index }}" @if(old('categoria_programatica_id') == $index) selected @endif >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-1 mb-2">
                <br>
                <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                    <button class="btn btn-success w-100 w-md-auto btn-size mb-2 mb-md-0" type="button" onclick="agregarMaterial();">
                        <i class="fas fa-plus-square fa-lg"></i>
                    </button>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-2">
                <label for="partida_presupuestaria_id" class="form-label d-inline font-roboto-14">Partida Presupuestaria</label>
                <select id="partida_presupuestaria_id" name="partida_presupuestaria_id" class="form-control select2">
                    <option value="">--Seleccionar--</option>
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-2">
                <label for="producto_id" class="form-label d-inline font-roboto-14">Material</label>
                <select id="producto_id" name="producto_id" class="form-control select2">
                    <option value="">--Seleccionar--</option>
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-2 mb-2">
                <label for="stock_disponible" class="form-label d-inline font-roboto-14">Stock</label>
                <input type="text" id="stock_disponible" class="form-control font-roboto-14" readonly>
            </div>
            <div class="col-12 col-md-6 col-lg-2 mb-2">
                <label for="stock_precio_unitario" class="form-label d-inline font-roboto-14">P. U.</label>
                <input type="text" id="stock_precio_unitario" class="form-control font-roboto-14" readonly>
            </div>
        </div>

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
                            <td class="text-center p-2 text-nowrap"><b>EGRESO</b></td>
                            <td class="text-center p-2 text-nowrap"><b>P. U.</b></td>
                            <td class="text-center p-2 text-nowrap"><b>TOTAL</b></td>
                            <td class="text-center p-2 text-nowrap">
                                <b><i class="fa-solid fa-bars fa-fw"></i></b>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($salida_almacen_detalles)
                            @foreach ($salida_almacen_detalles as $datos)
                                @php
                                    $subtotal = $datos->cantidad * $datos->precio_unitario;
                                    $total += $subtotal;
                                @endphp
                                <tr class="font-roboto-14">
                                    <td style="display: none;">
                                        <input type="hidden" name="old_salida_almacen_detalle_id[]" value="{{ $datos->id }}">
                                    </td>
                                    <td class="text-center p-2 text-nowrap" style='vertical-align: middle;'>
                                        <input type="hidden" name="old_categoria_programatica_id[]" value="{{ $datos->categoria_programatica_id }}">
                                        <span class="tts:right tts-slideIn tts-custom" aria-label="{{ $datos->categoria_programatica->nombre }}" style="cursor: pointer;">
                                            {{ $datos->categoria_programatica->codigo }}
                                        </span>
                                    </td>
                                    <td class="text-center p-2 text-nowrap" style='vertical-align: middle;'>
                                        <input type="hidden" name="old_partida_presupuestaria_id[]" value="{{ $datos->partida_presupuestaria_id }}">
                                        <span class="tts:right tts-slideIn tts-custom" aria-label="{{ $datos->partida_presupuestaria->nombre }}" style="cursor: pointer;">
                                            {{ $datos->partida_presupuestaria->numeracion }}
                                        </span>
                                    </td>
                                    <td class="text-center p-2 text-nowrap" style='vertical-align: middle;'>
                                        <input type="hidden" name="old_producto_id[]" class="producto_id" value="{{ $datos->producto_id }}">
                                        {{ $datos->producto->codigo }}
                                    </td>
                                    <td class="text-justify p-2 text-nowrap" style="vertical-align: middle; max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $datos->producto->nombre }}
                                    </td>
                                    <td class="text-center p-2 text-nowrap" style='vertical-align: middle;'>
                                        {{ $datos->producto->unidad_medida->alias }}
                                    </td>
                                    <td class="text-right p-2 text-nowrap" width='100px'>
                                        <input type='text' value="{{ $datos->cantidad }}" name='old_cantidad[]' class='form-control font-roboto-14 text-right input-cantidad'>
                                    </td>
                                    <td class="text-right p-2 text-nowrap" width='100px'>
                                        <input type='text' value="{{ $datos->precio_unitario }}" name='old_precio_unitario[]' class='form-control font-roboto-14 text-right input-precio-unitario'>
                                    </td>
                                    <td class="text-right p-2 text-nowrap" width='100px'>
                                        <input type='text' value="{{ number_format($subtotal, 2, '.', ',') }}" placeholder='0' class='form-control font-roboto-14 text-right input-subtotal' disabled>
                                    </td>
                                    <td class="text-center p-2 text-nowrap" style="vertical-align: middle;">
                                        <span class='btn btn-sm btn-danger tts:left tts-slideIn tts-custom'
                                            style="cursor: pointer;"
                                            aria-label="Eliminar"
                                            onclick="if(confirm('¿Estás seguro? El registro se eliminara de manera inmediata')) { eliminarItem(this, {{ $datos->id }}); }">
                                            <i class='fas fa-trash fa-fw'></i>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                            {{--<tr class="font-roboto-14">
                                <td class="text-right p-2 text-nowrap" colspan="7">
                                    <b>TOTAL</b>
                                </td>
                                <td class="text-right p-2 text-nowrap">
                                    <b>{{ number_format($total, 2, '.', ',') }}</b>
                                </td>
                            </tr>--}}
                        @endisset
                    </tbody>
                    <tr id='total_fila' class='ignore-row' style="display: none">
                        <td colspan='7' class='text-right p-2 text-nowrap'><b>TOTAL</b></td>
                        <td class='text-right p-2 text-nowrap'><input type='text' class='form-control form-control-sm font-roboto-14 text-right' disabled></td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</form>

<form action="#" method="post" id="form">
    @csrf
    @isset($ingreso_almacen)
        <input type="hidden" name="ingreso_almacen_id" id="ingreso_almacen_id" value="{{ $ingreso_almacen->id }}">
    @endisset
    <div class="div_cabecera mb-4">
        {{--<div class="card card-body">--}}
            <div class="row mb-2">
                <div class="col-12 col-md-6 col-lg-4 mb-2">
                    <label for="almacen_id" class="form-label d-inline font-roboto-14">Sucursal</label>
                    <select name="almacen_id" id="almacen_id" class="form-control select2">
                        @foreach ($almacenes as $index => $value)
                            <option value="{{ $index }}"
                                @if (isset($ingreso_almacen) && $ingreso_almacen->almacen_id == $index)
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
                                @if (isset($ingreso_almacen) && $ingreso_almacen->area_id == $index)
                                    selected
                                @elseif (old('area_id') == $index)
                                    selected
                                @endif>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{--<div class="col-12 col-md-6 col-lg-4 mb-2">
                    <br>
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                        <button class="btn btn-primary w-100 w-md-auto btn-size mr-2 mb-2 mb-md-0 font-roboto-14" type="button" onclick="procesar();">
                            <i class="fas fa-paper-plane fa-fw"></i> {{ isset($ingreso_almacen) ? 'Modificar Cambios' : 'Procesar' }}
                        </button>
                        <button class="btn btn-danger w-100 w-md-auto btn-size font-roboto-14" type="button" onclick="cancelar();">
                            <i class="fas fa-times fa-fw"></i> Cancelar
                        </button>
                    </div>
                    <div class="text-center mt-3">
                        <i class="fa fa-spinner fa-spin fa-lg spinner-btn" style="display: none;"></i>
                    </div>
                </div>--}}
                <div class="col-12 col-md-6 col-lg-2 mb-2">
                    <label for="n_preventivo" class="form-label d-inline font-roboto-14">N° Preventivo</label>
                    <input type="text" name="n_preventivo" id="n_preventivo" value="{{ isset($ingreso_almacen) ? $ingreso_almacen->n_preventivo : old('n_preventivo') }}" class="form-control font-roboto-14 intro">
                </div>
                <div class="col-12 col-md-6 col-lg-2 mb-2">
                    <label for="n_orden_compra" class="form-label d-inline font-roboto-14">N° de O.C.</label>
                    <input type="text" name="n_orden_compra" id="n_orden_compra" value="{{ isset($ingreso_almacen) ? $ingreso_almacen-> n_orden_compra : old('n_orden_compra') }}" class="form-control font-roboto-14 intro">
                </div>
                <div class="col-12 col-md-6 col-lg-2 mb-2">
                    <label for="fecha_ingreso" class="form-label d-inline font-roboto-14">Fecha de Ingreso</label>
                    <input type="text" name="fecha_ingreso" placeholder="dd-mm-yyyy" id="fecha_ingreso" value="{{ isset($ingreso_almacen) ? \Carbon\Carbon::parse($ingreso_almacen->fecha_ingreso)->format('d-m-Y') : old('fecha_ingreso') }}" class="form-control font-roboto-14 intro">
                </div>
                <div class="col-12 col-md-6 col-lg-6 mb-2">
                    <label for="proveedor_id" class="form-label d-inline font-roboto-14">Proveedor</label>
                    <select name="proveedor_id" id="proveedor_id" class="form-control select2">
                        <option value="">-</option>
                        @foreach ($proveedores as $index => $value)
                            <option value="{{ $index }}"
                                @if (isset($ingreso_almacen) && $ingreso_almacen->proveedor_id == $index)
                                    selected
                                @elseif (old('proveedor_id') == $index)
                                    selected
                                @endif>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-2 mb-2">
                    <label for="codigo" class="form-label d-inline font-roboto-14">N° de Ingreso</label>
                    <input type="text" name="codigo" id="codigo" value="{{ isset($ingreso_almacen) ? $ingreso_almacen->codigo : old('codigo') }}" class="form-control font-roboto-14 intro">
                </div>
                <div class="col-12 col-md-6 col-lg-2 mb-2">
                    <label for="n_solicitud" class="form-label d-inline font-roboto-14">N° de Solicitud</label>
                    <input type="text" name="n_solicitud" id="n_solicitud" value="{{ isset($ingreso_almacen) ? $ingreso_almacen->n_solicitud : old('n_solicitud') }}" class="form-control font-roboto-14 intro">
                </div>
                <div class="col-12 col-md-6 col-lg-12 mb-2">
                    <label for="glosa" class="form-label d-inline font-roboto-14">Glosa</label>
                    <textarea name="glosa" id="glosa" class="form-control font-roboto-14">{{ isset($ingreso_almacen) ? $ingreso_almacen->obs : old('glosa') }}</textarea>
                </div>
            </div>
        {{--</div>--}}
    </div>

    @if (!isset($ingreso_almacen))
        <div class="row" style="display: flex; justify-content: space-between;">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                    <button class="btn btn-outline-primary w-100 w-md-auto py-2 mr-2 font-roboto-14 font-weight-bold" type="button" onclick="procesar();">
                        <i class="fas fa-paper-plane fa-fw"></i> Crear Comprobante de Ingreso
                    </button>
                    <button class="btn btn-outline-danger w-100 w-md-auto py-2 font-roboto-14 font-weight-bold" type="button" onclick="cancelar();">
                        <i class="fas fa-times fa-fw"></i> Cancelar
                    </button>
                </div>
                <div class="text-center mt-3">
                    <i class="fa fa-spinner fa-spin fa-lg spinner-btn" style="display: none;"></i>
                </div>
            </div>
        </div>
    @else
        <div class="div_detalle mb-4">
            <div class="card card-body">
                <div class="row mb-2">
                    <div class="col-12 col-md-6 col-lg-12 mb-2">
                        <label for="categoria_programatica_id" class="form-label d-inline font-roboto-14">Categoria Programatica</label>
                        <select name="categoria_programatica_id" id="categoria_programatica_id" class="form-control select2">
                            <option value="">-</option>
                            @foreach ($categorias_programaticas as $index => $value)
                                <option value="{{ $index }}" @if(old('categoria_programatica_id') == $index) selected @endif >{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-5 mb-2">
                        <label for="partida_presupuestaria_id" class="form-label d-inline font-roboto-14">Partida Presupuestaria</label>
                        <select id="partida_presupuestaria_id" name="partida_presupuestaria_id" class="form-control select2">
                            <option value="">--Seleccionar--</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-5 mb-2">
                        <label for="producto_id" class="form-label d-inline font-roboto-14">Material</label>
                        <select id="producto_id" name="producto_id" class="form-control select2">
                            <option value="">--Seleccionar--</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-2 mb-2">
                        <br>
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                            <button class="btn btn-success w-100 w-md-auto btn-size mb-2 mb-md-0" type="button" onclick="agregarMaterial();">
                                <i class="fas fa-plus-square fa-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="display: flex; justify-content: space-between;">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                        <button class="btn btn-outline-primary w-100 w-md-auto py-2 mr-2 font-roboto-14 font-weight-bold" type="button" onclick="procesar();">
                            <i class="fas fa-paper-plane fa-fw"></i> Finalizar
                        </button>
                    </div>
                    <div class="text-center mt-3">
                        <i class="fa fa-spinner fa-spin fa-lg spinner-btn" style="display: none;"></i>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3" id='total_fila'>
                    <div class="input-group">
                        <span class="input-group-text font-roboto-14 border-dark bg-dark"><b>TOTAL</b></span>
                        <span id="cantidad-registros" class="input-group-text font-roboto-14 border-dark bg-info"><b>{{ $ingreso_almacen_detalles_count }}</b></span>
                        <input type='text' value="{{ 'Bs. ' . number_format($old_total,2,'.',',') }}" class='form-control font-roboto-15 border-dark' style="text-align: right; font-weight: bold;" readonly>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3" style="display: flex; justify-content: flex-end;" id="custom-search">
                    <input type="search" id="_detalle_tabla_filter" class="form-control font-roboto-14 border-dark" placeholder="Buscar" aria-controls="detalle_tabla">
                </div>
            </div>

            <div class="card card-body">
                <div class="row mb-3">
                    <div class="col-12 table-responsive">
                        <table id="detalle_tabla" class="table table-striped table-hover display responsive hover-orange">
                            <thead class="bg-dark text-white">
                                <tr class="font-roboto-13 ignore-row">
                                    <td class="text-center p-2 text-nowrap"><b>PROYECTO</b></td>
                                    <td class="text-center p-2 text-nowrap"><b>P.P. - CODIGO</b></td>
                                    <td class="text-justify p-2 text-nowrap"><b>DETALLE</b></td>
                                    <td class="text-center p-2 text-nowrap"><b>UNIDAD</b></td>
                                    <td class="text-center p-2 text-nowrap"><b>INGRESO</b></td>
                                    <td class="text-center p-2 text-nowrap"><b>P. U.</b></td>
                                    <td class="text-center p-2 text-nowrap"><b>TOTAL</b></td>
                                    <td class="text-center p-2 text-nowrap">
                                        <b><i class="fa-solid fa-bars fa-fw"></i></b>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($ingreso_almacen_detalles)
                                    @foreach ($ingreso_almacen_detalles as $datos)
                                        @php
                                            $subtotal = $datos->cantidad * $datos->precio_unitario;
                                        @endphp
                                        <tr class="font-roboto-13">
                                            <td class="text-center p-2 text-nowrap" style='vertical-align: middle;'>
                                                <input type="hidden" class="categoria_programatica_id" value="{{ $datos->categoria_programatica_id }}">
                                                <input type="hidden" class="partida_presupuestaria_id" value="{{ $datos->partida_presupuestaria_id }}">
                                                <span class="tts:right tts-slideIn tts-custom" aria-label="{{ $datos->categoria_programatica->nombre ?? 'N/A' }}" style="cursor: pointer;">
                                                    {{ $datos->categoria_programatica->codigo ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="text-center p-2 text-nowrap" style='vertical-align: middle;'>
                                                <input type="hidden" class="producto_id" value="{{ $datos->producto_id }}">
                                                {{ $datos->producto->codigo ?? 'N/A' }}
                                            </td>
                                            <td class="text-justify p-2 text-nowrap" style="vertical-align: middle; max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $datos->producto->nombre ?? 'N/A' }}
                                            </td>
                                            <td class="text-center p-2 text-nowrap" style='vertical-align: middle;'>
                                                {{ $datos->producto->unidad_medida->alias ?? 'N/A' }}
                                            </td>
                                            <td class="text-right p-2 text-nowrap" width='100px'>
                                                <input type='text' value="{{ ($datos->cantidad == 0) ? '' : $datos->cantidad }}" placeholder='0' data-id="{{ $datos->id }}" class='form-control font-roboto-13 text-right input-cantidad {{ ($datos->cantidad == 0 || $datos->cantidad == null) ? 'is-invalid' : '' }}' oninput="cantidadPrecio(this);">
                                            </td>
                                            <td class="text-right p-2 text-nowrap" width='100px'>
                                                <input type='text' value="{{ ($datos->precio_unitario == 0) ? '' : $datos->precio_unitario }}" placeholder='0' data-id="{{ $datos->id }}" class='form-control font-roboto-13 text-right input-precio-unitario {{ ($datos->precio_unitario == 0 || $datos->precio_unitario == null) ? 'is-invalid' : '' }}' oninput="cantidadPrecio(this)">
                                            </td>
                                            <td class="text-right p-2 text-nowrap" width='100px'>
                                                <input type='text' value="{{ number_format($subtotal, 2, '.', ',') }}" placeholder='0' class='form-control font-roboto-13 text-right input-subtotal' readonly>
                                            </td>
                                            <td class="text-center p-2 text-nowrap" style="vertical-align: middle;">
                                                <span class='btn btn-sm btn-danger tts:left tts-slideIn tts-custom'
                                                    style="cursor: pointer;"
                                                    aria-label="Eliminar"
                                                    onclick="if(confirm('¿Estás seguro de que quieres eliminar el registro?')) { eliminarItem(this, {{ $datos->id }}); }">
                                                    <i class='fas fa-trash fa-fw'></i>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</form>

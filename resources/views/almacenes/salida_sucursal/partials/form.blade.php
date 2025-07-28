<form action="#" method="post" id="form">
    @csrf
    @isset($salida_almacen)
        <input type="hidden" name="salida_almacen_id" id="salida_almacen_id" value="{{ $salida_almacen->id }}">
    @endisset
    <div class="div_cabecera mb-4">
        <h6>
            <i class="fas fa-clipboard-list me-2"></i> <span class="red-color">Datos Generales</span>
        </h6>
        <hr class="hr-form my-2">

        <div class="row mb-2">
            <div class="col-6 mb-2">
                <label for="area_id" class="form-label d-inline font-roboto-14">Unidad Solicitante</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-users fa-fw"></i>
                    </span>
                    <select name="area_id" id="area_id" class="form-control select2 select2-height-match-form-control">
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
            </div>
            <div class="col-6 mb-2">
                <label for="solicitante_id" class="form-label d-inline font-roboto-14">Personal Solicitante</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-user fa-fw"></i>
                    </span>
                    <select name="solicitante_id" id="solicitante_id" class="form-control select2 select2-height-match-form-control">
                        <option value="">-</option>
                        @foreach ($empleados_solicitantes as $index => $value)
                            <option value="{{ $index }}"
                                @if (isset($salida_almacen) && $salida_almacen->solicitante_id == $index)
                                    selected
                                @elseif (old('solicitante_id') == $index)
                                    selected
                                @endif>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12 col-md-6 col-lg-3 mb-2">
                <label for="almacen_id" class="form-label d-inline font-roboto-14">Sucursal</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-house fa-fw"></i>
                    </span>
                    <select name="almacen_id" id="almacen_id" class="form-control select2 select2-height-match-form-control">
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
            </div>
            <div class="col-12 col-md-6 col-lg-2 mb-2">
                <label for="codigo" class="form-label d-inline font-roboto-14">N° de Salida</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa-solid fa-barcode fa-fw"></i>
                    </span>
                    <input type="text" name="codigo" id="codigo" value="{{ isset($salida_almacen) ? $salida_almacen->codigo : old('codigo') }}" class="form-control font-roboto-14 intro">
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-2 mb-2">
                <label for="n_solicitud" class="form-label d-inline font-roboto-14">N° de Solicitud</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa-solid fa-file-invoice fa-fw"></i>
                    </span>
                    <input type="text" name="n_solicitud" id="n_solicitud" value="{{ isset($salida_almacen) ? $salida_almacen->n_solicitud : old('n_solicitud') }}" class="form-control font-roboto-14 intro">
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-2 mb-2">
                <label for="fecha_salida" class="form-label d-inline font-roboto-14">Fecha de Salida</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa-solid fa-calendar-alt fa-fw"></i>
                    </span>
                    <input type="text" name="fecha_salida" placeholder="dd-mm-yyyy" id="fecha_salida" value="{{ isset($salida_almacen) ? \Carbon\Carbon::parse($salida_almacen->fecha_salida)->format('d-m-Y') : old('fecha_salida') }}" class="form-control font-roboto-14 intro">
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-2">
                <label for="proveedor_id" class="form-label d-inline font-roboto-14">Proveedor</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-truck fa-fw"></i>
                    </span>
                    <select name="proveedor_id" id="proveedor_id" class="form-control select2 select2-height-match-form-control">
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
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12 col-md-6 col-lg-12">
                <label for="glosa" class="form-label d-inline font-roboto-14">Glosa</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa-solid fa-file-alt fa-fw"></i>
                    </span>
                    <textarea name="glosa" id="glosa" class="form-control font-roboto-14">{{ isset($salida_almacen) ? $salida_almacen->obs : old('glosa') }}</textarea>
                </div>
            </div>
        </div>
    </div>
    <br>

    @if (!isset($salida_almacen))
        <div class="row" style="display: flex; justify-content: space-between;">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                    <button class="btn btn-outline-primary w-100 w-md-auto py-2 mr-2 font-roboto-14 font-weight-bold" type="button" onclick="procesar();">
                        <i class="fas fa-paper-plane fa-fw"></i> Crear Comprobante de Salida
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
                <h6>
                    <i class="fas fa-list-ul me-2"></i> <span class="red-color">Registro de Detalles</span>
                </h6>
                <hr class="hr-form my-2">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12 mb-2">
                        <label for="categoria_programatica_id" class="form-label d-inline font-roboto-14">Categoria Programatica</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-project-diagram fa-fw"></i>
                            </span>
                            <select name="categoria_programatica_id" id="categoria_programatica_id" class="form-control select2">
                                <option value="">-</option>
                                @foreach ($categorias_programaticas as $index => $value)
                                    <option value="{{ $index }}" @if(old('categoria_programatica_id') == $index) selected @endif >{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label for="partida_presupuestaria_id" class="form-label d-inline font-roboto-14">Partida Presupuestaria</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-chart-pie fa-fw"></i>
                            </span>
                            <select id="partida_presupuestaria_id" name="partida_presupuestaria_id" class="form-control select2">
                                <option value="">--Seleccionar--</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <label for="producto_id" class="form-label d-inline font-roboto-14">Material</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-box-open fa-fw"></i>
                            </span>
                            <select id="producto_id" name="producto_id" class="form-control select2">
                                <option value="">--Seleccionar--</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <br>
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                            <button class="btn btn-secondary w-100 w-md-auto btn-size mb-2 mb-md-0 font-roboto-14" type="button" onclick="cargarMateriales();" id="btnCargarMateriales">
                                <i class="fas fa-database fa-fw"></i> Cargar Materiales Existentes
                            </button>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-2 mb-2">
                        <input type="hidden" id="inventario_almacen_id">
                        <label for="stock_actual" class="form-label d-inline font-roboto-14">Disponible</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-check-circle fa-fw"></i>
                            </span>
                            <input type="text" id="stock_actual" class="form-control font-roboto-14 bg-dark">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-2 mb-2">
                        <label for="stock_reserva" class="form-label d-inline font-roboto-14">Reserva</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-hourglass-half fa-fw"></i>
                            </span>
                            <input type="text" id="stock_reserva" class="form-control font-roboto-14 bg-dark">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 mb-2">
                        <br>
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                            <button class="btn btn-outline-success w-100 w-md-auto btn-size mb-2 mb-md-0 font-roboto-14" type="button" onclick="agregarMaterial();">
                                <i class="fas fa-plus-circle fa-fw"></i> Agregar Material al Comprobante
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-body">
                <div class="row" style="display: flex; justify-content: space-between;">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                            <button class="btn btn-primary w-100 w-md-auto py-2 mr-2 font-roboto-14 font-weight-bold" type="button" onclick="procesar();">
                                <i class="fas fa-check-circle fa-fw"></i> Finalizar Registro de Materiales
                            </button>
                        </div>
                        <div class="text-center mt-3">
                            <i class="fa fa-spinner fa-spin fa-lg spinner-btn" style="display: none;"></i>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3" id='total_fila'>
                        <div class="input-group">
                            <span class="input-group-text font-roboto-14 border-dark bg-dark"><b>TOTAL</b></span>
                            <span id="cantidad-registros" class="input-group-text font-roboto-14 border-dark bg-info"><b>{{ $salida_almacen_detalles_count }}</b></span>
                            <input type='text' value="{{ 'Bs. ' . number_format($old_total,2,'.',',') }}" class='form-control font-roboto-15 border-dark' style="text-align: right; font-weight: bold;" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3" style="display: flex; justify-content: flex-end;" id="custom-search">
                        <input type="search" id="_detalle_tabla_filter" class="form-control font-roboto-14 border-dark" placeholder="Buscar" aria-controls="detalle_tabla">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 table-responsive">
                        <h6>
                            <i class="fas fa-boxes me-2"></i>  <span class="red-color">Materiales Registrados</span>
                        </h6>
                        <table id="detalle_tabla" class="table table-striped table-hover display responsive hover-orange">
                            <thead class="bg-dark text-white">
                                <tr class="font-roboto-13 ignore-row">
                                    <td class="text-center p-2 text-nowrap"><b>PROYECTO</b></td>
                                    <td class="text-center p-2 text-nowrap"><b>P.P. - CODIGO</b></td>
                                    <td class="text-justify p-2 text-nowrap"><b>DETALLE</b></td>
                                    <td class="text-center p-2 text-nowrap"><b>UNIDAD</b></td>
                                    <td class="text-center p-2 text-nowrap"><b>DISPONIBLE</b></td>
                                    <td class="text-center p-2 text-nowrap"><b>RESERVA</b></td>
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
                                        @endphp
                                        <tr class="font-roboto-13">
                                            <td class="text-center p-2 text-nowrap" style='vertical-align: middle;'>
                                                <input type="hidden" data-id="{{ $datos->id }}" class="input-inventario-almacen-id" name="inventario_almacen_id[]" value="{{ $datos->stock_disponible['inventario_almacen_id'] }}">
                                                <input type="hidden" class="categoria_programatica_id" name='categoria_programatica_id[]' value="{{ $datos->categoria_programatica_id }}">
                                                <input type="hidden" class="partida_presupuestaria_id" name='partida_presupuestaria_id[]' value="{{ $datos->partida_presupuestaria_id }}">
                                                <span class="tts:right tts-slideIn tts-custom" aria-label="{{ $datos->categoria_programatica->nombre ?? 'N/A' }}" style="cursor: pointer;">
                                                    {{ $datos->categoria_programatica->codigo ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="text-center p-2 text-nowrap" style='vertical-align: middle;'>
                                                <input type="hidden" class="producto_id" name='producto_id[]' value="{{ $datos->producto_id }}">
                                                {{ $datos->producto->codigo ?? 'N/A' }}
                                            </td>
                                            <td class="text-justify p-2 text-nowrap" style="vertical-align: middle; max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $datos->producto->nombre ?? 'N/A' }}
                                            </td>
                                            <td class="text-center p-2 text-nowrap" style='vertical-align: middle;'>
                                                {{ $datos->producto->unidad_medida->alias ?? 'N/A' }}
                                            </td>
                                            <td class="text-right p-2 text-nowrap" width='100px'>
                                                <input type='hidden' value="{{ $datos->stock_disponible['cantidad_actual'] }}" placeholder='0' data-id="{{ $datos->id }}" class='form-control font-roboto-13 text-right input-stock-actual-anterior'>
                                                <input type='text' value="{{ $datos->stock_disponible['cantidad_actual'] }}" placeholder='0' data-id="{{ $datos->id }}" class='form-control font-roboto-13 text-right input-stock-actual' disabled>
                                            </td>
                                            <td class="text-right p-2 text-nowrap" width='100px'>
                                                <input type='hidden' value="{{ $datos->stock_disponible['cantidad_reserva'] }}" placeholder='0' data-id="{{ $datos->id }}" class='form-control font-roboto-13 text-right input-stock-reserva-anterior' disabled>
                                                <input type='text' value="{{ $datos->stock_disponible['cantidad_reserva'] }}" placeholder='0' data-id="{{ $datos->id }}" class='form-control font-roboto-13 text-right input-stock-reserva' disabled>
                                            </td>
                                            <td class="text-right p-2 text-nowrap" width='100px'>
                                                <input type='hidden' value="{{ ($datos->cantidad == 0) ? '' : $datos->cantidad }}" placeholder='0' data-id="{{ $datos->id }}" class='form-control font-roboto-13 text-right input-cantidad-anterior'>
                                                <input type='text' name="cantidad[]" value="{{ ($datos->cantidad == 0) ? '' : $datos->cantidad }}" placeholder='0' data-id="{{ $datos->id }}" class='form-control font-roboto-13 text-right input-cantidad {{ ($datos->cantidad == 0 || $datos->cantidad == null) ? 'is-invalid' : '' }}' onblur="cantidadPrecio(this);">
                                            </td>
                                            <td class="text-right p-2 text-nowrap" width='100px'>
                                                <input type='text' value="{{ ($datos->precio_unitario == 0) ? '' : $datos->precio_unitario }}" placeholder='0' data-id="{{ $datos->id }}" class='form-control font-roboto-13 text-right input-precio-unitario {{ ($datos->precio_unitario == 0 || $datos->precio_unitario == null) ? 'is-invalid' : '' }}' onblur="cantidadPrecio(this)">
                                            </td>
                                            <td class="text-right p-2 text-nowrap" width='100px'>
                                                <input type='hidden' value="{{ number_format($subtotal, 2, '.', ',') }}" placeholder='0' class='form-control font-roboto-13 text-right input-subtotal-anterior'>
                                                <input type='text' value="{{ number_format($subtotal, 2, '.', ',') }}" placeholder='0' class='form-control font-roboto-13 text-right input-subtotal' readonly>
                                            </td>
                                            <td class="text-center p-2 text-nowrap" style="vertical-align: middle;">
                                                <span class='btn btn-sm btn-danger tts:left tts-slideIn tts-custom'
                                                    style="cursor: pointer;"
                                                    aria-label="Eliminar"
                                                    onclick="if(confirm('¿Estás seguro de que quieres eliminar el registro?')) { eliminarItem(this,
                                                                                                                                            {{ $datos->id }},
                                                                                                                                            {{ $datos->stock_disponible['inventario_almacen_id'] }},
                                                                                                                                            {{ $datos->cantidad }}
                                                                                                                                            ); }">
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

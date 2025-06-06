<form action="#" method="post" id="form">
    @csrf
    <div class="div_cabecera mb-4">
        <div class="row mb-2">
            <div class="col-12 col-md-6 col-lg-4 mb-2">
                <label for="almacen_id" class="form-label d-inline font-roboto-14">Sucursal</label>
                <select name="almacen_id" id="almacen_id" class="form-control select2">
                    {{--<option value="">-</option>--}}
                    @foreach ($almacenes as $index => $value)
                        <option value="{{ $index }}" @if(old('almacen_id') == $index) selected @endif >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-2">
                <label for="area_id" class="form-label d-inline font-roboto-14">Solicitante</label>
                <select name="area_id" id="area_id" class="form-control select2">
                    <option value="">-</option>
                    @foreach ($areas as $index => $value)
                        <option value="{{ $index }}" @if(old('area_id') == $index) selected @endif >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-2">
                <br>
                <div class="d-flex flex-column flex-md-row gap-3 justify-content-center justify-content-md-end">
                    <button class="btn btn-primary w-100 w-md-auto btn-size mr-2 mb-2 mb-md-0" type="button" onclick="procesar();">
                        <i class="fas fa-paper-plane fa-fw"></i> Procesar
                    </button>
                    <button class="btn btn-danger w-100 w-md-auto btn-size" type="button" onclick="cancelar();">
                        <i class="fas fa-times fa-fw"></i> Cancelar
                    </button>
                </div>
                <div class="text-center mt-3">
                    <i class="fa fa-spinner fa-spin fa-lg spinner-btn" style="display: none;"></i>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-2 mb-2">
                <label for="n_preventivo" class="form-label d-inline font-roboto-14">N° Preventivo</label>
                <input type="text" name="n_preventivo" id="n_preventivo" value="{{ old('n_preventivo') }}" class="form-control font-roboto-14">
            </div>
            <div class="col-12 col-md-6 col-lg-2 mb-2">
                <label for="n_orden_compra" class="form-label d-inline font-roboto-14">N° de O.C.</label>
                <input type="text" name="n_orden_compra" id="n_orden_compra" value="{{ old('n_orden_compra') }}" class="form-control font-roboto-14">
            </div>
            <div class="col-12 col-md-6 col-lg-2 mb-2">
                <label for="n_solicitud" class="form-label d-inline font-roboto-14">N° de Solicitud</label>
                <input type="text" name="n_solicitud" id="n_solicitud" value="{{ old('n_solicitud') }}" class="form-control font-roboto-14">
            </div>
            <div class="col-12 col-md-6 col-lg-6 mb-2">
                <label for="proveedor_id" class="form-label d-inline font-roboto-14">Proveedor</label>
                <select name="proveedor_id" id="proveedor_id" class="form-control select2">
                    <option value="">-</option>
                    @foreach ($proveedores as $index => $value)
                        <option value="{{ $index }}" @if(old('proveedor_id') == $index) selected @endif >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-2">
                <label for="codigo" class="form-label d-inline font-roboto-14">N° de Ingreso</label>
                <input type="text" name="codigo" id="codigo" value="{{ old('codigo') }}" class="form-control font-roboto-14">
            </div>
            <div class="col-12 col-md-6 col-lg-2 mb-2">
                <label for="fecha_ingreso" class="form-label d-inline font-roboto-14">Fecha de Ingreso</label>
                <input type="text" name="fecha_ingreso" placeholder="dd-mm-yyyy" id="fecha_ingreso" value="{{ isset($ingreso_almacen) ? \Carbon\Carbon::parse($curso->start)->format('d-m-Y') : old('fecha_ingreso') }}" class="form-control font-roboto-14">
            </div>
            <div class="col-12 col-md-6 col-lg-12 mb-2">
                <label for="glosa" class="form-label d-inline font-roboto-14">Glosa</label>
                <textarea name="glosa" id="glosa" class="form-control font-roboto-14">{{ old('glosa') }}</textarea>
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
                            <td class="text-center p-2 text-nowrap"><b>INGRESO</b></td>
                            <td class="text-center p-2 text-nowrap"><b>P. U.</b></td>
                            <td class="text-center p-2 text-nowrap"><b>TOTAL</b></td>
                            <td class="text-center p-2 text-nowrap">
                                <b><i class="fa-solid fa-bars fa-fw"></i></b>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>

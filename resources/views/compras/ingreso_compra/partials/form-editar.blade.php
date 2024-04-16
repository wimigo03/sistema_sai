<div class="card-body body">
    <form action="#" method="post" id="form">
        @csrf
        <input type="hidden" name="dea_id" value="{{ $orden_compra->dea_id }}">
        <input type="hidden" name="orden_compra_id" value="{{ $orden_compra->id }}">
        <div class="form-group row font-roboto-13">
            <div class="col-md-5 pr-1 pl-1">
                <label for="area_solicitante" class="d-inline"><b>Unidad Solicitante</b></label>
                <input type="text" value="{{ $orden_compra->area->nombrearea }}" id="area_solicitante" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-3 pr-1 pl-1">
                <label for="user" class="d-inline"><b>Solicitante</b></label>
                <input type="text" value="{{ strtoupper($orden_compra->solicitante->name) }}" id="user" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="fecha_registro" class="d-inline"><b>F. Registro</b></label>
                <input type="text" value="{{ \Carbon\Carbon::parse($orden_compra->fecha_registro)->format('d/m/Y') }}" id="fecha_registro" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="nro_oc" class="d-inline"><b>Codigo</b></label>
                <input type="text" value="{{ $orden_compra->codigo }}" id="nro_oc" class="form-control font-roboto-12" disabled>
            </div>
        </div>
        <div class="form-group row font-roboto-13">
            <div class="col-md-2 pr-1 pl-1">
                <label for="nro_solicitud" class="d-inline"><b>Codigo Solicitud</b></label>
                <input type="text" value="{{ $orden_compra->solicitud_compra->codigo }}" id="nro_solicitud" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-4 pr-1 pl-1">
                <label for="almacen" class="d-inline"><b>Almacen</b></label>
                <input type="text" value="{{ $orden_compra->almacen != null ? $orden_compra->almacen->nombre : '' }}" id="almacen" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="tipo" class="d-inline"><b>Tipo</b></label>
                <input type="text" value="{{ $orden_compra->tipos }}" id="tipo" class="form-control font-roboto-12" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="c_interno" class="d-inline"><b>N° Control Interno</b></label>
                <input type="text" name="c_interno" value="{{ old('c_interno') }}" id="c_interno" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="col-md-2 pr-1 pl-1">
                <label for="nro_preventivo" class="d-inline"><b>N° Preventivo</b></label>
                <input type="text" name="nro_preventivo" value="{{ old('nro_preventivo') }}" id="nro_preventivo" class="form-control font-roboto-12" oninput="this.value = this.value.toUpperCase();">
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-4 pr-1 pl-1">
                <label for="categoria_programatica" class="d-inline"><b>Categoria Programatica</b></label>
                <select name="categoria_programatica_id" id="categoria_programatica_id" class="form-control select2">
                    <option value="">-</option>
                    @foreach ($categorias_programaticas as $categoria_programatica)
                        <option value="{{ $categoria_programatica->id }}"
                            @if($categoria_programatica->id == old('categoria_programatica_id') || (isset($orden_compra) && $orden_compra->categoria_programatica_id == $categoria_programatica->id))
                                selected
                            @endif>
                            {{ $categoria_programatica->categoria }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 pr-1 pl-1">
                <label for="programa" class="d-inline"><b>Programa</b></label>
                <select name="programa_id" id="programa_id" class="form-control select2">
                    <option value="">-</option>
                    @foreach ($programas as $programa)
                        <option value="{{ $programa->id }}"
                            @if($programa->id == old('programa_id') || (isset($orden_compra) && $orden_compra->programa_id == $programa->id))
                                selected
                            @endif>
                            {{ $programa->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 pr-1 pl-1">
                <label for="proveedor" class="d-inline"><b>Proveedor</b></label>
                <select name="proveedor_id" id="proveedor_id" class="form-control select2">
                    <option value="">-</option>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}"
                            @if($proveedor->id == old('proveedor_id') || (isset($orden_compra) && $orden_compra->proveedor_id == $proveedor->id))
                                selected
                            @endif>
                            {{ $proveedor->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-6 pr-1 pl-1">
                <label for="objeto" class="d-inline"><b>Objeto</b></label>
                <textarea name="objeto" class="form-control font-roboto-12" id="objeto" oninput="this.value = this.value.toUpperCase();">{{ $orden_compra->objeto }}</textarea>
            </div>
            <div class="col-md-6 pr-1 pl-1">
                <label for="justificacion" class="d-inline"><b>Justificacion</b></label>
                <textarea name="justificacion" class="form-control font-roboto-12" id="justificacion" oninput="this.value = this.value.toUpperCase();">{{ $orden_compra->justificacion }}</textarea>
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-12 pr-1 pl-1">
                <div class="card">
                    <div class="card-header text-center">
                        <strong><u>DETALLE DE LA ORDEN DE COMPRA</u></strong>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12 pr-1 pl-1 table-responsive">
                                <table id="detalle_tabla" class="table display table-bordered responsive hover-orange" style="width:100%;">
                                    <thead>
                                        <tr class="font-roboto-12">
                                            <th class="text-center p-1">P. PRESUPUESTARIA</th>
                                            <th class="text-center p-1">ITEM</th>
                                            <th class="text-center p-1">MEDIDA</th>
                                            <th class="text-center p-1">CANTIDAD</th>
                                            <th class="text-center p-1">PRECIO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orden_compra_detalles as $datos)
                                            <tr class="font-roboto-12">
                                                <td class="text-left p-1">{{ $datos->partida->nombre }}</td>
                                                <td class="text-left p-1">{{ $datos->item->nombre }}</td>
                                                <td class="text-left p-1">{{ $datos->unidad_medida->nombre }}</td>
                                                <td class="text-right p-1">{{ number_format($datos->cantidad,2,'.',',') }}</td>
                                                <td class="text-right p-1">{{ number_format($datos->precio,2,'.',',') }}</td>
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
        <div class="form-group row">
            <div class="col-md-12 pr-1 text-right">
                <button class="btn btn-outline-primary font-roboto-12" id="btn-registro" type="button" onclick="procesar();">
                    <i class="fas fa-paper-plane fa-fw"></i> Actualizar
                </button>
                <button class="btn btn-outline-danger font-roboto-12" type="button" onclick="cancelar();">
                    <i class="fas fa-times fa-fw"></i> Cancelar
                </button>
                <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
            </div>
        </div>
    </form>
</div>

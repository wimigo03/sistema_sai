<div class="card-body body">
    <form action="#" method="post" id="form">
        @csrf
        <input type="hidden" name="orden_compra_id" value="{{ $orden_compra->id }}">
        <div class="row font-roboto-12">
            <div class="col-md-7 pr-1 pl-1 mb-2">
                <label for="area_solicitante" class="d-inline"><b>Unidad Solicitante</b></label>
                <input type="text" value="{{ $orden_compra->area->nombrearea }}" id="area_solicitante" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-3 pr-1 pl-1 mb-2">
                <label for="user" class="d-inline"><b>Solicitante</b></label>
                <input type="text" value="{{ strtoupper($orden_compra->solicitante->name) }}" id="user" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1 mb-2">
                <label for="fecha_registro" class="d-inline"><b>Registro</b></label>
                <input type="text" value="{{ \Carbon\Carbon::parse($orden_compra->fecha_registro)->format('d/m/Y') }}" id="fecha_registro" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1 mb-2">
                <label for="nro_oc" class="d-inline"><b>Nro. O.C.</b></label>
                <input type="text" value="{{ $orden_compra->codigo }}" id="nro_oc" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1 mb-2">
                <label for="nro_solicitud" class="d-inline"><b>Nro. Solicitud</b></label>
                <input type="text" value="{{ $orden_compra->solicitud_compra->codigo }}" id="nro_solicitud" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-4 pr-1 pl-1 mb-2">
                <label for="almacen" class="d-inline"><b>Almacen</b></label>
                <input type="text" value="{{ $orden_compra->almacen != null ? $orden_compra->almacen->nombre : '' }}" id="almacen" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1 mb-2">
                <label for="tipo" class="d-inline"><b>Tipo</b></label>
                <input type="text" value="{{ $orden_compra->tipos }}" id="tipo" class="form-control font-roboto-11" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1 mb-2">
                <label for="estado" class="d-inline"><b>Estado</b></label>
                <input type="text" value="{{ $orden_compra->status }}" id="estado" class="form-control font-roboto-11 {{ $orden_compra->colorInputStatus}}" disabled>
            </div>
            <div class="col-md-2 pr-1 pl-1 mb-2">
                <label for="c_interno" class="d-inline"><b>N° Control Interno</b></label>
                <input type="text" name="c_interno" value="{{ $orden_compra->c_interno }}" id="c_interno" class="form-control font-roboto-11" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="col-md-2 pr-1 pl-1 mb-2">
                <label for="nro_preventivo" class="d-inline"><b>N° Preventivo</b></label>
                <input type="text" name="nro_preventivo" value="{{ $orden_compra->nro_preventivo }}" id="nro_preventivo" class="form-control font-roboto-11" oninput="this.value = this.value.toUpperCase();">
            </div>
            <div class="col-md-4 pr-1 pl-1 mb-2">
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
            <div class="col-md-12 pr-1 pl-1 mb-2">
                <label for="objeto" class="d-inline"><b>Objeto</b></label>
                <textarea name="objeto" class="form-control font-roboto-11" id="objeto" oninput="this.value = this.value.toUpperCase();">{{ $orden_compra->objeto }}</textarea>
            </div>
            <div class="col-md-12 pr-1 pl-1 mb-2">
                <label for="justificacion" class="d-inline"><b>Justificacion</b></label>
                <textarea name="justificacion" class="form-control font-roboto-11" id="justificacion" oninput="this.value = this.value.toUpperCase();">{{ $orden_compra->justificacion }}</textarea>
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
                                        <tr class="font-roboto-11">
                                            <th class="text-left p-1">PROGRAMATICA</th>
                                            <th class="text-left p-1">PARTIDA PRESUPUESTARIA</th>
                                            <th class="text-left p-1">MATERIAL</th>
                                            <th class="text-center p-1">MEDIDA</th>
                                            <th class="text-right p-1">CANTIDAD</th>
                                            <th class="text-right p-1">PRECIO</th>
                                            <th class="text-right p-1">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orden_compra_detalles as $datos)
                                            <tr class="detalle-{{ $datos->id }} font-roboto-11">
                                                <td class="text-left p-1" style="vertical-align: middle;">{{ $datos->programatica->codigo }}</td>
                                                <td class="text-left p-1" style="vertical-align: middle;">{{ $datos->partidaPresupuestaria->numeracion . ' - ' . $datos->partidaPresupuestaria->nombre }}</td>
                                                <td class="text-left p-1" style="vertical-align: middle;">{{ $datos->item->nombre }}</td>
                                                <td class="text-center p-1" style="vertical-align: middle;">{{ $datos->unidad_medida->nombre }}</td>
                                                <td class="text-right p-1" style="vertical-align: middle;">
                                                    <input type="hidden" name="cantidad[]" value="{{ $datos->cantidad }}" class="input-cantidad">
                                                    {{ number_format($datos->cantidad,2,'.',',') }}
                                                </td>
                                                <td class="text-right p-1" width="100px">
                                                    <input type="hidden" name="orden_compra_detalle_id[]" value="{{ $datos->id }}">
                                                    <input type="text" name="precio[]" value="{{ number_format($datos->precio,2,'.',',') }}" class="form-control form-control-sm font-roboto-11 text-right input-precio" onKeyUp="Calcular({{ $datos->id }})">
                                                </td>
                                                <td class="font-roboto-11 text-right p-1" width="100px">
                                                    <input type="text" value="{{ number_format($datos->cantidad * $datos->precio,2,'.',',') }}" class="form-control form-control-sm font-roboto-11 text-right input-total" readonly>
                                                </td>
                                            </tr>
                                            @php
                                                $total = $total + ($datos->cantidad * $datos->precio);
                                            @endphp
                                        @endforeach
                                        <tr class="font-roboto-11">
                                            <td colspan="6" class="text-right p-1" style="vertical-align: middle;">
                                                <b>TOTAL</b>
                                            </td>
                                            <td class="text-right p-1">
                                                <input type="text" value="{{ number_format($total,2,'.',',') }}" id="input-total-final" class="form-control form-control-sm font-roboto-11 text-right" readonly>
                                            </td>
                                        </tr>
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
                    <i class="fas fa-paper-plane fa-fw"></i> Procesar
                </button>
                <button class="btn btn-outline-danger font-roboto-12" type="button" onclick="cancelar();">
                    <i class="fas fa-times fa-fw"></i> Cancelar
                </button>
                <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
            </div>
        </div>
    </form>
</div>

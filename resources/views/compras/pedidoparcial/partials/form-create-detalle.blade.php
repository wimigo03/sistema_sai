<div class="form-group row font-verdana-bg">
    <div class="col-md-8">
        <label for="producto" class="d-inline">Producto</label>
        <select id="producto" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
            <option value="">-</option>
            @foreach ($productos as $index => $value)
                <option value="{{ $index }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <label for="cantidad" class="d-inline">Cantidad</label>
        <input type="text" id="cantidad" class="form-control form-control-sm font-verdana text-right" onkeypress="return valideNumber(event);">
    </div>
    <div class="col-md-2 text-right">
        <br>
        <span class="tts:left tts-slideIn tts-custom" aria-label="Adicionar detalle">
            <button type="button" class="btn btn-outline-success btn-sm" onclick="agregarMaterial();">
                &nbsp;<i class="fa fa-lg fa-plus-circle"></i>&nbsp;
            </button>
        </span>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-12 table-responsive">
        <table id="detalle_tabla" class="table display table-bordered responsive" style="width:100%;">
            <thead>
                <tr class="font-verdana bg-danger text-white">
                    <td class="text-left p-1"><b>ID</b></td>
                    <td class="text-left p-1"><b>PRODUCTO</b></td>
                    <td class="text-center p-1"><b>MED.</b></td>
                    <td class="text-right p-1"><b>PRECIO</b></td>
                    <td class="text-right p-1"><b>CANTIDAD</b></td>
                    <td class="text-right p-1"><b>SUBTOTAL</b></td>
                    <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                </tr>
            </thead>
            <tbody>
                @if (isset($compra_detalle) && count($compra_detalle) > 0)
                    @foreach ($compra_detalle as $datos)
                        <tr class="font-verdana">
                            <td class="text-left p-1">
                                <input type="hidden" class="producto_id" value="{{ $datos->idprodserv }}">
                                {{ $datos->idprodserv }}
                            </td>
                            <td class="text-left p-1">{{ $datos->producto->nombreprodserv }}</td>
                            <td class="text-center p-1">{{ $datos->producto->unidad_medida }}</td>
                            <td class="text-right p-1">{{ number_format($datos->precio,2,'.',',') }}</td>
                            <td class="text-right p-1">{{ $datos->cantidad }}</td>
                            <td class="text-right p-1">{{ number_format($datos->precio * $datos->cantidad,2,'.','') }}</td>
                            <td class="text-center p-1">
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Eliminar" style="cursor: pointer;">
                                    <a href="#" class="btn btn-xs btn-warning" onclick="confirmarEliminacion({{ $datos->iddetallecompra }})">
                                        <i class='fa-solid fa-trash'></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr class="font-verdana" id="total_detalle_compra">
                    <td class="text-right p-1" colspan="5">
                        <b>TOTAL</b>
                    </td>
                    <td class="text-right p-1">
                        <span id="span_total_con_solicitud">{{ isset($total_compra) ? number_format($total_compra,2,'.','') : '' }}</span>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
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
                </tr>
            </thead>
            <tbody>
                @if (isset($compra_detalle) && count($compra_detalle) > 0)
                    @foreach ($compra_detalle as $datos)
                        <tr class="font-verdana-11">
                            <td class="text-left p-1">{{ $datos->idprodserv }}</td>
                            <td class="text-left p-1">{{ $datos->producto->nombreprodserv }}</td>
                            <td class="text-center p-1">{{ $datos->producto->unidad_medida }}</td>
                            <td class="text-right p-1">{{ number_format($datos->precio,2,'.',',') }}</td>
                            <td class="text-right p-1">{{ $datos->cantidad }}</td>
                            <td class="text-right p-1">{{ number_format($datos->precio * $datos->cantidad,2,'.','') }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr class="font-verdana-11" id="total_sin_solicitud">
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
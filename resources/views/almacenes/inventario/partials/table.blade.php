<div class="row abs-center">
    <div class="col-md-12 pr-1 pl-1 table-responsive mb-2">
        <table class="table display table-bordered table-striped responsive hover-orange" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <td class="text-center p-1"><b>ALMACEN</b></td>
                    <td class="text-center p-1"><b>CAT. PROG.</b></td>
                    <td class="text-center p-1"><b>PARTIDA PRESUPUESTARIA</b></td>
                    <td class="text-center p-1"><b>MATERIAL</b></td>
                    <td class="text-center p-1"><b>MEDIDA</b></td>
                    <td class="text-right p-1"><b>EN STOCK</b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($ingreso_compra_detalles as $datos)
                    <tr class="font-roboto-10">
                        <td class="text-center p-1">{{ $datos->almacen->nombre }}</td>
                        <td class="text-left p-1">{{ $datos->programatica->codigo }}</td>
                        <td class="text-left p-1">{{ $datos->partidaPresupuestaria->codigo . ' - ' . $datos->partidaPresupuestaria->nombre }}</td>
                        <td class="text-left p-1">{{ $datos->item->codigo . '-' . $datos->item->nombre }}</td>
                        <td class="text-center p-1">{{ $datos->unidad_medida->nombre }}</td>
                        <td class="text-right p-1">{{ number_format($datos->saldo_total,2,'.',',') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-roboto-11">
                    <td colspan="12">
                        {{ $ingreso_compra_detalles->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$ingreso_compra_detalles->count()}}</strong> registros de
                            <strong>{{$ingreso_compra_detalles->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

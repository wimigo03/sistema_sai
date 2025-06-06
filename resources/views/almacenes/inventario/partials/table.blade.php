<div class="row mb-3">
    <div class="col-12 table-responsive">
        <table class="table table-striped table-hover display responsive hover-orange">
            <thead class="bg-dark text-white">
                <tr>
                    <td class="text-center p-2 text-nowrap"><b>ALMACEN</b></td>
                    <td class="text-center p-2 text-nowrap"><b>CAT. PROG.</b></td>
                    <td class="text-center p-2 text-nowrap"><b>PARTIDA PRESUPUESTARIA</b></td>
                    <td class="text-center p-2 text-nowrap"><b>MATERIAL</b></td>
                    <td class="text-center p-2 text-nowrap"><b>MEDIDA</b></td>
                    <td class="text-right p-2 text-nowrap"><b>EN STOCK</b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($ingreso_compra_detalles as $datos)
                    <tr>
                        <td class="text-center p-2 text-nowrap">{{ $datos->almacen->nombre }}</td>
                        <td class="text-left p-2 text-nowrap">{{ $datos->programatica->codigo }}</td>
                        <td class="text-left p-2 text-nowrap">{{ $datos->partidaPresupuestaria->codigo . ' - ' . $datos->partidaPresupuestaria->nombre }}</td>
                        <td class="text-left p-2 text-nowrap">{{ $datos->item->codigo . '-' . $datos->item->nombre }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->unidad_medida->nombre }}</td>
                        <td class="text-right p-2 text-nowrap">{{ number_format($datos->saldo_total,2,'.',',') }}</td>
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

<div class="row mb-3">
    <div class="col-12 table-responsive">
        <table class="table table-striped table-hover display responsive hover-orange">
            <thead class="bg-dark text-white">
                <tr class="font-roboto-13">
                    <td class="text-center p-2 text-nowrap"><b>GESTION</b></td>
                    <td class="text-center p-2 text-nowrap"><b>TRIMESTRE</b></td>
                    <td class="p-2 text-nowrap"><b>CATEGORIA PROGRAMATICA</b></td>
                    <td class="p-2 text-nowrap"><b>PARTIDA PRESUPUESTARIA</b></td>
                    <td class="text-right p-2 text-nowrap"><b>TOTAL (BS.)</b></td>
                    @can('presupuesto.editar')
                        <td class="text-center p-2 text-nowrap">
                            <b><i class="fa-solid fa-bars fa-fw"></i></b>
                        </td>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($ejecuciones_presupuestarias as $datos)
                    <tr class="font-roboto-13">
                        <td class="text-center p-2 text-nowrap">{{ $datos->gestion }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->trimestre }}</td>
                        <td class="p-2 text-nowrap">{{ $datos->categoria_programatica->codigo . ' - ' . $datos->categoria_programatica->nombre }}</td>
                        <td class="p-2 text-nowrap">{{ $datos->partida_presupuestaria->numeracion . ' - ' . $datos->partida_presupuestaria->nombre }}</td>
                        <td class="text-right p-2 text-nowrap">{{ number_format($datos->monto,2,".",",") }}</td>
                        @can('presupuesto.editar')
                            <td class="text-center p-2 text-nowrap">
                                <div class="d-flex justify-content-center">
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                        <a href="{{ route('presupuesto.editar',$datos->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit fa-fw"></i>
                                        </a>
                                    </span>
                                </div>
                            </td>
                        @endcanany
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="11" class="font-roboto-14">
                        {{ $ejecuciones_presupuestarias->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$ejecuciones_presupuestarias->count()}}</strong> registros de
                            <strong>{{$ejecuciones_presupuestarias->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

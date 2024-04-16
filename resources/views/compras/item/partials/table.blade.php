<div class="form-group row">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <td class="text-left p-1"><b>NOMBRE</b></td>
                    <td class="text-left p-1"><b>DETALLE</b></td>
                    <td class="text-right p-1"><b>PRECIO</b></td>
                    <td class="text-center p-1"><b>TIPO</b></td>
                    <td class="text-center p-1"><b>MEDIDA</b></td>
                    <td class="text-left p-1"><b>PARTIDA PRESUPUESTARIA</b></td>
                    <td class="text-center p-1"><b>FECHA&nbsp;R.</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    @canany(['item.habilitar','item.editar'])
                        <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $datos)
                    <tr class="font-roboto-11">
                        <td class="text-left p-1">{{ $datos->nombre }}</td>
                        <td class="text-left p-1">{{ $datos->detalle }}</td>
                        <td class="text-right p-1">{{ number_format($datos->precio,2,'.',',') }}</td>
                        <td class="text-center p-1">{{ $datos->tipos }}</td>
                        <td class="text-center p-1">{{ $datos->unidad_medida->nombre }}</td>
                        <td class="text-left p-1">{{ $datos->partida->codigo . ' - ' . $datos->partida->nombre }}</td>
                        <td class="text-center p-1">{{ \Carbon\Carbon::parse($datos->fecha_registro)->format('d/m/Y') }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->colorStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['item.habilitar','item.editar'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    @can('item.habilitar')
                                        @if($datos->status == "HABILITADO")
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Deshabilitar" style="cursor: pointer;">
                                                <a href="{{ route('item.deshabilitar',$datos->id) }}" class="badge-with-padding badge badge-danger">
                                                    <i class="fas fa-arrow-alt-circle-down fa-fw"></i>
                                                </a>
                                            </span>
                                        @else
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Habilitar" style="cursor: pointer;">
                                                <a href="{{ route('item.habilitar',$datos->id) }}" class="badge-with-padding badge badge-success">
                                                    <i class="fas fa-arrow-alt-circle-up fa-fw"></i>
                                                </a>
                                            </span>
                                        @endif
                                    @endcan
                                    &nbsp;
                                    @can('item.editar')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                            <a href="{{ route('item.editar',$datos->id) }}" class="badge-with-padding badge badge-secondary text-white">
                                                <i class="fas fa-edit fa-fw"></i>
                                            </a>
                                        </span>
                                    @endcan
                                </div>
                            </td>
                        @endcanany
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-roboto-11">
                    <td colspan="12">
                        {{ $items->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$items->count()}}</strong> registros de
                            <strong>{{$items->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

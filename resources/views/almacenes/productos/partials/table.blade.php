<div class="row mb-3 font-roboto-14">
    <div class="col-12 table-responsive">
        <table class="table table-striped table-hover display responsive hover-orange">
            <thead class="bg-dark text-white">
                <tr>
                    <td class="text-center p-2 text-nowrap"><b>COD. P.P.</b></td>
                    <td class="text-center p-2 text-nowrap"><b>COD. MATERIAL</b></td>
                    <td class="text-left p-2 text-nowrap"><b>NOMBRE</b></td>
                    <td class="text-center p-2 text-nowrap"><b>UNIDAD</b></td>
                    <td class="text-right p-2 text-nowrap"><b>PRECIO REF.</b></td>
                    <td class="text-center p-2 text-nowrap"><b>ESTADO</b></td>
                    @canany(['producto.editar'])
                        <td class="text-center p-2 text-nowrap"><b><i class="fa-solid fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $datos)
                    <tr>
                        <td class="text-center p-2 text-nowrap">
                            <span class="tts:right tts-slideIn tts-custom" aria-label="{{ $datos->partidaPresupuestaria->nombre }}" style="cursor: pointer;">
                                {{ $datos->partidaPresupuestaria->numeracion }}
                            </span>
                        </td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->codigo }}</td>
                        <td class="text-left p-2 text-nowrap">{{ $datos->nombre }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->unidad_medida->nombre }}</td>
                        <td class="text-right p-2 text-nowrap">{{ number_format($datos->precio,2,'.',',') }}</td>
                        <td class="text-center p-2 text-nowrap">
                            <span class="{{ $datos->colorStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['producto.editar'])
                            <td class="text-center p-2 text-nowrap">
                                <div class="d-flex justify-content-center">
                                    @if($datos->estado != '3')
                                        @can('producto.editar')
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                                <a href="{{ route('producto.editar',$datos->id) }}" class="btn btn-sm btn-secondary">
                                                    <i class="fas fa-edit fa-fw"></i>
                                                </a>
                                            </span>
                                        @endcan
                                    @endif
                                </div>
                            </td>
                        @endcanany
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-roboto-14">
                    <td colspan="12">
                        {{ $productos->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$productos->count()}}</strong> registros de
                            <strong>{{$productos->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

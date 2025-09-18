<div class="row mb-3">
    <div class="col-12 table-responsive">
        <table class="table table-striped table-hover display responsive hover-orange">
            <thead class="bg-dark text-white">
                <tr class="font-roboto-13">
                    <td class="p-2 text-nowrap"><b>BARRIO</b></td>
                    <td class="p-2 text-nowrap"><b>NOMBRE</b></td>
                    <td class="p-2 text-nowrap"><b>DIRECCION</b></td>
                    <td class="text-left p-2 text-nowrap"><b>WHATSAPP</b></td>
                    <td class="text-center p-2 text-nowrap"><b>FACEBOOK</b></td>
                    <td class="text-center p-2 text-nowrap"><b>MAPS</b></td>
                    <td class="text-center p-2 text-nowrap"><b>ESTADO</b></td>
                    @can('farmacias.index')
                        <td class="text-center p-2 text-nowrap">
                            <b><i class="fa-solid fa-bars fa-fw"></i></b>
                        </td>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($farmacias as $datos)
                    <tr class="font-roboto-13">
                        <td class="p-2 text-nowrap">{{ strtoupper($datos->barrio->nombre) }}</td>
                        <td class="p-2 text-nowrap">{{ strtoupper($datos->nombre) }}</td>
                        <td class="p-2 text-nowrap" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                            {{ strtoupper($datos->direccion) }}
                        </td>
                        <td class="text-left p-2 text-nowrap">{{ $datos->whatsapp }}</td>
                        <td class="text-center p-2 text-nowrap">{{ $datos->facebooñ }}</td>
                        <td class="text-center p-2 text-nowrap">
                            @if ($datos->lat != null && $datos->lng != null)
                                <a href="https://google.com/maps/place/{{ $datos->lat }},{{ $datos->lng }}" target="_blank">
                                    <i class="fa-solid fa-location-dot fa-lg text-danger"></i>
                                </a>
                            @else
                                <i class="fa-solid fa-location-dot fa-lg text-secondary"></i>
                            @endif
                        </td>
                        <td class="text-center p-2 text-nowrap">
                            <span class="{{ $datos->colorBadgeStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @can('farmacias.index')
                            <td class="text-center p-2 text-nowrap">
                                <div class="d-flex justify-content-center">
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                        <a href="{{ route('farmacias.editar',$datos->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit fa-fw"></i>
                                        </a>
                                    </span>
                                </div>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8" class="font-roboto-14">
                        {{ $farmacias->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$farmacias->count()}}</strong> registros de
                            <strong>{{$farmacias->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

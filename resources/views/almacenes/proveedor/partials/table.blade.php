<div class="row mb-3">
    <div class="col-12 table-responsive">
        <table class="table table-striped table-hover display responsive hover-orange">
            <thead class="bg-dark text-white">
                <tr class="font-roboto-14">
                    <td class="text-left p-1"><b>NRO</b></td>
                    <td class="text-left p-1"><b>NOMBRE</b></td>
                    <td class="text-left p-1"><b>REPRESENTANTE</b></td>
                    <td class="text-center p-1"><b>C.I.</b></td>
                    <td class="text-center p-1"><b>NIT</b></td>
                    <td class="text-center p-1"><b>TELEFONO</b></td>
                    <td class="text-center p-1"><b>FECHA&nbsp;R.</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    @canany(['proveedor.habilitar','proveedor.editar'])
                        <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($proveedores as $datos)
                    <tr class="font-roboto-14">
                        <td class="text-left p-1">{{ $datos->id }}</td>
                        <td class="text-left p-1">{{ $datos->nombre }}</td>
                        <td class="text-left p-1">{{ $datos->representante }}</td>
                        <td class="text-center p-1">{{ $datos->nro_ci }}</td>
                        <td class="text-center p-1">{{ $datos->nit }}</td>
                        <td class="text-center p-1">{{ $datos->telefono }}</td>
                        <td class="text-center p-1">{{ \Carbon\Carbon::parse($datos->fecha_registro)->format('d/m/Y') }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->colorStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['proveedor.habilitar','proveedor.editar'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    @can('proveedor.habilitar')
                                        @if($datos->status == "HABILITADO")
                                            <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Deshabilitar" style="cursor: pointer;">
                                                <a href="{{ route('proveedor.deshabilitar',$datos->id) }}" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-arrow-alt-circle-down fa-fw"></i>
                                                </a>
                                            </span>
                                        @else
                                            <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Habilitar" style="cursor: pointer;">
                                                <a href="{{ route('proveedor.habilitar',$datos->id) }}" class="btn btn-sm btn-success">
                                                    <i class="fas fa-arrow-alt-circle-up fa-fw"></i>
                                                </a>
                                            </span>
                                        @endif
                                    @endcan
                                    @can('proveedor.editar')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                            <a href="{{ route('proveedor.editar',$datos->id) }}" class="btn btn-sm btn-warning">
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
                <tr class="font-roboto-14">
                    <td colspan="12">
                        {{ $proveedores->appends(Request::all())->links() }}
                        <p class="text- muted">Mostrando
                            <strong>{{$proveedores->count()}}</strong> registros de
                            <strong>{{$proveedores->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

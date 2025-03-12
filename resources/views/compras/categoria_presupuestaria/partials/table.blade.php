<div class="form-group row font-roboto-13">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table id="indexAjax" class="table display table-bordered hover-orange" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <td class="text-center p-1"><b>NUMERACION</b></td>
                    <td class="text-center p-1"><b>CODIGO</b></td>
                    <td class="text-center p-1"><b>DETALLE</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    @canany(['categoria.presupuestaria.index'])
                        <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($categorias_presupuestarias as $datos)
                    <tr class="font-roboto-11">
                        <td class="text-left p-1">{{ $datos->partidaPresupuestaria->numeracion }}</td>
                        <td class="text-left p-1">{{ $datos->partidaPresupuestaria->codigo }}</td>
                        <td class="text-left p-1">{{ $datos->partidaPresupuestaria->nombre }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->colorStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['categoria.presupuestaria.index'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    @can('categoria.presupuestaria.index')
                                        @if($datos->status == "HABILITADO")
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Deshabilitar" style="cursor: pointer;">
                                                <a href="{{ route('categoria.presupuestaria.deshabilitar',$datos->id) }}" class="badge-with-padding badge badge-danger">
                                                    <i class="fas fa-arrow-alt-circle-down fa-fw"></i>
                                                </a>
                                            </span>
                                        @else
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Habilitar" style="cursor: pointer;">
                                                <a href="{{ route('categoria.presupuestaria.habilitar',$datos->id) }}" class="badge-with-padding badge badge-success">
                                                    <i class="fas fa-arrow-alt-circle-up fa-fw"></i>
                                                </a>
                                            </span>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                        @endcanany
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

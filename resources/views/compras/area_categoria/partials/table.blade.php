<div class="form-group row abs-center font-roboto-12">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table id="indexAjax" class="table display table-bordered hover-orange" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <td class="text-center p-1"><b>AREA</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    @canany(['area.categoria.index'])
                        <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($areas_categorias as $datos)
                    <tr class="font-roboto-11">
                        <td class="text-left p-1">{{ $datos->nombrearea }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->colorStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        @canany(['area.categoria.index'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    @can('area.categoria.index')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Deshabilitar" style="cursor: pointer;">
                                            <a href="{{ route('area.categoria.eliminar',$datos->idarea) }}" class="badge-with-padding badge badge-danger">
                                                <i class="fas fa-trash fa-fw"></i>
                                            </a>
                                        </span>
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

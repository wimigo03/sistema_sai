<div class="form-group row abs-center font-roboto-12">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table id="indexAjax" class="table display table-bordered hover-orange" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <td class="text-center p-1"><b>AREA PERMITIDA</b></td>
                    @canany(['almacen.asignar'])
                        <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($areas_almacenes as $datos)
                    <tr class="font-roboto-11">
                        <td class="text-left p-1">{{ $datos->nombrearea }}</td>
                        @can('almacen.asignar')
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Eliminar" style="cursor: pointer;">
                                        <a href="{{ route('almacen.eliminar.area',$datos->idarea) }}" class="badge-with-padding badge badge-danger">
                                            <i class="fas fa-trash fa-fw"></i>
                                        </a>
                                    </span>
                                </div>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

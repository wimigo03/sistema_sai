<div class="form-group row font-roboto-12">
    <div class="col-md-3 pr-1 pl-1">
        <b>Total Habilitados:</b>&nbsp;{{ $beneficiariosA }}
    </div>
    <div class="col-md-3 pr-1 pl-1 text-center">
        <b>Total Bajas:</b>&nbsp;{{ $beneficiariosB }}
    </div>
    <div class="col-md-3 pr-1 pl-1 text-center">
        <b>Total Fallecidos:</b>&nbsp;{{ $beneficiariosF }}
    </div>
    <div class="col-md-3 pr-1 pl-1 text-right">
        <b>Total Pendientes:</b>&nbsp;{{ $beneficiariosX }}
    </div>
</div>
<div class="form-group row font-roboto-12">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="#">
            <thead>
                <tr class="font-roboto-12">
                    <td class="text-center p-1" style="vertical-align: middle;" rowspan="2"><b>TIPO</b></td>
                    <td class="text-center p-1" style="vertical-align: middle;" rowspan="2"><b>NOMBRE</b></td>
                    <td class="text-center p-1" style="vertical-align: middle;" rowspan="2"><b>DISTRITO</b></td>
                    <td class="text-center p-1" style="vertical-align: middle;" rowspan="2"><b>ESTADO</b></td>
                    <td class="text-center p-1" colspan="4"><b>BENEFICIARIOS</b></td>
                    @canany(['canasta.barrios.editar', 'canasta.barrios.habilitar'])
                        <td class="text-center p-1" style="vertical-align: middle;" rowspan="2"><b><i class="fa-solid fa-bars"></i></b></td>
                    @endcanany
                </tr>
                <tr class="font-roboto-12">
                    <td class="text-center p-1"><b>HABILITADOS</b></td>
                    <td class="text-center p-1"><b>BAJAS</b></td>
                    <td class="text-center p-1"><b>FALLECIDOS</b></td>
                    <td class="text-center p-1"><b>PENDIENTES</b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($barrios as $datos)
                    <tr class="font-roboto-12">
                        <td class="text-center p-1">{{ $datos->tipo_b }}</td>
                        <td class="text-left p-1">{{ $datos->nombre }}</td>
                        <td class="text-center p-1">{{ $datos->distrito->nombre }}</td>
                        <td class="text-center p-1">
                            <span class="{{ $datos->colorStatus }}">
                                {{ $datos->status }}
                            </span>
                        </td>
                        <td class="text-center p-1">{{ $datos->beneficiariosA()->count() }}</td>
                        <td class="text-center p-1">{{ $datos->beneficiariosB()->count() }}</td>
                        <td class="text-center p-1">{{ $datos->beneficiariosF()->count() }}</td>
                        <td class="text-center p-1">{{ $datos->beneficiariosX()->count() }}</td>
                        @canany(['canasta.barrios.editar', 'canasta.barrios.habilitar'])
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    @can('canasta.barrios.editar')
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                            <a href="{{ route('barrios.editar', $datos->id) }}" class="badge-with-padding badge badge-warning">
                                                <i class="fa-solid fa-pen-to-square fa-fw"></i>
                                            </a>
                                        </span>
                                    @endcan
                                    @can('canasta.barrios.habilitar')
                                        @if (App\Models\Canasta\Barrio::ESTADOS[$datos->estado] == 'HABILITADO')
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Dehabilitar" style="cursor: pointer;">
                                                <a href="{{ route('barrios.deshabilitar', $datos->id) }}" class="badge-with-padding badge badge-danger">
                                                    <i class="fa-regular fa-circle-down fa-lg"></i>
                                                </a>
                                            </span>
                                        @else
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Habilitar"
                                                style="cursor: pointer;">
                                                <a href="{{ route('barrios.habilitar', $datos->id) }}" class="badge-with-padding badge badge-success">
                                                    <i class="fa-regular fa-circle-up fa-lg"></i>
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
            <tfoot class="font-roboto-12">
                <tr>
                    <td colspan="12">
                        {{ $barrios->appends(Request::all())->links() }}
                        <p class="text-muted">Mostrando
                            <strong>{{ $barrios->count() }}</strong> registros de
                            <strong>{{ $barrios->total() }}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

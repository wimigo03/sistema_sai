<div class="form-group row">
    <div class="col-md-12 table-responsive">
        <table class="table display responsive" style="width:100%;">
            <thead>
                <tr class="font-verdana">
                    <td class="text-left p-1"><b>TIPO</b></td>
                    <td class="text-left p-1"><b>NOMBRE</b></td>
                    <td class="text-left p-1"><b>DISTRITO</b></td>
                    <td class="text-center p-1"><b>HABILITADOS</b></td>
                    <td class="text-center p-1"><b>BAJAS</b></td>
                    <td class="text-center p-1"><b>FALLECIDOS</b></td>
                    <td class="text-center p-1"><b>PENDIENTES</b></td>
                    <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($barrios as $datos)
                    <tr class="font-verdana-11">
                        <td class="text-left p-1">{{ $datos->tipo_b }}</td>
                        <td class="text-left p-1">{{ $datos->nombre }}</td>
                        <td class="text-left p-1">{{ $datos->distrito->nombre }}</td>
                        <td class="text-center p-1" style="color: green;font-weight: bold;">{{ $datos->beneficiariosA()->count() }}</td>
                        <td class="text-center p-1" style="color: red;font-weight: bold;">{{ $datos->beneficiariosB()->count() }}</td>
                        <td class="text-center p-1" style="color: orange;font-weight: bold;">{{ $datos->beneficiariosF()->count() }}</td>
                        <td class="text-center p-1" style="color: blue;font-weight: bold;">{{ $datos->beneficiariosX()->count() }}</td>
                        <td class="text-center p-1">
                            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar"
                                style="cursor: pointer;">
                                <a href="{{ route('barrios.editar', $datos->id) }}" class="badge-with-padding badge badge-warning text-white">
                                    <i class="fa-solid fa-pen-to-square fa-fw"></i>
                                </a>
                            </span>
                            @if (App\Models\Canasta\Barrio::ESTADOS[$datos->estado] == 'HABILITADO')
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Dehabilitar"
                                    style="cursor: pointer;">
                                    <a href="{{ route('barrios.deshabilitar', $datos->id) }}" class="badge-with-padding badge badge-success">
                                        <i class="fa-regular fa-circle-down fa-lg"></i>
                                    </a>
                                </span>
                            @else
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Habilitar"
                                    style="cursor: pointer;">
                                    <a href="{{ route('barrios.habilitar', $datos->id) }}" class="badge-with-padding badge badge-danger">
                                        <i class="fa-regular fa-circle-up fa-lg"></i>
                                    </a>
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <th class="text-right p-1" style="background-color:#E1FFFF" colspan="3">Total :</th>
                <td class="text-center p-1" style="background-color:#E1FFFF">{{ $beneficiariosA }}</td>
                <td class="text-center p-1" style="background-color:#E1FFFF">{{ $beneficiariosB }}</td>
                <td class="text-center p-1" style="background-color:#E1FFFF">{{ $beneficiariosF }}</td>
                <td class="text-center p-1" style="background-color:#E1FFFF">{{ $beneficiariosX }}</td>
                <th style="background-color:#E1FFFF" colspan="2"></th>
                <tr class="font-verdana">
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

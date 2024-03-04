<div class="form-group row">
    <div class="col-md-12 table-responsive">
        <table class="table display table-bordered responsive" style="width:100%;">
            <thead>
                <tr class="font-verdana">
                    <td class="text-left p-1"><b>TIPO</b></td>
                    <td class="text-left p-1"><b>NOMBRE</b></td>
                    <td class="text-left p-1"><b>DISTRITO</b></td>
                    <td class="text-left p-1"><b>USUARIO</b></td>
                    <td class="text-center p-1"><b>HABILITADOS</b></td>
                    <td class="text-center p-1"><b>BAJAS</b></td>
                    <td class="text-center p-1"><b>FALLECIDOS</b></td>
                    <td class="text-center p-1"><b>PENDIENTES</b></td>
                    <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                    <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($barrios as $datos)
                    <tr class="font-verdana">

                        <td class="text-left p-1">{{ $datos->tipo_b }}</td>
                        <td class="text-left p-1">{{ $datos->nombre }}</td>
                        <td class="text-left p-1">{{ $datos->distrito->nombre }}</td>
                        <td class="text-left p-1">{{ strtoupper($datos->user->name) }}</td>
                        <td class="text-center p-1" style="color: green;font-weight: bold;">{{ $datos->beneficiariosA()->count() }}</td>
                        <td class="text-center p-1" style="color: red;font-weight: bold;">{{ $datos->beneficiariosB()->count() }}</td>
                        <td class="text-center p-1" style="color: orange;font-weight: bold;">{{ $datos->beneficiariosF()->count() }}</td>
                        <td class="text-center p-1" style="color: blue;font-weight: bold;">{{ $datos->beneficiariosX()->count() }}</td>
                        <td class="text-center p-1">
                            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar"
                                style="cursor: pointer;">
                                <a href="{{ route('barrios.editar', $datos->id) }}" class="btn btn-xs btn-warning">
                                    <i class="fa-solid fa-lg fa-pen-to-square"></i>
                                </a>
                            </span>
                        </td>
                        <td class="text-center p-1">

                            @if (App\Models\Canasta\Barrio::ESTADOS[$datos->estado] == 'HABILITADO')
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Dehabilitar"
                                    style="cursor: pointer;">
                                    <a href="{{ route('barrios.deshabilitar', $datos->id) }}"
                                        class="btn btn-xs btn-success">
                                        <i class="fa-regular fa-lg fa-circle-down"></i>
                                    </a>
                                </span>
                            @else
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Habilitar"
                                    style="cursor: pointer;">
                                    <a href="{{ route('barrios.habilitar', $datos->id) }}"
                                        class="btn btn-xs btn-danger">
                                        <i class="fa-regular fa-lg fa-circle-up"></i>
                                    </a>
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
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

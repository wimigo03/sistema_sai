<div class="form-group row">
    <div class="col-md-12 table-responsive">
        <table class="table display table-bordered responsive" style="width:100%;">
            <thead>
                <tr class="font-verdana-11">
                    <td class="text-center p-1"><b>COD_ID</b></td>
                    <td class="text-center p-1"><b>N°&nbsp;C.&nbsp;INT.</b></td>
                    <td class="text-center p-1"><b>N°&nbsp;PREV.</b></td>
                    <td class="text-center p-1"><b>FECHA&nbsp;PREV.</b></td>
                    <td class="text-center p-1"><b>AREA</b></td>
                    <td class="text-center p-1"><b>PROGRAMA</b></td>
                    <td class="text-center p-1"><b>CAT.&nbsp;PROG.</b></td>
                    <td class="text-center p-1"><b>ESTADO</b></td>
                    <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($compras as $datos)
                    <tr class="font-verdana-11">
                        <td class="text-center p-1">{{ $datos->idcompra }}</td>
                        <td class="text-center p-1">{{ $datos->controlinterno }}</td>
                        <td class="text-center p-1">{{ $datos->preventivo != null ? $datos->preventivo : '[]' }}</td>
                        <td class="text-center p-1">{{ $datos->fecha_preventivo != null ? \Carbon\Carbon::parse($datos->fecha_preventivo)->format('d/m/Y') : '[]' }}</td>
                        <td class="text-center p-1">{{ $datos->area->alias }}</td>
                        <td class="text-center p-1">{{ $datos->programa->alias }}</td>
                        <td class="text-center p-1">{{ $datos->cat_prog->codcatprogramatica }}</td>
                        <td class="text-center p-1">{{ $datos->estado }}</td>
                        <td class="text-center p-1">
                            <div class="d-flex justify-content-center">
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                    <a href="{{ route('compras.pedidoparcial.editar',$datos->idcompra) }}" class="btn btn-xs btn-warning mr-1">
                                        <i class="fa-solid fa-lg fa-pen-to-square"></i>
                                    </a>
                                </span>
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle" style="cursor: pointer;">
                                    <a href="{{ route('compras.pedidoparcial.show',$datos->idcompra) }}" class="btn btn-xs btn-primary">
                                        <i class="fa-solid fa-lg fa-list"></i>
                                    </a>
                                </span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-verdana-11">
                    <td colspan="12">
                        {{ $compras->appends(Request::all())->links() }}
                        <p class="text-muted">Mostrando
                            <strong>{{$compras->count()}}</strong> registros de
                            <strong>{{$compras->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

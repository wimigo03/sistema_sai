<div class="form-group row">
    <div class="col-md-12 table-responsive">
        <table class="table display table-bordered responsive" style="width:100%;">
            <thead>
                <tr class="font-verdana">
                    <td class="text-center p-1"><b>COD_ID</b></td>
                    <td class="text-center p-1"><b>N°&nbsp;C.&nbsp;INT.</b></td>
                    <td class="text-left p-1"><b>OBJETO</b></td>
                    <td class="text-left p-1"><b>AREA</b></td>
                    <td class="text-left p-1"><b>PROGRAMA</b></td>
                    <td class="text-left p-1"><b>COD.&nbsp;CAT.&nbsp;PROG.</b></td>
                    <td class="text-center p-1"><b><i class="fa-solid fa-bars"></i></b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($compras as $datos)
                    <tr class="font-verdana">
                        <td class="text-center p-1">{{ $datos->idcompra }}</td>
                        <td class="text-center p-1">{{ $datos->controlinterno }}</td>
                        <td class="text-left p-1">{{ $datos->objeto }}</td>
                        <td class="text-left p-1">{{ $datos->area->nombrearea }}</td>
                        <td class="text-left p-1">{{ $datos->programa->nombreprograma }}</td>
                        <td class="text-left p-1">{{ $datos->cat_prog->codcatprogramatica }}</td>
                        <td class="text-center p-1">
                            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                <a href="{{ route('compras.pedidoparcial.editar',$datos->idcompra) }}" class="btn btn-xs btn-warning">
                                    <i class="fa-solid fa-lg fa-pen-to-square"></i>
                                </a>
                            </span>
                            <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle" style="cursor: pointer;">
                                <a href="{{ route('compras.pedidoparcial.edit',$datos->idcompra) }}" class="btn btn-xs btn-info">
                                    <i class="fa-solid fa-lg fa-list"></i>
                                </a>
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-verdana">
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

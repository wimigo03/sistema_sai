@if (!isset($archivos))
    <div class="form-group row font-roboto-12">
        <div class="col-md-12 pr-1 pl-1">
            <table class="table table-striped table-bordered hover-orange" style="width:100%;" id="dataTable">
                <thead>
                    <tr class="font-roboto-11">
                        <td class="text-center p-1 font-roboto-11" width="5%"><b>N°</b></td>
                        <td class="text-center p-1 font-roboto-11" width="5%"><b>GESTION</b></td>
                        <td class="text-center p-1 font-roboto-11" width="10%"><b>REC./ENV.</b></td>
                        <td class="text-center p-1 font-roboto-11" width="7%"><b>N. DOC.</b></td>
                        <td class="text-center p-1 font-roboto-11" width="40%"><b>REFERENCIA</b></td>
                        <td class="text-center p-1 font-roboto-11"><b>TIPO</b></td>
                        <td class="text-center p-1">
                            @canany(['archivos.documentacion','archivos.editar','archivos.generar.qr'])
                                <i class="fa fa-bars" aria-hidden="true"></i>
                            @endcanany
                        </td>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td></td>
                    </tr>
                </tfoot>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="form-group row font-roboto-12">
        <div class="col-md-12 pr-1 pl-1">
            <table class="table table-striped table-bordered hover-orange" style="width:100%;" id="#">
                <thead>
                    <tr class="font-roboto-11">
                        <td class="text-center p-1" width="5%"><b>N°</b></td>
                        <td class="text-center p-1" width="5%"><b>GESTION</b></td>
                        <td class="text-center p-1" width="10%"><b>REC./ENV.</b></td>
                        <td class="text-center p-1" width="7%"><b>N. DOC.</b></td>
                        <td class="text-center p-1" width="40%"><b>REFERENCIA</b></td>
                        <td class="text-center p-1"><b>TIPO</b></td>
                        <td class="text-center p-1">
                            @canany(['archivos.documentacion','archivos.editar','archivos.generar.qr'])
                                <i class="fa fa-bars" aria-hidden="true"></i>
                            @endcanany
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($archivos as $datos)
                        <tr class="font-roboto-10">
                            <td class="text-center p-1">{{ $cont++ }}</td>
                            <td class="text-center p-1">{{ $datos->gestion }}</td>
                            <td class="text-center p-1">{{ \Carbon\Carbon::parse($datos->fecha)->format('d/m/Y') }}</td>
                            <td class="text-center p-1">{{ $datos->nombrearchivo }}</td>
                            <td class="text-justify p-1">{{ $datos->referencia }}</td>
                            <td class="text-center p-1">{{ $datos->tipo->nombretipo }}</td>
                            <td class="text-center p-1">
                                @canany(['archivos.documentacion','archivos.editar','archivos.generar.qr'])
                                    <div class="d-flex justify-content-center">
                                        @can('archivos.documentacion')
                                            <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Ir a documento" style="cursor: pointer;">
                                                <a href="{{ route('archivos.documentacion',$datos->idarchivo) }}" class="badge-with-padding badge badge-primary" target="_blank">
                                                    <i class="fas fa-file fa-fw"></i>
                                                </a>
                                            </span>
                                        @endcan
                                        @can('archivos.editar')
                                            <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Modificar" style="cursor: pointer;">
                                                <a href="{{ route('archivos.editar',$datos->idarchivo) }}" class="badge-with-padding badge badge-warning">
                                                    <i class="fas fa-edit fa-fw"></i>
                                                </a>
                                            </span>
                                        @endcan
                                        @can('archivos.generar.qr')
                                            <span class="tts:left tts-slideIn tts-custom" aria-label="Qr" style="cursor: pointer;">
                                                <a href="{{ route('archivos.generar.qr',$datos->idarchivo) }}" class="badge-with-padding badge badge-dark text-white" target="_blank">
                                                    <i class="fas fa-qrcode fa-fw"></i>
                                                </a>
                                            </span>
                                        @endcan
                                    </div>
                                @endcanany
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-roboto-11">
                        <td colspan="12">
                            {{ $archivos->appends(Request::all())->links() }}
                            <p class="text-muted">Mostrando
                                <strong>{{ $archivos->count() }}</strong> registros de
                                <strong>{{ $archivos->total() }}</strong> totales
                            </p>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endif

<div class="form-group row">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <th class="text-center p-1">GESTION</th>
                    <th class="text-center p-1">PERIODO</th>
                    <th class="text-center p-1">NOMBRES</th>
                    <th class="text-center p-1">AP. PATERNO</th>
                    <th class="text-center p-1">AP. MATERNO</th>
                    <th class="text-center p-1">N° C. I.</th>
                    <th class="text-center p-1">BARRIO</th>
                    <th class="text-center p-1">ESTADO</th>
                    <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entrega as $entregas)
                    <tr class="font-roboto-11">
                        <td class="text-center p-1">{{ $entregas->paquete->gestion }}</td>
                        <td class="text-center p-1">{{ $entregas->paquete->periodo }}</td>
                        <td class="text-justify p-1">{{ $entregas->beneficiario->nombres }}</td>
                        <td class="text-justify p-1"> {{ $entregas->beneficiario->ap }} </td>
                        <td class="text-justify p-1">{{ $entregas->beneficiario->am }}</td>
                        <td class="text-center p-1">{{ $entregas->beneficiario->ci }}</td>
                        <td class="text-center p-1">{{ $entregas->beneficiario->barrio->nombre }}</td>
                        <td class="text-center p-1">{{ $entregas->status }}</td>
                        <td class="text-center p-1">
                            <span class="tts:left tts-slideIn tts-custom" aria-label="Imprimir Boleta">
                                <a  href="{{ route('entregas.generarboleta2',$entregas->id) }}" class="badge-with-padding badge badge-warning" target="_blank" >
                                    <i class='fa fa-print fa-fw'></i>
                                </a>
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-verdana-11">
                    <td colspan="12">
                        {{ $entrega->appends(Request::all())->links() }}
                        <p class="text-muted">Mostrando
                            <strong>{{$entrega->count()}}</strong> registros de
                            <strong>{{$entrega->total()}}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

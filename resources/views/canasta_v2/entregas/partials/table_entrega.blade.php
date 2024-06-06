<div class="form-group row">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange sortable" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <th class="text-center p-1">GESTION</th>
                    <th class="text-center p-1">PERIODO</th>
                    <th class="text-center p-1">NOMBRES</th>
                    <th class="text-center p-1">AP. PATERNO</th>
                    <th class="text-center p-1">AP. MATERNO</th>
                    <th class="text-center p-1">N° C. I.</th>
                    <th class="text-center p-1">BARRIO</th>
                    <th class="text-center p-1">FOTO</th>
                    <th class="text-center p-1">ESTADO</th>
                    <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>
                    <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>

                </tr>
            </thead>
            <tbody>
                @foreach ($entrega as $entregas)
                    <tr class="font-roboto-11">
                        <td class="text-center p-1">{{ $entregas->gestion }}</td>
                        <td class="text-center p-1">{{ $entregas->periodo }}</td>
                        <td class="text-justify p-1">{{ $entregas->nombres }}</td>
                        <td class="text-justify p-1"> {{ $entregas->ap }} </td>
                        <td class="text-justify p-1">{{ $entregas->am }}</td>
                        <td class="text-center p-1">{{ $entregas->ci }}</td>
                        <td class="text-center p-1">{{ $entregas->nombre }}</td>
                        <td class="text-center p-1"><img src="{{ asset(substr($entregas->dir_foto, 3)) }}"
                                align="center" height="30" with="30" /></td>
                        @if (strtoupper($entregas->status) == 'SIN ENT.(SIN IMPRESION)')
                            <td class="text-left p-1" style="color: RED;font-weight: bold;">
                                {{ strtoupper($entregas->status) }}</td>
                        @elseif(strtoupper($entregas->status) == 'SIN ENT.(IMPRESO)')
                            <td class="text-left p-1" style="color: ORANGE;font-weight: bold;">
                                {{ strtoupper($entregas->status) }}</td>
                        @elseif(strtoupper($entregas->status) == 'ENTREGADO')
                            <td class="text-left p-1" style="color: green;font-weight: bold;">
                                {{ strtoupper($entregas->status) }}</td>
                        @endif


                        <td class="text-center p-1">
                            @if (App\Models\Canasta\Entrega::ESTADOS[$entregas->estado] == 'SIN ENT.(IMPRESO)')
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Imprimir Boleta">
                                    <a href="{{ route('entregas.generarboleta2', $entregas->id) }}"
                                        class="badge-with-padding badge badge-primary" target="_blank">
                                        <i class='fa fa-print fa-fw'></i>
                                    </a>
                                </span>
                            @endif
                        </td>
                        <td class="text-center p-1">
                            @php
                                $barrios_entrega = DB::table('barriosEntrega')
                                    ->where('id_barrio', $entregas->idbarrio)
                                    ->where('id_paquete', $entregas->id_paquete)
                                    ->select('estado')
                                    ->first();
                                if ($barrios_entrega != null) {
                                    $estados = $barrios_entrega->estado;
                                } else {
                                    $estados = null;
                                }

                            @endphp
                            @if ($entregas->estado == 3 && $estados == 3)
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Quitar Entrega"
                                    style="cursor: pointer;">
                                    <a href="{{ route('entregas.deshabilitar', [$entregas->id, $entregas->paquete->id]) }}"
                                        class="badge-with-padding badge badge-success">
                                        <i class="fa-regular fa-circle-down fa-lg"></i>
                                    </a>
                                </span>
                            @elseif ($entregas->estado == 2 && $estados == 3)
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Entregar"
                                    style="cursor: pointer;">
                                    <a href="{{ route('entregas.habilitar', [$entregas->id, $entregas->paquete->id]) }}"
                                        class="badge-with-padding badge badge-danger">
                                        <i class="fa-regular fa-circle-up fa-lg"></i>
                                    </a>
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-verdana-11">
                    <td colspan="12">
                        {{ $entrega->appends(Request::all())->links() }}
                        <p class="text-muted">Mostrando
                            <strong>{{ $entrega->count() }}</strong> registros de
                            <strong>{{ $entrega->total() }}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

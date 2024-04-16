<div class="form-group row">
        <div class="col-md-12 table-responsive">
            <center>

                <table  class="table display table-bordered responsive font-verdana" style="width:100%">
                    <thead>
                        <tr>

                            <td class="text-justify p-1"><b>Gestion</b></td>
                            <td class="text-justify p-1"><b>Periodo</b></td>
                            <td class="text-justify p-1"><b>Nombres</b></td>
                            <td class="text-justify p-1"><b>Ap_Pat</b></td>
                            <td class="text-justify p-1"><b>Ap_mat</b></td>
                            <td class="text-justify p-1"><b>Ci</b></td>
                            <td class="text-justify p-1"><b>Barrio</b></td>
                            <td class="text-justify p-1"><b>Estado</b></td>
                            <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                            <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                            <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>

                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($entrega as $entregas)
                            <tr>


                                <td class="text-justify p-1">{{ $entregas->paquete->gestion }}</td>
                                <td class="text-justify p-1">{{ $entregas->paquete->periodo }}</td>
                                <td class="text-justify p-1">{{ $entregas->beneficiario->nombres }}</td>
                                <td class="text-justify p-1"> {{ $entregas->beneficiario->ap }} </td>
                                <td class="text-justify p-1">{{ $entregas->beneficiario->am }}</td>
                                <td class="text-justify p-1">{{ $entregas->beneficiario->ci }}</td>
                                <td class="text-justify p-1">{{ $entregas->beneficiario->barrio->nombre }}</td>
                                <td class="text-center p-1">{{ $entregas->status }}</td>

                                <td align="center" style="width:3%">
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Imiprimir Boleta">
                                        <a  href="{{ route('entregas.generarboleta2',$entregas->id) }}"
                                            class="btn btn-sm edit btn-flat" target="_blank" ><i class='fa fa-print'></i></a>
                                    </span>
                                </td>

                                <td class="text-justify p-1"></td>
                                <td class="text-justify p-1"></td>



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
            </center>
        </div>

    </div>

<div class="form-group row">
    <div class="col-md-12 table-responsive">
        <table class="table display table-bordered responsive" style="width:100%;">
            <thead>
                <tr class="font-verdana-11">
                    <td class="text-left p-1"><b>IDPAQUETE</b></td>
                    <td class="text-left p-1"><b>GESTION</b></td>
                    <td class="text-left p-1"><b>PERIODO</b></td>
                    <td class="text-left p-1"><b>NUM.ENTREGA</b></td>
                    <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                    <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                    <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>

                </tr>
            </thead>
            <tbody>
                @foreach ($paquetes as $datos)
                    <tr class="font-verdana-11">
                        <td class="text-left p-1">{{ $datos->id }}</td>
                        <td class="text-left p-1">{{ $datos->gestion }}</td>
                        <td class="text-left p-1">{{ $datos->periodo }}</td>
                        <td class="text-left p-1">{{ $datos->numero}}</td>

                        @can('canasta.paquete.editar')
                        <td align="center" style="width:3%" >



                            <span class="tts:left tts-slideIn tts-custom" aria-label="Editar Paquete">
                                <a href="{{ route('entregas.edit_paquete', $datos->id) }}"
                                    class="btn btn-sm edit btn-flat"><i class="fa-sharp fa-regular fa-pen-to-square"></i>
                            </span>


                        </td>
                        @endcan
                        @can('canasta.paquete.periodo')


                        <td align="center" style="width:3%">
                            <span class="tts:left tts-slideIn tts-custom" aria-label="Agregar Periodos">
                                <a  href="{{ route('entregas.paquete_periodo',$datos->id ) }}"
                                    class="btn btn-sm edit btn-flat"><i class="fa-solid fa-calendar-days"></i>
                            </span>
                        </td>
                        @endcan

                        <td align="center" style="width:3%">
                            <span class="tts:left tts-slideIn tts-custom" aria-label="Entregar Paquete">
                                <a  href="{{ route('entregas.entrega_index',$datos->id) }}"
                                    class="btn btn-sm edit btn-flat"><i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </span>
                        </td>


                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-verdana-11">
                    <td colspan="12">
                        {{ $paquetes->appends(Request::all())->links() }}
                        <p class="text-muted">Mostrando
                            <strong>{{ $paquetes->count() }}</strong> registros de
                            <strong>{{ $paquetes->total() }}</strong> totales
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>


</div>

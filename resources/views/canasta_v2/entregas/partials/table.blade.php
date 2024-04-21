<div class="form-group row abs-center">
    <div class="col-md-8 pr-1 pl-1">
        <table class="table table-borderless hoverTable table-striped hover-orange" id="#" style="width:100%;">
            <thead>
                <tr class="font-roboto-11">
                    <td class="text-center p-1"><b>GESTION</b></td>
                    <td class="text-center p-1"><b>PERIODO</b></td>
                    <td class="text-center p-1"><b>DEA</b></td>
                    @canany(['canasta.paquete.editar','canasta.paquete.periodo','canasta.entregas.paquete.index'])
                        <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                    @endcanany
                </tr>
            </thead>
            <tbody>
                @foreach ($paquetes as $datos)
                    <tr class="font-roboto-11">
                    <td class="text-center p-1">{{ $datos->gestion }}</td>
                    <td class="text-center p-1">{{ $datos->periodo }}</td>
                    <td class="text-center p-1">{{ $datos->dea->descripcion }}</td>
                    @canany(['canasta.paquete.editar','canasta.paquete.periodo','canasta.entregas.paquete.index'])
                        <td class="text-center p-1">
                            @can('canasta.paquete.editar')
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Editar Paquete">
                                    <a href="{{ route('entregas.edit_paquete', $datos->id) }}" class="badge-with-padding badge badge-warning text-white">
                                        <i class="fa-regular fa-pen-to-square fa-fw"></i>
                                    </a>
                                </span>
                            @endcan
                            &nbsp;
                            @can('canasta.paquete.periodo')
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Agregar Periodos">
                                    <a  href="{{ route('entregas.paquete_periodo',$datos->id ) }}" class="badge-with-padding badge badge-success">
                                        <i class="fa-solid fa-calendar-days fa-fw"></i>
                                    </a>
                                </span>
                            @endcan
                            &nbsp;
                            @can('canasta.entregas.paquete.index')
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Entregar Paquete">
                                    <a  href="{{ route('entregas.entrega_index',$datos->id) }}" class="badge-with-padding badge badge-primary">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                </span>
                            @endcan
                        </td>
                    @endcanany
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-roboto-11">
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

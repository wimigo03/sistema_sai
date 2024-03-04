<div class="form-group row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-borderless hoverTable table-striped" id="#">
                <thead>
                    <tr class="font-verdana-sm">
                        <th class="text-left p-1">N°</th>
                        <th class="text-left p-1">CODIGO</th>
                        <th class="text-left p-1">CODIGO VSIAF</th>
                        <th class="text-center p-1">OFICINA</th>
                        <th class="text-center p-1">RESPONSABLE</th>
                        <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vehiculos as $vehiculo)
                        <tr class="font-verdana-sm">
                            <td class="text-left p-1" style="vertical-align: middle;">
                                {{ $loop->iteration }}
                            </td>
                            <td class="text-left p-1" style="vertical-align: middle;">
                                {{ $vehiculo->codigo }}
                            </td>
                            <td class="text-left p-1" style="vertical-align: middle;">
                                {{ $vehiculo->codigo_interno }}
                            </td>
                            <td class="text-left p-1" style="vertical-align: middle;">
                                {{ optional($vehiculo->actual->areas)->nombrearea }}</td>
                            <td class="text-left p-1" style="vertical-align: middle;">
                                {{ optional($vehiculo->actual->empleados)->full_name }}</td>
                            </td>
                            <td class="text-center p-1" style="vertical-align: middle;">
                                @include('activo.vehiculo.btn')
                            </td>
                        </tr>
                    @empty
                        <tr class="font-verdana-sm">
                            <td colspan="100%" class="text-center text-muted py-3">No existen Registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card-footer font-verdana-sm">
            {{ $vehiculos->links() }}
            <p class="text-muted">
                Mostrando
                <strong>{{ $vehiculos->count() }}</strong>
                registros de
                <strong>{{ $vehiculos->total() }}</strong>
                totales
            </p>
        </div>
    </div>
</div>

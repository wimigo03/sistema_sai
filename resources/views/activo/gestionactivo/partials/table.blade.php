<div class="form-group row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-borderless hoverTable table-striped" id="#">
                <thead>
                    <tr class="font-verdana-sm">
                        <th class="text-left p-1">N°</th>
                        <th class="text-left p-1">CODIGO</th>
                        <th class="text-left p-1">DESCRIPCION</th>
                        <th class="text-left p-1">GRUPO</th>
                        <th class="text-left p-1">AUXILIAR</th>
                        <th class="text-center p-1">OFICINA</th>
                        <th class="text-center p-1">RESPONSABLE</th>
                        <th class="text-center p-1">CARGO</th>
                        <th class="text-left p-1">CI</th>
                        <th class="text-center p-1">PREVENTIVO</th>
                        <th class="text-center p-1">ESTADO</th>
                        <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activos as $activo)
                        <tr class="font-verdana-sm">
                            <td class="text-left p-1" style="vertical-align: middle;">
                                {{ $loop->iteration }}
                            </td>
                            <td class="text-left p-1" style="vertical-align: middle;">
                                {{ $activo->codigo }}
                            </td>
                            <td class="text-left p-1" style="vertical-align: middle;">
                                {{ $activo->descrip }}
                            </td>
                            <td class="text-left p-1" style="vertical-align: middle;">
                                {{ optional($activo->codconts)->nombre }}</td>  
                                <td class="text-left p-1" style="vertical-align: middle;">
                                    {{ optional($activo->auxiliars)->nomaux }}</td>
                            <td class="text-left p-1" style="vertical-align: middle;">
                                {{ optional($activo->areas)->nombrearea }}</td>
                            <td class="text-left p-1" style="vertical-align: middle;">
                                {{ optional($activo->empleados)->full_name }}</td>
                            <td class="text-left p-1" style="vertical-align: middle;">
                                {{ optional(optional($activo->empleados)->file)->nombrecargo }}</td>
                                <td class="text-left p-1" style="vertical-align: middle;">
                                    {{ optional($activo->empleados)->ci }}
                                </td>
                                <td class="text-left p-1" style="vertical-align: middle;">
                                    {{ $activo->cod_rube }}</td>
                            <td class="text-center p-1" style="vertical-align: middle;">
                                <span class="badge {{ $activo->icono_estado }} badge-with-padding">
                                    {{ $activo->status }}
                                </span>
                            </td>
                            <td class="text-center p-1" style="vertical-align: middle;">
                                @include('activo.gestionactivo.btn')
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
            {{ $activos->links() }}
            <p class="text-muted">
                Mostrando
                <strong>{{ $activos->count() }}</strong>
                registros de
                <strong>{{ $activos->total() }}</strong>
                totales
            </p>
        </div>
    </div>
</div>

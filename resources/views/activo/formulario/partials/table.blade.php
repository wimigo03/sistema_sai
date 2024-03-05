<div class="form-group row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-borderless hoverTable table-striped" id="#">
                <thead>
                    <tr class="font-verdana-sm">
                        <th class="text-left p-1">N°</th>
                        <th class="text-center p-1">OFICINA</th>
                        <th class="text-center p-1">RESPONSABLE</th>
                        <th class="text-center p-1">CARGO</th>
                        <th class="text-center p-1">CI</th>
                        <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($formularios as $formulario)
                        <tr class="font-verdana-sm">
                            <td class="text-left p-1" style="vertical-align: middle;">
                                {{ $loop->iteration }}
                            </td>
                            <td class="text-left p-1" style="vertical-align: middle;">
                                {{ $formulario->empleado->empleadosareas->nombrearea }}
                            </td>
                            <td class="text-left p-1" style="vertical-align: middle;">
                                {{ $formulario->empleado->full_name }}
                            </td>
                            <td class="text-left p-1" style="vertical-align: middle;">
                                {{ $formulario->empleado->file->nombrecargo }}
                            </td>
                            <td class="text-left p-1" style="vertical-align: middle;">
                                {{ $formulario->empleado->ci }}
                            </td>
                            <td class="text-center p-1" style="vertical-align: middle;">
                                @include('activo.formulario.btn')
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
            {{ $formularios->links() }}
            <p class="text-muted">
                Mostrando
                <strong>{{ $formularios->count() }}</strong>
                registros de
                <strong>{{ $formularios->total() }}</strong>
                totales
            </p>
        </div>
    </div>
</div>

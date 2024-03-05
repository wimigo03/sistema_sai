<div class="form-group row pt-3">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-borderless hoverTable table-striped" id="#">
                <thead>
                    <tr class="font-verdana-sm">
                        <th class="text-left px-3 py-1">
                            <input type="checkbox" id="seleccionarTodo">
                        </th>
                        <th class="text-left p-1">CODIGO</th>
                        <th class="text-left p-1">DESCRIPCION</th>
                        <th class="text-left p-1">GRUPO</th>
                        <th class="text-left p-1">AUXILIAR</th>
                        <th class="text-center p-1">KARDEX DE OBSERVACIONES</th>
                        <th class="text-center p-1">ESTADO</th>
                        <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activos as $activo)
                    <tr class="font-verdana-sm">
                        <td class="text-left py-1 px-3" style="vertical-align: middle;">
                            <input type="checkbox" class="seleccionarFila">
                        </td>
                        <td class="text-left p-1 codigo" style="vertical-align: middle;">{{ $activo->codigo }}</td>
                        <td class="text-left p-1 descrip" style="vertical-align: middle;">{{ $activo->descrip }}</td>
                        <td class="text-left p-1" style="vertical-align: middle;">
                            {{ optional($activo->codconts)->nombre }}
                        </td>
                        <td class="text-left p-1" style="vertical-align: middle;">
                            {{ optional($activo->auxiliar)->nomaux }}
                        </td>
                        <td class="text-left p-1" width="150x" style="vertical-align: middle;">
                            {{ $activo->observaciones }}
                        </td>
                        <td class="text-center p-1" style="vertical-align: middle;">
                            <span class="badge {{ $activo->icono_estado }} codestado badge-with-padding">{{ $activo->status }}</span>
                        </td>
                        <td class="text-center p-1" style="vertical-align: middle;">
                            @include('activo.responsableActivo.btn')
                        </td>
                        <td class="d-none id">{{ $activo->id }}</td>
                        <td class="d-none codemp">{{ $empleado->idemp }}</td>
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
            <p class="text-muted">
                Mostrando
                <strong>{{ $activos->count() }}</strong>
                registros
                totales
            </p>
        </div>
    </div>
</div>

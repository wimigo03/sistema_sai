<div class="form-group row">
    <div class="col-md-12">
        <table class="table table-borderless hoverTable table-striped" id="#">
            <thead>
                <tr class="font-verdana-sm">
                    <th class="text-left p-1">FILE</th>
                    <th class="text-left p-1">INGRESO</th>
                    <th class="text-left p-1">AREA</th>
                    <th class="text-left p-1">NOMBRES</th>
                    <th class="text-left p-1">AP. PATERNO</th>
                    <th class="text-left p-1">AP. MATERNO</th>
                    <th class="text-left p-1">CARGO</th>
                    <th class="text-left p-1">NOMBRE CARGO</th>
                    <th class="text-left p-1">CATEGORIA</th>
                    <th class="text-left p-1">N. ADM</th>
                    <th class="text-left p-1">CLASE</th>
                    <th class="text-left p-1">N. SAL.</th>
                    <th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>
                </tr>
            </thead>
            <tbody>
                @if (count($empleadoss) > 0)
                    @foreach ($empleadoss as $empleado)
                        <tr class="font-verdana-sm">
                            <td class="text-left p-1" style="vertical-align: middle;">{{ $empleado->file->numfile }}</td>
                            <td class="text-left p-1" style="vertical-align: middle;">{{ $empleado->fechingreso != null ? \Carbon\Carbon::parse($empleado->fechingreso)->format('d/m/y') : '' }}</td>
                            <td class="text-left p-1" style="vertical-align: middle;">{{ $empleado->area->nombrearea }}</td>
                            <td class="text-left p-1" style="vertical-align: middle;">{{ $empleado->nombres }}</td>
                            <td class="text-left p-1" style="vertical-align: middle;">{{ $empleado->ap_pat }}</td>
                            <td class="text-left p-1" style="vertical-align: middle;">{{ $empleado->ap_mat }}</td>
                            <td class="text-left p-1" style="vertical-align: middle;">{{ $empleado->file->cargo }}</td>
                            <td class="text-left p-1" style="vertical-align: middle;">{{ $empleado->file->nombrecargo }}</td>
                            <td class="text-left p-1" style="vertical-align: middle;">{{ $empleado->file->categoria }}</td>
                            <td class="text-left p-1" style="vertical-align: middle;">{{ $empleado->file->niveladm }}</td>
                            <td class="text-left p-1" style="vertical-align: middle;">{{ $empleado->file->clase }}</td>
                            <td class="text-left p-1" style="vertical-align: middle;">{{ $empleado->file->nivelsal }}</td>
                            <td class="text-center p-1" style="vertical-align: middle;">
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
                                    <a href="{{ route('planta.listageneral.show',$empleado->idemp) }}" class="btn btn-xs btn-outline-primary">
                                        <i class="fa fa-lg fa-list" aria-hidden="true"></i>
                                    </a>
                                </span>                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <div class="card-footer font-verdana-sm">
            {{ $empleadoss->links() }}
            <p class="text-muted">
                Mostrando 
                <strong>{{ $empleadoss->count() }}</strong> 
                registros de 
                <strong>{{$empleadoss->total() }}</strong> 
                totales
            </p>
        </div>
    </div>
</div>
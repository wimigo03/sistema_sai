<div class="form-group row font-roboto-11 abs-center">
    <div class="col-md-10 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="dataTable">
            <thead>
                <tr class="font-roboto-11">
                    <th class="text-justify p-1"><b>N°</b></th>
                    <th class="text-center p-1"><b>TIPO DE ARCHIVO</b></th>
                    <th class="text-center p-1"><b>CODIGO</b></th>
                    <th class="text-center p-1"><b>SUBTIPO</b></th>
                    <th class="text-center p-1"><b>ESTADO</b></th>
                    @can('tipos.archivos.eliminar')
                        <th class="text-center p-1">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                        </th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @php
                    $num = 1;
                @endphp
                    @forelse ($tipoareas as $key => $tipoarea)
                    <tr class="font-roboto-11">
                        <td class="text-justify p-1">{{ $key+1 }}</td>
                        <td class="text-justify p-1">{{ $tipoarea->nombretipo }}</td>
                        <td class="text-center p-1">{{ $tipoarea->codigo }}</td>
                        <td class="text-center p-1">{{ $tipoarea->subtipo == '1' ? 'SALIDA' : 'ENTRADA' }}</td>
                        <td class="text-center p-1">{{ $tipoarea->estado == '1' ? 'HABILITADO' : 'NO HABILITADO' }}</td>
                        @can('tipos.archivos.eliminar')
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    <span class="tts:left tts-slideIn tts-custom mr-1" aria-label="Eliminar" style="cursor: pointer;">
                                        <a href="{{ route('tipos.archivos.delete',$tipoarea->idtipoarea) }}" class="badge-with-padding badge badge-danger" onclick="return confirm('Esta seguro que desea eliminar el Item...')">
                                            <i class="fas fa-trash fa-fw"></i>
                                        </a>
                                    </span>
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                                        <a href="{{ route('tipos.archivos.editar',$tipoarea->idtipo) }}" class="badge-with-padding badge badge-secondary">
                                            <i class="fas fa-edit fa-fw"></i>
                                        </a>
                                    </span>
                                </div>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="form-group row font-roboto-11">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="dataTable">
            <thead>
                <tr class="font-roboto-11">
                    <th class="text-justify p-1"><b>N°</b></th>
                    <th class="text-center p-1"><b>TIPO DE ARCHIVO</b></th>
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
                        @can('tipos.archivos.eliminar')
                            <td class="text-center p-1">
                                <div class="d-flex justify-content-center">
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Eliminar" style="cursor: pointer;">
                                        <a href="{{ route('tipos.archivos.delete',$tipoarea->idtipoarea) }}" class="badge-with-padding badge badge-danger" onclick="return confirm('Esta seguro que desea eliminar el Item...')">
                                            <i class="fas fa-trash fa-fw"></i>
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

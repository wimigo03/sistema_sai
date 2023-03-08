@can('medidas_edit')
  <a href="{{ route('areas.edit', $idarea)}}" class="btn btn-xs btn-success btn-sm" title="Editar File">
            <i class="fas fa-pencil-alt text-white" aria-hidden="true"></i>
        </a>
@endcan
&nbsp;&nbsp;
@can('file_planta_access')
  <a href="{{ route('areas.file', $idarea)}}" sstyle="color:white;" class="btn btn-xs btn-info btn-sm" title="Files Planta">
            <i class="fas fa-file-alt fa-lg" aria-hidden="true"></i>
        </a>
@endcan
&nbsp;&nbsp;
@can('file_contrato_access')
  <a href="{{ route('areas.file2', $idarea)}}"style="color:white;" class="btn btn-xs btn-warning btn-sm" title="Files Contrato">
            <i class="fas fa-file-alt fa-lg" aria-hidden="true"></i>
        </a>
@endcan

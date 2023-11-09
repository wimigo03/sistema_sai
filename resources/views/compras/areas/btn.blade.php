@can('medidas_edit')
  <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar">
    <a href="{{ route('areas.edit', $idarea)}}">
    &nbsp;<i class="fas fa-edit" style="color:rgb(26, 162, 16)"></i>&nbsp;
    </a>
  </span>
@endcan
@can('file_planta_access')
  <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a Files de planta">
    <a href="{{ route('areas.file', $idarea)}}">
    &nbsp;<i class="fas fa-file-alt" style="color:blue"></i>&nbsp;
    </a>
  </span>
@endcan
@can('file_contrato_access')
  <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a Files de contrato">
    <a href="{{ route('areas.file2', $idarea)}}">
    &nbsp;<i class="fas fa-file" style="color:orange"></i>&nbsp;
    </a>
  </span>
@endcan

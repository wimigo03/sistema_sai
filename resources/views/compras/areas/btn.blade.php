
  <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar">
    <a href="{{ route('areas.edit', $idarea)}}">
      <i class="fas fa-edit" style="color:rgb(26, 162, 16)"></i>
    </a>
  </span>

  <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a personal de planta">
    <a href="{{ route('areas.file', $idarea)}}">
        <i class="fas fa-file-alt" style="color:blue"></i>
    </a>
  </span>


  <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a personal de contrato">
    <a href="{{ route('areas.file2', $idarea)}}">
        <i class="fas fa-file" style="color:orange"></i>
    </a>
  </span>


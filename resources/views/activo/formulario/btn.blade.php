<span class="d-flex">
    @can('actual_edit')
        <span class="tts:left tts-slideIn tts-custom" aria-label="Editar registro">
            <a class="mr-2" href="{{ route('activo.formulario.edit', $formulario->id) }}">
                <i class="fas fa-edit fa-xl" style="color: yellowgreen"></i>
            </a>
        </span>
        <span class="tts:left tts-slideIn tts-custom" aria-label="Ver Formulario">
            <a class="mr-2" href="{{ route('formulario', $formulario->id) }}" target="_blank">
                <i class="fa-solid fa-file-pdf fa-xl" style="color:crimson"></i>
            </a>
        </span>
    @endcan
</span>

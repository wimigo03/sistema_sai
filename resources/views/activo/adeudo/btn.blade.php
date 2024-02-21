<span class="d-flex">
    @can('actual_edit')
        <span class="tts:left tts-slideIn tts-custom" aria-label="Ver registro">
            <a class="mr-2" href="{{ route('activo.adeudo.show', $adeudo->id) }}">
                <i class="fas fa-eye fa-xl" style="color: cadetblue"></i>
            </a>
        </span>
        <span class="tts:left tts-slideIn tts-custom" aria-label="Editar registro">
            <a class="mr-2" href="{{ route('activo.adeudo.edit', $adeudo->id) }}">
                <i class="fas fa-edit fa-xl" style="color: yellowgreen"></i>
            </a>
        </span>
        <span class="tts:left tts-slideIn tts-custom" aria-label="Ver Certificado">
            <a class="mr-2" href="{{ route('certificado', $adeudo->id) }}" target="_blank">
                <i class="fa-solid fa-file-pdf fa-xl" style="color:crimson"></i>
            </a>
        </span>
    @endcan
</span>

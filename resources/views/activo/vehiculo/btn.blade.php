<span class="d-flex">
    @can('actual_edit')
        <span class="tts:left tts-slideIn tts-custom" aria-label="Ver activo">
            <a class="mr-2" href="{{ route('activo.vehiculo.show', $vehiculo->id) }}">
                <i class="fas fa-eye fa-xl" style="color: cadetblue"></i>
            </a>
        </span>
        <span class="tts:left tts-slideIn tts-custom" aria-label="Editar vehiculo">
            <a class="mr-2" href="{{ route('activo.vehiculo.edit', $vehiculo->id) }}">
                <i class="fas fa-edit fa-xl" style="color: yellowgreen"></i>
            </a>
        </span>
        <span class="tts:left tts-slideIn tts-custom" aria-label="Ver checklist">
            <a class="mr-2" href="{{ route('vehiculo.checklist.index', $vehiculo->id) }}">
                <i class="fa-solid fa-file-pdf fa-xl" style="color:crimson"></i>
            </a>
        </span>
    @endcan
</span>

<td class="text-center p-1">
    <div class="d-flex justify-content-center">
        @can('canasta.barrios.editar')
            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar" style="cursor: pointer;">
                <a href="{{ route('ocupacion.editar', $ocupacion_id) }}" class="badge-with-padding badge badge-warning">
                    <i class="fa-solid fa-pen-to-square fa-fw"></i>
                </a>
            </span>
        @endcan
    </div>
</td>

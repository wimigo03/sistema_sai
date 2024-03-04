<span class="d-flex">
    @can('actual_edit')
    <span class="tts:left tts-slideIn tts-custom" aria-label="Ver Activo">
        <a class="mr-2" href="{{ route('activo.gestionactivo.show', $id) }}">
            <i class="fas fa-eye fa-xl" style="color: cadetblue"></i>
        </a>
    </span>
    <span class="tts:left tts-slideIn tts-custom" aria-label="Ver Archivos">
        <a class="mr-2" href="{{ route('activo.archivo.index', $id) }}">
            <i class="fa-solid fa-file-pdf fa-xl" style="color: rgb(110, 160, 95))"></i>
        </a>
    </span>
    <span class="tts:left tts-slideIn tts-custom" aria-label="Editar Activo">
        <a class="mr-2" href="{{ route('activo.gestionactivo.edit', $id) }}">
            <i class="fas fa-edit fa-xl" style="color: yellowgreen"></i>
        </a>
    </span>
    @endcan
    <span class="tts:left tts-slideIn tts-custom" aria-label="Ver Iagenes">
        <a class="mr-2" href="{{ route('activo.responsable.imagen.index', $id) }}">
            <i class="fas fa-images fa-xl" style="color: blue"></i>
        </a>
    </span>
    <span class="tts:left tts-slideIn tts-custom" aria-label="Ver Ubicaciones">
        <a class="mr-2" href="{{ route('activo.ubicaciones.index', $id) }}">
            <i class="fas fa-map-marker-alt fa-xl" style="color: red"></i>
        </a>
    </span>
    <span class="tts:left tts-slideIn tts-custom" aria-label="Ver Codigo de Barras">
        <a href="#" class="mr-2" id="ver-codigo" data-id="{{ $id }}" data-descripcion="{{ $descrip }}"
            data-codigo="{{ $codigo }}">
            <i class="fas fa-barcode fa-xl" style="color:black"></i>
        </a>
    </span>
</span>

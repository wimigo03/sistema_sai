<span class="d-flex">
    @can('actual_edit')
        <a class="" href="{{ route('activo.gestionactivo.edit', $id) }}">
            <i class="fas fa-edit fa-xl mr-2" style="color: yellowgreen"></i>
        </a>
    @endcan
    <a class="" href="{{ route('activo.responsable.imagen.index', $id) }}">
        <i class="fas fa-images fa-xl mr-2" style="color: blue"></i>
    </a>
    <a class="" href="{{ route('activo.ubicaciones.index', $id) }}">
        <i class="fas fa-map-marker-alt fa-xl mr-2" style="color: red"></i>
    </a>
    <span class=" mr-2" aria-label="Ver codigo de barras">
        <a href="#" id="ver-codigo" data-id="{{ $id }}" data-descripcion="{{ $descrip }}"
            data-codigo="{{ $codigo }}">
            <i class="fas fa-barcode fa-xl" style="color:black"></i>
        </a>
    </span>
</span>

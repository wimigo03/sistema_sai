<span class="d-flex">
    <span class=" ml-3" aria-label="Modificar Activo">
        <a href="#" id="editar-archivo" data-id="{{ $id }}" data-descripcion="{{ $descrip }}"
        data-codigo="{{ $codigo }}" data-activo_id="{{ $activo_id }}" data-estado="{{ $estado }}">
        <i class="fas fa-edit" style="color:rgb(171, 201, 41)"></i>
    </a>
    </span>
    <span class="ml-3" aria-label="Eliminar Activo">
        <a href="#" class="eliminar-activo" data-id="{{ $id }}">
            <i class="fas fa-trash" style="color:red"></i>
        </a>
    </span>
</span>

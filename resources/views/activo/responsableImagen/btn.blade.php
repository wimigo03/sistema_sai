<span class="" aria-label="Ver imagen">
    <a href="{{ asset('public/images/' . $ruta) }}" target="_blank">
        <i class="fas fa-eye" style="color:rgb(16, 74, 162)"></i>
    </a>
</span>
<span class=" ml-3" aria-label="Modificar imagen">
    <a href="#" id="editar-imagen" data-id="{{ $id }}" data-descripcion="{{ $descripcion }}"
        data-otro-dato="{{ $created_at }}">
        <i class="fas fa-edit" style="color:rgb(171, 201, 41)"></i>
    </a>
</span>

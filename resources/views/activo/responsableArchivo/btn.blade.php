<span class="" aria-label="Ver Archivo">
    <a href="{{ asset('public/archivos/' . $ruta) }}" target="_blank">
        <i class="fas fa-eye" style="color:rgb(16, 74, 162)"></i>
    </a>
</span>
<span class=" ml-3" aria-label="Modificar Archivo">
    <a href="#" id="editar-archivo" data-id="{{ $id }}" data-descripcion="{{ $descripcion }}"
        data-otro-dato="{{ $created_at }}">
        <i class="fas fa-edit" style="color:rgb(171, 201, 41)"></i>
    </a>
</span>

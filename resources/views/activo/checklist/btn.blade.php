<span class="" aria-label="Ver archivo">
    <a href="{{ asset('public/archivos/' . $ruta) }}" target="_blank">
        <i class="fas fa-eye" style="color:rgb(16, 74, 162)"></i>
    </a>
</span>
<span class=" ml-3" aria-label="Modificar archivo">
    <a href="#" id="editar-archivo" data-id="{{ $id }}" data-descripcion="{{ $descripcion }}"
        data-fecha_inspeccion="{{ $fecha_inspeccion }}" data-gestion="{{ $gestion }}">
        <i class="fas fa-edit" style="color:rgb(171, 201, 41)"></i>
    </a>
</span>

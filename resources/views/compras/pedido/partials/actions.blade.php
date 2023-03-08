<td class="text-center p-1">
    @can('medidas_access')
        <a href="pedido/{{$idcompra}}/editar" class="btn btn-xs btn-outline-warning">
            <i class="fas fa-edit" aria-hidden="true"></i>
        </a>
    @endcan   
        <a href="pedido/{{$idcompra}}/edit" class="btn btn-xs btn-outline-info">
            <i class="fas fa-list" aria-hidden="true"></i>
        </a>
</td>
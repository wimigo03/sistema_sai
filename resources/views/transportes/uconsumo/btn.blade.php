
<td style="padding: 0;" class="text-center p-1">
     @can('unidadconsumot_edit') 
        <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar">
            <a href="{{route('transportes.uconsumo.editar',$idunidadconsumo)}}">
                <span class="text-warning">
                    <i class="fa-solid fa-2xl fa-square-pen"></i>
                </span>
            </a>
        </span>
     @endcan 
</td>


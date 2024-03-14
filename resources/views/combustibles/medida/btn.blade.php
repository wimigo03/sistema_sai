<center>
    
    <td style="padding: 0;" class="text-center p-1">
        @can('medidacomb.edit')

            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar">
                <a href="{{ route('medidacomb.edit',$idmedida) }}">
                    <span class="text-primary">
                        <i class="fas fa-lg fa-edit"></i>
                    </span>
                </a>
            </span>

    
            @endcan
    </td>
         
</center>
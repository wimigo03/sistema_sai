<center>     
    <td style="padding: 0;" class="text-center p-1">
        @can('catprog_edit')
            <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar">
                <a href="{{ route('catprog.edit',$idcatprogramatica) }}">
                    <span class="text-primary">
                        <i class="fas fa-xl fa-edit"></i>
                    </span>
                </a>
            </span>
        @endcan
    </td>
</center>
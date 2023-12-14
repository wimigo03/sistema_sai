<center>
    <table style="border-collapse:collapse; border: none;">
        <tr>
            <td style="padding: 0;">
                
                    <span class="tts:left tts-slideIn tts-custom" aria-label="Ir a detalle">
                        <a href="{{route('admin.roles.show',$id)}}">
                            <span class="text-primary">
                                <i class="fa-solid fa-2xl fa-square-info"></i>
                            </span>
                        </a>
                    </span>
              
            </td>
            <td style="padding: 0;">
               
                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar">
                        <a href="{{route('admin.roles.edit',$id)}}">
                            <span class="text-warning">
                                <i class="fa-solid fa-2xl fa-pen-to-square"></i>
                            </span>
                        </a>
                    </span>
               
            </td>
            <td style="padding: 0;">
               
                    <form action="{{ route('admin.roles.destroy', $id) }}" class="d-inline-block" method="post">
                        @csrf
                        @method('DELETE')
                        <span type="submit" onclick="return confirm('Esta Ud. seguro?')">
                            <span class="text-danger">
                                <i class="fa-solid fa-xl fa-trash" aria-hidden="true"></i>
                            </span>
                        </span>
                    </form>
              
            </td>
        </tr>
    </table>
</center>
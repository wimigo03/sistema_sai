<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>

    <div class="page-header" align="center">
        <img src="{{ asset('logos/header.jpg') }}" width="700px" height="70px" />
    </div>

    <div class="page-footer" align="center">

        <img src="{{ asset('logos/footer.jpg') }}" width="700px" height="50px" />

    </div>

    <table  border="0" cellspacing="0" cellpadding="0">

      <thead>
        <tr>
          <td>
            <!--place holder for the fixed-position header-->
            <div class="page-header-space"></div>
          </td>
        </tr>
      </thead>

      <tbody >

        <tr>
            <td align="right">
                Yacuiba, {{$fechaInvitacion}}
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                Sr.
            </td>
        </tr>
        <tr>
            <td>
                {{$responsables->nombrerespcontrat}}
            </td>
        </tr>
        <tr>
            <td>
                <b>RESPONSABLE DEL PROCESO DE CONTRATACIÓN (RPA)</b>
                <br>
                <b>GOBIERNO AUTONOMO REGIONAL DEL GRAN CHACO</b>
            </td>
        </tr>
        <tr>
            <td>
                Referente.-
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <b>REF.: ACEPTACIÓN A LA INVITACIÓN REALIZADA EN EL PROCESO DE CONTRATACIÓN MENOR</b>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                De mi mayor consideracion:
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td >
                Mediante la presente manifiesto mi aceptación a invitación recibida en fecha {{$fechaInvitacion}}, para el
                Proceso de Contratación denominado {{$ordencompra->nombrecompra}} , adjunto a la misma la documentación solicitada:

        </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>

            @forelse ($ordendoc as $key => $value)
            <tr >

                <td> {{$key+1 . '.- ' . $value -> nombredoc}}</td>

            </tr>
            @empty

            @endforelse
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="justify">
                Sin otro particular motivo esperando una respuesta positiva me despido con la mayor consideración.
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td>Atentamente</td>
        </tr>
        <tr>
            <td>&nbsp;</td>

        <tr>
            <td align="center">
                {{$ordencompra->representante}}
            </td>
        </tr>
        <tr>
            <td align="center">
                <b>C.I. N° {{$ordencompra->cedula}}</b>
            </td>
        </tr>



      </tbody>

      <tfoot>
        <tr>
          <td>
            <!--place holder for the fixed-position footer-->
            <div class="page-footer-space"></div>
          </td>

        </tr>
      </tfoot>

    </table>



    </body>

</html>

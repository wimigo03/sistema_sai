<!DOCTYPE html>
<html lang="es">

{{-- <head>
    <link rel="stylesheet" href="style.css" />
  </head> --}}

  <body>
    
    <div>
        <p align="center"  style="text-decoration: underline;font-size: 12px;">
            <strong>COMUNICACION INTERNA</strong>
        </p>
        <p align="center" style="text-decoration: underline;font-size: 12px;">
            <strong>N° {{$soluconsumos->cominterna}}/2024</strong>
        </p>
        <p align="center" style="text-decoration: underline;font-size: 12px;">
            <strong>{{$soluconsumos->oficina}}</strong>
        </p>

        <table border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;">

            <tbody>
                <tr >
                    <td width="34" valign="top">
                        <p>
                            <strong>A:</strong>
                           
                        </p>
                    </td>
                    <td width="500" valign="top" >
                        <p>
                            {{$soluconsumos->dirnombre}}<br>
                            <strong>{{$soluconsumos->diracargo}} </strong>
                        </p>
                    
                    </td>
                </tr>
              
            </tbody>
        </table>


       
        <table border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;">
            <tbody>
                <tr>
                    <td width="37" valign="top">
                        <p>
                            <strong>VIA:</strong>

                        </p>
                    </td>
                    <td width="500" valign="top">
                        <p>
                            {{$soluconsumos->viaunonombre}}<br>
                            <strong> {{$soluconsumos->viaunocargo}}</strong>
                        </p>
                    </td>
                </tr>
              
            </tbody>
        </table>

        <table border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;">
            <tbody>
                <tr>
                    <td width="37" valign="top">
                        <p>
                            <strong>VIA:</strong>

                        </p>
                    </td>
                    <td width="500" valign="top">
                        <p>
                            {{$soluconsumos->viadosnombre}}<br>
                            <strong> {{$soluconsumos->viadoscargo}}</strong>
                        </p>
                    </td>
                </tr>
              
            </tbody>
        </table>

        <table border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;">
            <tbody>
                <tr>
                    <td width="37" valign="top">
                        <p>
                            <strong>DE:</strong>

                        </p>
                    </td>
                    <td width="500" valign="top">
                        <p>
                            {{$soluconsumos->usuarionombre}}<br>
                            <strong> {{$soluconsumos->usuariocargo}}</strong>
                        </p>
                    </td>
                </tr>
             
            </tbody>
        </table>

       
        <table border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;">
            <tbody>
                <tr>
                    <td width="37" valign="top">
                        <p>
                            <strong>REF:</strong>

                        </p>
                    </td>
                    <td width="500" valign="top" style="text-decoration: underline;">
                        <p style="text-decoration: underline;">
                            {{$soluconsumos->referencia}}
                        </p>
                    </td>
                </tr>
              
            </tbody>
        </table>

            

    </div>

    <div>
        <p style="font-size: 12px;">
            <strong>Fecha: </strong>
            Yacuiba, {{$fechaSol}}
        </p>

        
        <p style="font-size: 12px;">
            De mi mayor consideración:
        </p>
        <p style="font-size: 12px;">
            El motivo de la presente, es para solicitar a su persona, instruya a quien conrresponda la asignacion de una camioneta mas su combustible para mi persona,
            {{$soluconsumos->detallesouconsumo}}.
        </p>
       
       
      
        <table border="5" cellspacing="0" cellpadding="0" width="40%" 
        style=" border: 1px solid black;border-collapse: collapse;font-size: 12px;">
            <tbody>


                <tr width="244" >

                    <td width="44" valign="top">
                        <p>
                            <strong>DIA</strong>
                        <p>
                    </td>

                    <td width="54" valign="top">
                        <p>
                            <strong>FECHA SALIDA</strong>
                        <p>
                    </td>

                    <td width="54" valign="top">
                        <p>

                            <strong>FECHA RETORNO</strong>
                        <p>
                    </td>
                    <td width="54" valign="top">
                        <p>

                            <strong>DESTINO</strong>
                        <p>
                    </td>
                    <td width="54" valign="top">
                        <p>

                            <strong>TIPO</strong>
                        <p>
                    </td>
                </tr>


                <tr style="font-size: 12px;" width="244">

                    <td width="44" valign="top">
                        <p>
                            <strong>{{$diaSemana}}</strong><br>

                                                
                        <p>
                    </td>
                    
                    <td width="54" valign="top">
                        <p>
                            <strong>{{$fechaSalida}}</strong>
                            
                            
                            <br>

                            @if($soluconsumos->tsalida == 1)
                           En la mañana
                        @elseif($soluconsumos->tsalida == 2)
                        En la tarde
                        @else
                            -
                        @endif
                                                
                        <p>
                    </td>
                    <td width="54" valign="top">
                        <p>

                            <strong> {{$fechaRetorno}}</strong>
                           
                            
                            <br>

                            @if($soluconsumos->tllegada == 1)
                            En la mañana
                         @elseif($soluconsumos->tllegada == 2)
                         En la tarde
                         @else
                             -
                         @endif
                        <p>
                    </td>
                    <td width="54" valign="top">
                        <p>

                            <strong>{{$localidades->nombrelocalidad}}</strong> &nbsp;Distrito
                            <strong>{{$localidades->distrito}}</strong>
                        <p>
                    </td>
                    <td width="54" valign="top">
                        <p>

                            @if($soluconsumos->tiposoluconsumo == 1)
                            <strong>GASOLINA</strong>
                     
                         @elseif($soluconsumos->tiposoluconsumo == 2)
                         <strong>DIESEL</strong>
                       
                         @else
                             -
                         @endif
                        <p>
                        <p>
                    </td>
                </tr>
              
            </tbody>
        </table>

        <p style="font-size: 12px;">
            Sin otro particular motivo saludo a usted.
        </p>
        <p style="font-size: 12px;">
            Atentamente.
        </p>
   
      
        <table border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;">
            <tbody>
                <tr>
                    <td width="207" valign="top">
                        <p>
                            

                        </p>
                    </td>
                    <td width="500" valign="top">
                        <p>
                            {{$soluconsumos->usuarionombre}}<br>
                            <strong> {{$soluconsumos->usuariocargo}}</strong>
                        </p>
                    </td>
                </tr>
             
            </tbody>
        </table>    
      
    </div>

    
    </body>

</html>

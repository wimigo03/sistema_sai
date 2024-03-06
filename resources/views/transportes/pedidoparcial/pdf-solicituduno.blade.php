<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    
    <div>
        <p align="center"  style="text-decoration: underline;">
            <strong>COMUNICACION INTERNA</strong>
        </p>
        <p align="center" style="text-decoration: underline;">
            <strong>N° {{$soluconsumos->cominterna}}/2023</strong>
        </p>
        <p align="center" style="text-decoration: underline;">
            <strong>{{$soluconsumos->oficina}}</strong>
        </p>

        <table border="0" cellspacing="0" cellpadding="0">

            <tbody>
                <tr>
                    <td width="34" valign="top">
                        <p>
                            <strong>A:</strong>
                           
                        </p>
                    </td>
                    <td width="500" valign="top">
                        <p>
                            {{$soluconsumos->dirnombre}}<br>
                            <strong>{{$soluconsumos->diracargo}} </strong>
                        </p>
                    
                    </td>
                </tr>
              
            </tbody>
        </table>


       
        <table border="0" cellspacing="0" cellpadding="0">
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

        <table border="0" cellspacing="0" cellpadding="0">
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

        <table border="0" cellspacing="0" cellpadding="0">
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

       
        <table border="0" cellspacing="0" cellpadding="0">
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
        <p>
            <strong>Fecha: </strong>
            Yacuiba, {{$fechaSol}}
        </p>

        
        <p>
            De mi mayor consideración:
        </p>
        <p>
            El motivo de la presente, es para solicitar a su persona, instruya a quien conrresponda
            {{$soluconsumos->detallesouconsumo}}.
        </p>
       
       
      
        <table border="1" cellspacing="0" cellpadding="0" width="100%" 
        style=" border: 1px solid black;border-collapse: collapse;">
            <tbody>


                <tr style="font-size: 12px;">

                    <td width="104" valign="top">
                        <p>
                            <strong>DIA</strong>
                        <p>
                    </td>

                    <td width="104" valign="top">
                        <p>
                            <strong>FECHA SALIDA</strong>
                        <p>
                    </td>

                    <td width="104" valign="top">
                        <p>

                            <strong>FECHA RETORNO</strong>
                        <p>
                    </td>
                    <td width="104" valign="top">
                        <p>

                            <strong>DESTINO</strong>
                        <p>
                    </td>
                    <td width="104" valign="top">
                        <p>

                            <strong>TIPO</strong>
                        <p>
                    </td>
                </tr>


                <tr style="font-size: 12px;">

                    <td width="104" valign="top">
                        <p>
                            <strong>{{$diaSemana}}</strong><br>

                                                
                        <p>
                    </td>
                    
                    <td width="104" valign="top">
                        <p>
                            <strong>{{$fechaSalida}}</strong><br>

                            @if($soluconsumos->tsalida == 1)
                           En la mañana
                        @elseif($soluconsumos->tsalida == 2)
                        En la tarde
                        @else
                            -
                        @endif
                                                
                        <p>
                    </td>
                    <td width="104" valign="top">
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
                    <td width="104" valign="top">
                        <p>

                            <strong>{{$localidades->nombrelocalidad}}</strong>
                            
                        <p>
                    </td>
                    <td width="104" valign="top">
                        <p>

                            @if($soluconsumos->tiposoluconsumo == 1)
                            GASOLINA
                         @elseif($soluconsumos->tiposoluconsumo == 2)
                         DIESEL
                         @else
                             -
                         @endif
                        <p>
                        <p>
                    </td>
                </tr>
              
            </tbody>
        </table>

        <p>
            Sin otro particular motivo saludo a usted.
        </p>
        <p>
            Atentamente.
        </p>
        <br><br><br><br><br><br><br>
        <p>
            Detalle de la unidad.
        </p>
     
     
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td width="37" valign="top">
                        <p>
                            <strong>Nombre:</strong>

                        </p>
                    </td>
                    <td width="500" valign="top">
                        <p>
                            {{$prodserv->nombreuconsumo}}<br>
                            {{-- <strong> {{$soluconsumos->usuariocargo}}</strong> --}}
                        </p>
                    </td>
                </tr>
             
            </tbody>
        </table>
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td width="37" valign="top">
                        <p>
                            <strong>Marca:</strong>

                        </p>
                    </td>
                    <td width="500" valign="top">
                        <p>
                            {{$prodserv->nombremarca}}<br>
                            {{-- <strong> {{$soluconsumos->usuariocargo}}</strong> --}}
                        </p>
                    </td>
                </tr>
             
            </tbody>
        </table>
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td width="37" valign="top">
                        <p>
                            <strong>Placa:</strong>

                        </p>
                    </td>
                    <td width="500" valign="top">
                        <p>
                            {{$prodserv->placaconsum}}<br>
                            {{-- <strong> {{$soluconsumos->usuariocargo}}</strong> --}}
                        </p>
                    </td>
                </tr>
             
            </tbody>
        </table>
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td width="37" valign="top">
                        <p>
                            <strong>Chofer:</strong>

                        </p>
                    </td>
                    <td width="500" valign="top">
                        <p>
                            {{$prodserv->chofernombre}}<br>
                            {{-- <strong> {{$soluconsumos->usuariocargo}}</strong> --}}
                        </p>
                    </td>
                </tr>
             
            </tbody>
        </table>
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td width="37" valign="top">
                        <p>
                            <strong>Telefono:</strong>

                        </p>
                    </td>
                    <td width="500" valign="top">
                        <p>
                            {{$prodserv->telefono}}<br>
                            {{-- <strong> {{$soluconsumos->usuariocargo}}</strong> --}}
                        </p>
                    </td>
                </tr>
             
            </tbody>
        </table>
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td width="67" valign="top">
                        <p>
                            <strong>klm actual:</strong>

                        </p>
                    </td>
                    <td width="500" valign="top">
                        <p>
                            {{$prodserv->kilometrajeactual}}<br>
                            {{-- <strong> {{$soluconsumos->usuariocargo}}</strong> --}}
                        </p>
                    </td>
                </tr>
             
            </tbody>
        </table>
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td width="67" valign="top">
                        <p>
                            <strong>Imagen dos:</strong>

                        </p>
                    </td>
                    <td width="500" valign="top">
                        <p>
                           
                          
                            
                            <img src="{{ $rutaImagendos }}" alt="Descripción de la imagen" width="170" height="170">
                           
                           
                          
                        </p>

                        
                    </td>
                </tr>
             
            </tbody>
        </table>










    </div>

    
    </body>

</html>

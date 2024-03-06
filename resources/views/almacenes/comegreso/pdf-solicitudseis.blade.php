<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    
    <div>
        <p align="center"  >
            <strong style=" font-size: 20px;">GOBIERNO AUTONOMO REGIONAL</strong>  <br  >
            <strong style=" font-size: 20px;">DEL GRAN CHACO</strong> 
        </p>

    </div>

    <div>
        <p align="center"  >
            <strong  style=" font-size: 30px;  ">NOTA DE SALIDA</strong> <strong>Numero:</strong> <strong></strong>
             <strong>{{$comegreso->idcomegreso}}</strong>
        </p>

        <table border="0" cellspacing="0" cellpadding="0">

            <tbody>
                <tr>
                    <td width="150" valign="top">
                        <p>
                            Fecha:  <strong>{{$Fechayhorartraaprob}}</strong>
                                <br>
                            </p>
                           
                        </p>
                    </td>
                  
                </tr>
              
            </tbody>
        </table>


       
        <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td width="70" valign="top">
                        <p>
                            <strong>Prog/Proy.:</strong>

                        </p>
                    </td>
                    <td width="500" valign="top">
                        <p>
                            {{$comingreso->codcatprogramatica}}   &nbsp;/&nbsp; {{$comingreso->nombrecatprogramatica}}  <br>
                            {{-- <strong> {{$detalle->viaunocargo}}</strong> --}}
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

        <table border="0" cellspacing="0" cellpadding="0" width="100%" >
            <tbody>
                <tr style="font-size: 12px;">
                    
                    <td width="10" valign="top">
                        <p>
                            CODIGO: <br><strong>{{$detallecomegresos->detalleprodcomb}}</strong>
                        </p>
                    </td>

                    <td width="10" valign="top">
                        <p>

                            DETALLE:<br><strong>{{$detallecomegresos->nombreprodcomb}}</strong>
                        <p>
                    </td>
                    <td width="10" valign="top">
                        <p>

                            UNIDAD:<br><strong>{{$detallecomegresos->nombremedida}}</strong>
                        <p>
                    </td>
                    <td width="10" valign="top">
                        <p>

                            EGRESO:<br><strong>{{$Varuno}}</strong>
                        <p>
                    </td>
                    <td width="10" valign="top">
                        <p>

                            PU NETO:<br><strong>{{$detallecomegresos->precio}}</strong>
                        <p>
                    </td>
                    <td width="10" valign="top">
                        <p>

                            TOTAL:<br><strong>{{$Vardos}}</strong>
                        <p>
                    </td>
                </tr>              
              
            </tbody>
        </table>



 

        <table border="0" cellspacing="0" cellpadding="0" width="100%" >
            <tbody>
                <tr style="font-size: 15px;">                
                    <td width="104" valign="top">
                        <p>
                            SON: <strong>{{$valor_total5}}</strong>
                        <p>
                    </td>

                  
                </tr>              
              
              
            </tbody>
        </table>

        <table border="0" cellspacing="0" cellpadding="0" width="100%" >
            <tbody>
                <tr style="font-size: 15px;">

                                      
                    <td width="104" valign="top">
                        <p>
                             {{--<strong>{{$vales->usuarionombre}}</strong> --}}
                            Glosa:<br><strong>{{$comegreso->detallecomegreso}}</strong>
                        <p>
                    </td>

                 
                </tr>              
              
            </tbody>
        </table>

        
       
        <table border="0" cellspacing="0" cellpadding="0" width="100%" >
            <tbody>
                <tr style="font-size: 15px;">

                    <td width="104" valign="top">
                        <p>
                            ...............<br>
                            <strong> Recibi Conforme</strong>
                        </p>
                    </td>
                    
                    <td width="104" valign="top">
                        <p>
                            ...............<br>
                            <strong> Entregue Conforme</strong>
                        </p>
                    </td>

                 
                </tr>              
              
            </tbody>
        </table>
    </div>
    </body>

</html>

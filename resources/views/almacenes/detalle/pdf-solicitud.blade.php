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
            <strong  style=" font-size: 30px;  ">VALE DE GASOLINA</strong> <strong>Nro.:</strong> <strong></strong>
             <strong>{{$detalle->idvale}}</strong>
        </p>

        <table border="0" cellspacing="0" cellpadding="0">

            <tbody>
                <tr>
                    <td width="150" valign="top">
                        <p>
                            <strong>UNIDAD SOLICITANTE:</strong>
                           
                        </p>
                    </td>
                    <td width="500" valign="top">
                        <p>
                            {{$vales->nombrearea}}<br>
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
                            {{$ingresos->nombreprograma}} <br>
                            {{-- <strong> {{$detalle->viaunocargo}}</strong> --}}
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

        <table border="0" cellspacing="0" cellpadding="0" width="100%" >
            <tbody>
                <tr style="font-size: 15px;">

                    <td width="104" valign="top">
                        <p>
                            <strong>Tot. Existencia:</strong>
                        <p>
                    </td>
                    
                    <td width="104" valign="top">
                        <p>
                            Lts. Solicita: <strong>{{$detalle->cantidadsol}}</strong>
                        <p>
                    </td>

                    <td width="104" valign="top">
                        <p>

                            Lts. Saldo actual:<strong>{{$detalle->cantidadresta}}</strong>
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
                            Vehiculo: <strong>{{$vales->marcaconsumo}}</strong>
                        <p>
                    </td>

                    <td width="104" valign="top">
                        <p>

                            Placa:<strong>{{$vales->placaconsumo}}</strong>
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
                            Trabajo: <strong>{{$vales->detallesouconsumo}}</strong>
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
                            Kilometraje Anterior: <strong>{{$vales->kiloanterior}}</strong>
                        <p>
                    </td>

                    <td width="104" valign="top">
                        <p>

                            Kilometraje Actual:<strong>{{$vales->kilometrajeactualconsumo}}</strong>
                        <p>
                    </td>
                </tr>              
                <td width="104" valign="top">
                    <p>

                        Recibido por:<strong>{{$vales->usuarionombre}}</strong>
                    <p>
                </td>

              
            </tbody>
        </table>

        <table border="0" cellspacing="0" cellpadding="0" width="100%" >
            <tbody>
                <tr style="font-size: 15px;">

                                      
                    <td width="104" valign="top">
                        <p>
                            Lugar y fecha: Yacuiba {{--<strong>{{$vales->usuarionombre}}</strong> --}}
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
                            <strong> Solicitante</strong>
                        </p>
                    </td>
                    
                    <td width="104" valign="top">
                        <p>
                            ...............<br>
                            <strong> Enc. Combustible</strong>
                        </p>
                    </td>

                    <td width="104" valign="top">
                        <p>
                            ...............<br>
                            <strong> V. B. Almacenes</strong>
                        </p>
                    </td>
                </tr>              
              
            </tbody>
        </table>
    </div>
    </body>

</html>

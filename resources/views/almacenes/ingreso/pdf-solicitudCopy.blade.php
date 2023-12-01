
@if(Session::has('message'))
<div class="alert alert-success">
    <em> {!! session('message') !!}</em>
</div>
@endif


<script type="text/javascript">
function imprSelec(muestra) {
    var ficha = document.getElementById(muestra);
    var ventimp = window.open(' ', 'popimpr');
    ventimp.document.write(ficha.innerHTML);
    ventimp.document.close();
    ventimp.print();
    ventimp.close();
}

function colorChanger(el) {
    el.style.backgroundColor = '#696969';

}

function colorChanger2(el) {
    el.style.backgroundColor = 'transparent';
}
</script>
<div style="width: 900px;margin: auto;">

     {{-- TODO: BOTON DE IMPRIMIR --}}
    <button data-id="5" onclick="javascript:imprSelec('muestra')">
        Imprimir</button>
    </div>



<div id="muestra" style="width: 1300px;margin: auto;">


    <table border="0"  cellspacing="0" cellpadding="0" width="100%" >
        <tbody>
            <tr >
                <td width="392" nowrap="" colspan="3" valign="bottom" style="font-size: 18px;">
                    <p align="center">
                        <b>

                            <a name="RANGE!A1:G104">
                                Gobierno Autónomo Regional Del Gran Chaco
                            </a>
                            <p>
                            </p>
                        </b>
                    </p>
                </td>
                <td width="73" nowrap="">
                </td>
             
             
                <td width="0" height="50">
                </td>
            </tr>
            <tr>
                <td width="392" nowrap="" colspan="3" style="font-size: 18px;">
                    <p align="center">
                        <b>
                            1ra. Sección  - Provincia Gran Chaco
                            <p>
                            </p>
                        </b>
                    </p>
                </td>
                <td width="73" nowrap="">
                </td>
             
             
                <td width="0" height="25">
                </td>
            </tr>


          

        
       
        
      
        </tbody>
    </table>


    <table border="1"  cellspacing="0" cellpadding="0" width="100%" style=" border: 1px solid black;border-collapse: collapse;">
    <tbody>

      
      
        
        
      
    
    
     
   
        <tr>
            <td width="751" colspan="7">
                <p>
                    &nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Categoria programatica <br>
                      &nbsp;  {{$ingresos->codigocatprogramai}} &nbsp; 
                      &nbsp;  {{$ingresos->nombrecatprogmai}} &nbsp; 
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="49">
            </td>
        </tr>


        <tr>
            <td colspan="10" width="707" style="font-size: 12px;">


                <table border="1"  cellspacing="0" cellpadding="0" width="100%" 
                style=" border: 1px solid black;border-collapse: collapse;">
                    <thead>
                        <th style="font-size: 10px;" class="text-justify p-1">N</th>
                        <th style="font-size: 10px;" class="text-center p-1">Nro Pedido/Vale</th>
                        <th style="font-size: 10px;" class="text-center p-1">Area solicitante</th>
                        <th style="font-size: 10px;" class="text-center p-1">Entregado a</th>
                        <th style="font-size: 10px;" class="text-center p-1">Cargo</th>
                        <th style="font-size: 10px;" class="text-center p-1">PRECIO </th>


                        
                        <th style="font-size: 10px;" class="text-center p-1">INGRESO FISICO</th>
                        <th style="font-size: 10px;" class="text-center p-1">INGRESO VALORADO </th>

                        <th style="font-size: 10px;" class="text-center p-1">EGRESO FISICO</th>
                        <th style="font-size: 10px;" class="text-center p-1">EGRESO VALORADO </th>

                        <th style="font-size: 10px;" class="text-center p-1">SALDO FISICO</th>
                        <th style="font-size: 10px;" class="text-center p-1">SALDO VALORADO </th>

                    </thead>

                    <tr style="text-align: center">
                        <td class="text-justify p-1">1/1/2023</td>
                        <td class="text-center p-1"></td>
                        <td class="text-center p-1"></td>
                        <td class="text-center p-1"></td>
                        <td class="text-center p-1"></td>
                        <td class="text-center p-1">3.74</td>

                        <td class="text-center p-1">{{$ingresos->cantidad}}</td>
                        <td class="text-center p-1">{{$ingresos->subtotal}}</td>

                        <td class="text-center p-1">0</td>
                        <td class="text-center p-1">0</td>
                        
                        <td class="text-center p-1">{{$ingresos->cantidad}}</td>
                        <td class="text-center p-1">{{$ingresos->subtotal}}</td>
                      
                    </tr>
                    @php
                    $num = 1;
                    $numssss =0;
                    //a
                 
                    $numd = $ingresos->cantidad;
                      //b
                
                
               
                    @endphp
                    @foreach($prodserv as $prod)
                   
                    <tr style="text-align: center">
                        <td class="text-justify p-1">{{$num++}}</td>
                        <td class="text-center p-1">{{$prod ->idvale}}</td>
                        <td class="text-center p-1">{{$prod ->nombrearea}}</td>
                        <td class="text-center p-1">{{$prod ->usuarionombre}}</td>
                        <td class="text-center p-1">{{$prod ->usuariocargo}}</td>
                        <td class="text-center p-1">{{$prod ->preciosol}}</td>

                        <td class="text-center p-1">0</td>
                        <td class="text-center p-1">0</td>

                        <td class="text-center p-1">{{$prod ->cantidadsol}}</td>
                        <td class="text-center p-1">{{$prod ->preciosol * $prod ->cantidadsol}}</td>

                        {{-- <td class="text-center p-1">{{$numd}}</td> --}}
                        <td class="text-center p-1">{{$numd=$numd-$prod ->cantidadsol }}</td>

                        <td class="text-center p-1">{{$prod ->precio * $prod ->cantidadresta}}</td>
                    
                     
                    </tr>
                 
                    @endforeach
                   
         @if (count($prodserv) > 0)
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="text-center p-1">
                    <b>TOTAL:</b>
                </td>
                <td class="text-center p-1">
                    <b>{{$ingresos->cantidad}}</b>
                </td>
                <td class="text-center p-1">
                    <b>{{$ingresos->subtotal}}</b>
                </td>
                <td class="text-center p-1">
                    <b>{{$valor_total}}</b>
                </td>
                <td class="text-center p-1">
                    <b>{{$valor_total2}}</b>
                </td>
              
                <td class="text-center p-1">
                  
                    <b>{{$ingresos->cantidadsalida}}</b>
                </td>
                <td class="text-center p-1">
                    <b>{{$ingresos->subtotalsalida}}</b>
                </td>
               
               

                

            </tr>
        @endif
                </table>


            </td>

        </tr>

        <tr>
            <td width="664" nowrap="" colspan="6" >
                <p>
                    <b>
                        INGRESO:   FISICO:&nbsp;&nbsp;<b>{{$ingresos->cantidad}}</b>&nbsp; VALORADO:&nbsp;&nbsp;<b>{{$ingresos->subtotal}}</b>
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="87" nowrap="" >
                <p align="center">
                    <b>
                     
                        <p>
                           
                        </p>
                    </b>
                </p>
            </td>
            <td width="0" height="28">
            </td>
        </tr>


        <tr>
            <td width="664" nowrap="" colspan="6" >
                <p>
                    <b>
                        EGRESO:   FISICO:&nbsp;&nbsp;<b>{{$valor_total}}</b> VALORADO:&nbsp;&nbsp;<b>{{$valor_total3}}</b>
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="87" nowrap="" >
                <p align="center">
                    <b>
                     
                        <p>
                           
                        </p>
                    </b>
                </p>
            </td>
            <td width="0" height="28">
            </td>
        </tr>



        <tr>
            <td width="664" nowrap="" colspan="6" >
                <p>
                    <b>
                        SALDO: FISICO:&nbsp;&nbsp;<b>{{$ingresos->cantidadsalida}}&nbsp;&nbsp;</b>VALORADO:&nbsp; <b>{{$valor_total6}}</b>&nbsp;<b>({{$valor_total5}})</b>
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="87" nowrap="" >
                <p align="center">
                    <b>
                        12.000,00
                        <p>
                        </p>
                    </b>
                </p>
            </td>
            <td width="0" height="28">
            </td>
        </tr>
        

       

        
       
  {{-- 
        parte_entera:&nbsp; <b>{{$parte_entera}}</b>
            parte_decimal:&nbsp; <b>{{$parte_decimal}}</b>
                Subtotalsalida:&nbsp; <b>{{$Subtotalsalida}}</b>
                    parte_entera_formateada:&nbsp; <b>{{$parte_entera_formateada}}</b>
                  
                      parte_decimaldos:&nbsp; <b>{{$parte_decimaldos}}</b> 
                        
                            valor total 6:&nbsp; <b>{{$valor_total6}}</b> --}}
     
     
      
    </tbody>
</table>

</div>



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
                      &nbsp;  {{$comingres->codcatprogramatica}} &nbsp; 
                      &nbsp;  {{$comingres->nombrecatprogramatica}} &nbsp; 
                    <p>
                    </p>
                </p>
            </td>
            <td width="0" height="49">
            </td>
        </tr>


        <tr>
            <td colspan="10" width="707" >
                <font size="2" face="Courier New" >

                <table  style="font-size: 12px;"  border="1" cellspacing="0" cellpadding="0" width="100%"  style=" border: 1px solid black;border-collapse: collapse;font-size:11px">
                    <thead>
                        <th style="font-size: 10px;" >N°</th>
                        <th style="font-size: 10px;" >FECHA</th>
                        <th style="font-size: 10px;" >Nro Pedido/Vale</th>
                        <th style="font-size: 10px;" >Area solicitante</th>
                        <th style="font-size: 10px;" >Entregado a</th>
                         <th style="font-size: 10px;" >Cpbte</th> 
                        <th style="font-size: 10px;" >Tipo</th> 
                        <th style="font-size: 10px;" >PRECIO </th>


                        
                        <th style="font-size: 10px;" class="text-center p-1">INGRESO FISICO</th>
                        <th style="font-size: 10px;" class="text-center p-1">INGRESO VALORADO </th>

                        <th style="font-size: 10px;" class="text-center p-1">EGRESO FISICO</th>
                        <th style="font-size: 10px;" class="text-center p-1">EGRESO VALORADO </th>

                        <th style="font-size: 10px;" class="text-center p-1">SALDO FISICO</th>
                        <th style="font-size: 10px;" class="text-center p-1">SALDO VALORADO </th>

                    </thead>
                       <tr style="text-align: center">
                        <td class="text-center p-1"></td>
                        <td class="text-justify p-1">{{$var1}}</td>
                        <td class="text-center p-1"></td>
                        <td class="text-center p-1"></td>
                        <td class="text-center p-1"></td>
                        <td class="text-center p-1">1</td>
                        <td class="text-center p-1">{{$varti2}}</td>
                        <td class="text-center p-1">{{$id9}}</td>

                        <td class="text-center p-1">{{$vardiff1}}</td>
                        <td class="text-center p-1">{{$vardiff2}}</td>

                        <td class="text-center p-1">0</td>
                        <td class="text-center p-1">0</td>
                        
                        <td class="text-center p-1">{{$vardiff1}}</td>
                        <td class="text-center p-1">{{$vardiff2}}</td>
                      
                    </tr>

                    @php
               
               
                      $varcc2=0;
                      $vardd2=0;
                    @endphp
                      @foreach($detalledos as $prod)
                      @php
                      $varc1 = $prod->cantidadegreso;
                      $varc2 = $prod->subtotalegreso;
                     
                      $vardet11 = number_format($varc1, 2, '.', '');
                      $vardet22 = number_format($varc2, 2, '.', '');
                     
                      $varc3 = $prod->cantidadsalida;
                      $varc4 = $prod->subtotalsalida;
                     
                      $vardet33 = number_format($varc3, 2, '.', '');
                      $vardet44 = number_format($varc4, 2, '.', '');
                      //la cantidad se va a ir sumando
                     
                      $varcc2=$varcc2+$varc1;
                      $vardd2=$vardd2+$varc2;
                     
                      $varee1=$varc3-$varcc2;
                      $varff1=$varc4-$vardd2;
                     
                      $vargg12 = number_format($varee1, 2, '.', '');
                      $varhh12 = number_format($varff1, 2, '.', '');
                      @endphp
                   
                                   
                   <tr style="text-align: center">
                    <td class="text-center p-1"></td>
                    <td class="text-justify p-1"></td>
                    <td class="text-center p-1"></td>
                    <td class="text-center p-1"></td>
                    <td class="text-center p-1"></td>
                    <td class="text-center p-1">1</td>
                    <td class="text-center p-1">2</td>
                    <td class="text-center p-1">3</td>

                    <td class="text-center p-1">4</td>
                    <td class="text-center p-1">5</td>

                    <td class="text-center p-1">{{$varcc2}}</td>
                    <td class="text-center p-1">{{$vardd2}}</td>

                    <td class="text-center p-1">{{$vargg12}}</td>
                    <td class="text-center p-1">{{$varhh12}}</td>
                  
                </tr>
                @endforeach
                    @php
                    $num = 1;
                    $numssss =0;
                    //a
               
                      $varcc1=$varcc2;
                      $vardd1=$vardd2;
                    @endphp

                  
                    @foreach($detalle as $prod)
                    @php
                    $varc1 = $prod->cantidadegreso;
                    $varc2 = $prod->subtotalegreso;

                    $vardet11 = number_format($varc1, 2, '.', '');
                    $vardet22 = number_format($varc2, 2, '.', '');

                    $varc3 = $prod->cantidadsalida;
                    $varc4 = $prod->subtotalsalida;


                    $vardet33 = number_format($varc3, 2, '.', '');
                    $vardet44 = number_format($varc4, 2, '.', '');

                    //la cantidad se va a ir sumando
                   
                    $varcc1=$varcc1+$varc1;
                    $vardd1=$vardd1+$varc2;

                    $varee1=$varc3-$varcc1;
                    $varff1=$varc4-$vardd1;

                    $vargg1 = number_format($varee1, 2, '.', '');
                    $varhh1 = number_format($varff1, 2, '.', '');

                    @endphp

                    <tr style="text-align: center">
                        <td class="text-justify p-1">{{$num++}}</td>
                        <td class="text-center p-1">{{$prod ->fechaegreso}}</td>
                        <td class="text-center p-1">{{$prod ->numvale}}</td>
                        <td class="text-center p-1">{{$prod ->nombrearea}}</td>
                        <td class="text-center p-1">{{$prod ->nombres}}  {{$prod ->ap_pat}}  {{$prod ->ap_mat}}</td>
                        <td class="text-center p-1">{{$prod ->idcomegreso}}</td>
                        <td class="text-center p-1">{{$prod ->codcoming}}</td>
                        <td class="text-center p-1">{{$prod ->precio}}</td>
                      
                        <td class="text-center p-1">0</td>
                        <td class="text-center p-1">0</td>

                        <td class="text-center p-1">{{$vardet11}}</td>
                        <td class="text-center p-1">{{$vardet22}}</td>

                      
                        <td class="text-center p-1">{{$vargg1}}</td>

                        <td class="text-center p-1">{{$varhh1}}</td>
                    
                     
                    </tr>
                 
                    @endforeach
                   
         @if (count($detalle) > 0)
            <tr>
               
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="text-center p-1">
                    <b>TOTAL:</b>
                </td>
                <td class="text-center p-1">
                    <b>{{$vardiff1}}</b>
                </td>
                <td class="text-center p-1">
                    <b>{{$vardiff2}}</b>
                </td>
                <td class="text-center p-1">
                    <b>{{$avardet1}}</b>
                </td>
                <td class="text-center p-1">
                    <b>{{$avardet2}}</b>
                </td>
              
                <td class="text-center p-1">
                  
                    <b>{{$vardif1}}</b>
                </td>
                <td class="text-center p-1">
                    <b>{{$vardif2}}</b>
                </td>
            </tr>
        @endif
                </table>


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
</font>
</div>


@extends('layouts.admin')

@section('content')
@include('layouts.message_alert')
<div class="row justify-content-center">
    <div class="col-md-10">

        <div class="row font-verdana-bg">
            <div class="col-md-4 titulo">

                <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                    <a href="{{ url('/comingreso/index') }}">
                        <span class="color-icon-1">
                            &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                        </span>
                    </a>
                </span>

            </div>

            <div class="col-md-8 text-right titulo">
                <b>EDITAR DETALLE reporte estado 2</b>
            </div>

            <div class="col-md-12">
                <hr color="red">
            </div>
        </div>


        <div class="body-border">
            <font size="2" face="Courier New" >
                    <form method="POST" action="{{ route('comingreso.updatearchivonotan',$docproveedor->iddetallecomingreso) }}" id="form">
                        @csrf
                        <input type="hidden" class="form-control" name="id2" placeholder="" value="{{$id2}}">
                        <input type="hidden" class="form-control" name="id3" placeholder="" value="{{$id3}}">
                        <input type="hidden" class="form-control" name="id4" placeholder="" value="{{$id4}}">
                                          
                        <div class="form-group row">
                            <div class="col-md-9">
                                <label for="idproducto" class="d-inline font-verdana-bg">
                                    <b>Producto -- Item</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                                </label>
                                <select  name="idproducto" id="idproducto" placeholder="--Seleccionar--" 
                                class="form-control form-control-sm select2">
                                    <option value="">-</option>
                                    @foreach ($productos as $local)
                
                                                @if ($local->idprodcomb==$docproveedor->idproducto)
                                                <option value="{{$local->idprodcomb}}" selected> ID: {{$local->idprodcomb}} //CODIGO: {{$local->detalleprodcomb}} //NOMBRE: {{$local->nombreprodcomb}} //PRECIO BS: {{$local->precioprodcomb}}
                                                </option>
                                                @else
                                                <option value="{{$local->idprodcomb}}"> ID: {{$local->idprodcomb}} //CODIGO: {{$local->detalleprodcomb}} //NOMBRE: {{$local->nombreprodcomb}} //PRECIO BS: {{$local->precioprodcomb}}</option>
                                                @endif
                
                                                @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="fechainicio" class="d-inline font-verdana-bg">
                                    <b> fecha inicio</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                                </label>
                                <input type="text" name="fechainicio" placeholder="dd/mm/aaaa"  value="{{$docproveedor->fechaini }}"
                             
                                class="form-control form-control-sm font-verdana-bg" 
                                id="fechainicio" data-language="es" autocomplete="off" >
                            </div>
                            <div class="col-md-9">
                                <label for="idcomingreso" class="d-inline font-verdana-bg">
                                    <b>Proyecto</b>&nbsp;<span style="font-size:10px; color: red;">validado</span>
                                </label>
                                <select name="idcomingreso" id="idcomingreso" placeholder="--Seleccionar--"
                                    class="form-control form-control-sm select2">
                                    <option value="">-</option>
                                    @foreach ($comingres as $area)
                                        @if ($area->idcomingreso == $docproveedor->idcomingreso)
                                            <option value="{{ $area->idcomingreso }}" selected>
                                                Nombre:&nbsp;{{ $area->codcatprogramatica }}&nbsp;{{ $area->nombrecatprogramatica }}
                                            </option>
                                        @else
                                            <option value="{{ $area->idcomingreso }}">
                                                Nombre:&nbsp;{{ $area->codcatprogramatica }}&nbsp;{{ $area->nombrecatprogramatica }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="fechafin" class="d-inline font-verdana-bg" cols="2" rows="3">
                                    <b> fecha fin</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                                </label>
                                <input type="text" name="fechafin" placeholder="dd/mm/aaaa" value="{{$docproveedor->fechafin }}"
                               
                                class="form-control form-control-sm font-verdana-bg" 
                                id="fechafin" data-language="es" autocomplete="off" >
                            </div>        
                        </div>
                        <div align='center'>
                            <div class="col-md-12 text-right">              
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input  class="btn color-icon-2 font-verdana-bg" type="button" value="Adicionar" onclick="save();" id="save">
                
                                </br></br>
                               
                            </div>

                        </div>
                    </form>

                </font>

            </div>

            <div class="col-md-2 text-right">
                <br>
                <span class="tts:left tts-slideIn tts-custom" aria-label="imprimir ">
                    <a href="{{ route('comingreso.solicitud', $id6) }}">
                        <span class="text-primary">
                            <i class="fa-2xl fa-solid fa-print"></i>
                        </span>
                    </a>
                </span>
            </div>


            <div class="row">
                <div class="col-md-12 table-responsive">
                    <center>
                        <table id="dataTable" class="table display table-bordered responsive font-verdana" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="font-size: 10px;" >N°</th>
                                    <th style="font-size: 10px;" >FECHA</th>
                                    <th style="font-size: 10px;" >N° Vale</th>
                                     <th style="font-size: 10px;" >Area solicitante</th>
                                    <th style="font-size: 10px;" >Entregado a</th>
                                    <th style="font-size: 10px;" >Cpbte</th>
                                    <th style="font-size: 10px;" >PRECIO </th>
                                    <th style="font-size: 10px;" class="text-center p-1">INGRESO FISICO</th>
                                    <th style="font-size: 10px;" class="text-center p-1">INGRESO VALORADO </th>
                                    <th style="font-size: 10px;" class="text-center p-1">EGRESO FISICO</th>
                                    <th style="font-size: 10px;" class="text-center p-1">EGRESO VALORADO </th>
                                    <th style="font-size: 10px;" class="text-center p-1">SALDO FISICO</th>
                                    <th style="font-size: 10px;" class="text-center p-1">SALDO VALORADO</th>
            
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                  $num = 1;
                                $numssss =0;               
                                $numd = $ingresos->cantidad;
                                $numde = $ingresos->subtotal;

                                $varcc1 = 0;
                                $vardd1 = 0;
                                @endphp
                               @forelse ($detalle as $prod) 
                                @php
                                    $varc1 = $prod->cantidadegreso;
                                    $varc2 = $prod->subtotalegreso;
                                    $vardet11 = number_format($varc1, 4, '.', '');
                                    $vardet22 = number_format($varc2, 4, '.', '');

                                    $varc3 = $prod->cantidadsalida;
                                    $varc4 = $prod->subtotalsalida;

                                    $varcc1 = $varcc1 + $varc1;
                                    $vardd1 = $vardd1 + $varc2;

                                    $varee1 = $varc3 - $varcc1;
                                    $varff1 = $varc4 - $vardd1;

                                    $vargg1 = number_format($varee1, 4, '.', '');
                                    $varhh1 = number_format($varff1, 4, '.', '');
                            @endphp 


                               <tr style="text-align: center">
                                   <td class="text-justify p-1">{{$num++}}</td>
                                   <td class="text-center p-1">{{$prod ->fechaegreso}}</td>
                                   <td class="text-center p-1">{{$prod ->idvale}}</td>
                                   <td class="text-center p-1">{{$prod ->nombrearea}}</td>
                                   <td class="text-center p-1">{{$prod ->nombres}}</td>
                                   <td class="text-center p-1">{{$prod ->idcomegreso}}</td>

                                   <td class="text-center p-1">{{$prod ->precio}}</td>
                            
                                   
            
                                   <td class="text-center p-1">0</td>
                                   <td class="text-center p-1">0</td>

                                   <td class="text-center p-1">{{$vardet11}}</td>
                                   <td class="text-center p-1">{{$vardet22}}</td>

                                   <td class="text-center p-1">{{$vargg1 }}</td>
                                   <td class="text-center p-1">{{$varhh1 }}</td>            
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                          
                        </table>
                    </center>
                </div>
            </div>
            

        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
        });


        function message_alert(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        $("#save").click(function() {
            if(validar_formulario() == true){
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        });

        $("#cancelar").click(function() {
$(".btn").hide();
$(".spinner-btn-send").show();
window.location.href =  "{{url()->previous()}}";

});
         
                function validar_formulario(){

            if($("#cantidad").val() == ""){
                message_alert("El campo <b>[Cantidad]</b> es un dato obligatorio...");
                return false;
            }
          
            return true;
        };

       
        
        $("#fechainicio").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });

        $("#fechafin").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });

    </script>
@endsection

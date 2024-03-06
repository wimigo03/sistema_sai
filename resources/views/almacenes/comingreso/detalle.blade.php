@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')
@if(Session::has('message'))
    <div class="alert alert-success">
        <em> {!! session('message') !!}</em>
    </div>
@endif
<br>
<div class="row font-verdana-bg">

    <div class="col-md-2 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{ url('/ingreso/index') }}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>

    <div class="col-md-10 text-right titulo">
        <b>DETALLE DEL VALE POR PROGRAMA</b>

     
    </div>

    <div class="col-md-12">
        <hr class="hrr">
    </div>

    <div class="col-md-12 text-right">


        <input type="hidden" value="{{$idingreso}}" id="idingreso">

        
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>

      

    </div>

</div>



<div class="row">
    <div class="col-md-12 table-responsive">
        <center>
            <table id="dataTable" class="table display table-bordered responsive font-verdana" style="width:100%">
                <thead>
                    <tr>
                        <th style="font-size: 10px;" >N°</th>
                        <th style="font-size: 10px;" >FECHA</th>
                        <th style="font-size: 10px;" >Nro Vale</th>
                        <th style="font-size: 10px;" >Area solicitante</th>
                        <th style="font-size: 10px;" >Entregado a</th>
                        <th style="font-size: 10px;" >Cargo</th>
                        <th style="font-size: 10px;" >PRECIO </th>
                        <th style="font-size: 10px;" class="text-center p-1">INGRESO FISICO</th>
                        <th style="font-size: 10px;" class="text-center p-1">INGRESO VALORADO </th>
                        <th style="font-size: 10px;" class="text-center p-1">EGRESO FISICO</th>
                        <th style="font-size: 10px;" class="text-center p-1">EGRESO VALORADO </th>
                        <th style="font-size: 10px;" class="text-center p-1">SALDO FISICO</th>
                        <th style="font-size: 10px;" class="text-center p-1">SALDO VALORADO </th>
                        <th style="font-size: 10px;" class="text-center p-1">ESTADO </th>
                        <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                    </tr>
                </thead>
                <tbody>
                    @php
                   
                   $num = 1;
                    $numssss =0;               
                    $numd = $ingresos->cantidad;
                    @endphp
                     @forelse ($detalle as $prod)
                        <tr style="text-align: center">
                            <td class="text-justify p-1">{{$num++}}</td>
                            <td class="text-center p-1">{{$prod ->fechaaprob}}</td>
                            <td class="text-center p-1">{{$prod ->idvale}}</td>
                            <td class="text-center p-1">{{$prod ->nombrearea}}</td>
                            <td class="text-center p-1">{{$prod ->usuarionombre}}</td>
                            <td class="text-center p-1">{{$prod ->usuariocargo}}</td>
                            <td class="text-center p-1">{{$prod ->preciosol}}</td>
    
                            <td class="text-center p-1">0</td>
                            <td class="text-center p-1">0</td>
    
                            <td class="text-center p-1">{{$prod ->cantidadsol}}</td>
                            <td class="text-center p-1">{{$prod ->preciosol * $prod ->cantidadsol}}</td>
    
                            <td class="text-center p-1">{{$numd=$numd-$prod ->cantidadsol }}</td>
    
                            <td class="text-center p-1">{{$prod ->preciosol * $numd}}</td>

                             @if($prod->estadovale == '2')
                            <td class="text-justify p-1">
                            <b style="color: blue">Aprobada</b></td>
                            @elseif($prod->estadovale == '3')
                            <td class="text-justify p-1">
                                <b style="color: red">Almacen</b></td>
                            @endif


                            @if($prod->estadovale == '2')
                            <td style="padding: 0;" class="text-center p-1">
                            
                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar Solicitud">
                                        <a href="{{route('ingreso.delete',$prod->idvale)}}">
                                            <span class="text-warning">
                                                <i class="fa-solid fa-2xl fa-square-pen"></i>
                                            </span>
                                        </a>
                                    </span>
                           
                                </td>


                                @elseif($prod->estadovale == '3')

                                <td style="padding: 0;" class="text-center p-1">
                               
                                        <span class="tts:left tts-slideIn tts-custom" aria-label="Modificar Compra">
                                            <a href="{{route('ingreso.deletedos',$prod->idvale)}}">
                                                <span class="text-primary">
                                                    <i class="fa-solid fa-2xl fa-print"></i>
                                                </span>
                                            </a>
                                        </span>
                              
                                    </td>
                                    @endif 
                        </tr>
                    @endforeach
                </tbody>
            
            </table>
        </center>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                language: {
"decimal": "",
"emptyTable": "No hay información",
"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
"infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
"infoFiltered": "(Filtrado de _MAX_ total entradas)",
"infoPostFix": "",
"thousands": ",",
"lengthMenu": "Mostrar _MENU_ Entradas",
"loadingRecords": "Cargando...",
"processing": "Procesando...",
"search": "Buscar:",
"zeroRecords": "Sin resultados encontrados",
"paginate": {
    "first": "Primero",
    "last": "Ultimo",
    "next": "Siguiente",
    "previous": "Anterior"
}
},
                order: [[ 0, "asc" ]]
            });

            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
        });

        function message_alert(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

      

       
 
 
 

  
    </script>
@endsection

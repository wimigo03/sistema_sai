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
  
    <div class="col-md-4 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Vista almacen">
            {{-- <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder"> --}}

            <a href="{{ url('/comingreso/index') }}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
        &nbsp;&nbsp;&nbsp;
    

        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>
    </div>
    <div class="col-md-8 text-right titulo">
        <b>DETALLE DE BALANCE INICIAL </b><b style='color:red'>APROBADO</b> estado 2
    </div>
    <div class="col-md-12"  >
        <hr class="hrr">
    </div>
    <div class="col-md-2 text-right titulo">
        <b style="color: blue">N° CPBTE:</b>  <b style='color:red'>{{$idcomingreso}}</b>
    </div>
    <div class="col-md-10 text-right">

        @if ($compras->estado1 == 2)
            <b style="color: orange">REGISTRO VALIDADO</b>
        @elseif ($compras->estado1 == 1)
            <a href="{{ route('comingreso.almacendos', $compras->idcomingreso) }}"
                onclick="return confirm('Se va a validar..esta seguro ?..')">
                <button class="btn btn-sm btn-info   font-verdana" type="button">
                    &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;Validar
                </button>
            </a>
        {{-- @elseif ($compras->estadocompracomb == 5)
            <b style="color: green">Enviado a Almacen</b> --}}
        @endif
    </div>
</div>



<div class="col-md-12"  >
    <hr class="hrr">
</div>

<div class="row">
    <div class="col-md-12 table-responsive">
        <center>
            <table id="dataTable" class="table display table-bordered responsive font-verdana" style="width:100%">
                <thead>
                    <tr>
                        <td class="text-justify p-1"><b>N</b></td>
                        <td class="text-justify p-1"><b>CODIGO</b></td>
                        <td class="text-justify p-1"><b>PRODUCTO</b></td>
                        <td class="text-justify p-1"><b>UNIDAD</b></td>
                        <td class="text-right p-1"><b>PRECIO</b></td>
                        <td class="text-right p-1"><b>CANTIDAD</b></td>
                        <td class="text-right p-1"><b>SUBTOTAL</b></td>
                        <td class="text-right p-1"><b>SALDO</b></td>
                        <td class="text-right p-1"><b>SUBTOTAL</b></td>
                         <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>  

                    </tr>
                </thead>
                <tbody>
                    @php
                        $num = 1;
                    @endphp
                     @forelse ($detallecomingresos as $key => $prod)
                        <tr>
                            <td class="text-justify p-1">{{$key+1}}</td>
                            <td class="text-justify p-1">{{$prod->detalleprodcomb}}</td>
                            <td class="text-justify p-1">{{$prod->nombreprodcomb}}</td>
                            <td class="text-justify p-1">{{$prod->nombremedida}}</td>
                            <td class="text-right p-1">{{$prod->precio}}</td>
                            <td class="text-right p-1">{{$prod->cantidadsalida}}</td>
                            <td class="text-right p-1">{{$prod->subtotalsalida}}</td>
                            <td class="text-right p-1">{{$prod->difcantidad}}</td>
                            <td class="text-right p-1">{{$prod->subtdifcantidad}}</td>
                             <td class="text-center p-1">
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Editar">
                                    <a href="{{route('comingreso.editararchivon',$prod->iddetallecomingreso)}}">
                                      
                                        <span class="text-primary">
                                            <i class="fa-2xl fa-solid fa-print" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                </span>

                             


                            </td> 
                                                
                        </tr>
                    @endforeach
                </tbody>
                    <tfoot>
                    @if (count($detallecomingresos) > 0)
                        <tr>
                         
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td class="text-right p-1">
                                <b>TOTALES:</b>
                            </td>
                            <td class="text-right p-1">
                                <b>{{$CalAdosDecimuno}}</b>
                            </td>
                            <td class="text-right p-1">
                                <b>{{$CalAdosDecim}}</b>
                            </td>
                            <td class="text-right p-1">
                                <b>{{$CalAdosDecitres}}</b>
                            </td>
                            <td class="text-right p-1">
                                <b>{{$CalAdosDecimdos}}</b>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                    @endif
                </tfoot>
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

        // function show(){
        //     $(".btn").hide();
        //     $(".spinner-btn-send").show();
        //     var idcompra = $("#idcompra").val();
        //     var url = "{{ route('detalle.principalorden',':id') }}";
        //     url = url.replace(':id',idcompra);
        //     window.location.href = url;
        // }

        // function print(){
        //     $(".btn").hide();
        //     $(".spinner-btn-send").show();

        //     window.location.href = "{{ route('detalle.show') }}";
        // }

        // function create(){
        //     $(".btn").hide();
        //     $(".spinner-btn-send").show();
        //     var idcompra = $("#idcompra").val();
        //     var url = "{{ route('detalle.principal',':id') }}";
        //     url = url.replace(':id',idcompra);
        //     window.location.href = url;
        // }

         function save(){
             if(validar_formulario() == true){
                 $(".btn").hide();
                 $(".spinner-btn-send").show();
                 $("#form").submit();
             }
         }

         function validar_formulario(){
             if($("#producto >option:selected").val() == ""){
                 message_alert("El campo de seleccion <b>[Producto-Item]</b> es un dato obligatorio...");
                 return false;
             }
             if($("#cantidad").val() == ""){
                 message_alert("El campo <b>[Cantidad]</b> es un dato obligatorio...");
                 return false;
             }
             if($("#cantidad").val() <= 0){
                message_alert("El campo <b>[Cantidad]</b> no puede ser menor que cero...");
                return false;
            }
             return true;
         }

        function valideNumber(evt){
            var code = (evt.which) ? evt.which : evt.keyCode;
            if((code == 46) || (code>=48 && code<=57)){
                return true;
            }else{
                return false;
            }
        }

 
    </script>
@endsection

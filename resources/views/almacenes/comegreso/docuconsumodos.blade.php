@extends('layouts.admin')
@section('content')
{{-- @include('layouts.message_alert') --}}
{{-- @if(Session::has('message'))
    <div class="alert alert-success">
        <em> {!! session('message') !!}</em>
    </div>
@endif
<br> --}}
<div class="row font-verdana-bg">
  
    <div class="col-md-2 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Vista almacen">
            {{-- <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder"> --}}

            <a href="{{ url('/comegreso/index') }}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>
    <div class="col-md-10 text-right titulo">
        <b>DETALLE DE COMPROBANTE EGRESO</b>
    </div>
    <div class="col-md-12"  >
        <hr class="hrr">
    </div>
    <div class="col-md-2 text-right titulo">
        <b>Cpbte N° </b> <b style='color:red'>{{ $comegresos->idcomegreso}}</b>

    </div>
    <div class="col-md-9 text-right">

        @if ($comegresos->idproveedor== 1)
        <b style="color: orange">--Para validar comprobante seleccione un Proveedor--</b>
    
        @elseif ($comegresos->idproveedor != 1)
        <span class="tts:left tts-slideIn tts-custom" aria-label="Imprimir Solicitud">
            <a href="{{route('comegreso.solicitud',$comegresos->idcomegreso)}}">
                <span class="text-primary">
                    <i class=" fa-2xl fa-solid fa-print">Nota De Salida</i>
                </span>
            </a>
        </span>
    @endif
    </div>

</div>
<div>
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
                        {{-- <td class="text-right p-1"><b>SALDO</b></td>
                        <td class="text-right p-1"><b>SUBTOTAL</b></td> --}}

                    </tr>
                </thead>
                <tbody>
                    @php
                        $num = 1;
                    @endphp
                     @forelse ($detallecomegresos as $key => $prod)
                        <tr>
                            <td class="text-justify p-1">{{$key+1}}</td>
                            <td class="text-justify p-1">{{$prod->detalleprodcomb}}</td>
                            <td class="text-justify p-1">{{$prod->nombreprodcomb}}</td>
                            <td class="text-justify p-1">{{$prod->nombremedida}}</td>
                            <td class="text-right p-1">{{$prod->precio}}</td>
                            <td class="text-right p-1">{{$prod->cantidadegreso}}</td>
                            <td class="text-right p-1">{{$prod->subtotalegreso}}</td>

                            {{-- <td class="text-right p-1">{{$prod->difcantidad}}</td>
                            <td class="text-right p-1">{{$prod->subtdifcantidad}}</td> --}}

                                                
                        </tr>
                    @endforeach
                </tbody>
                    <tfoot>
                    @if (count($detallecomegresos) > 0)
                        <tr>
                         
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td class="text-right p-1">
                                <b>TOTALES:</b>
                            </td>
                            <td class="text-right p-1">
                                <b>{{$CalAdosDecim}}</b>
                            </td>
                         
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

        // function save(){
        //     if(validar_formulario() == true){
        //         $(".btn").hide();
        //         $(".spinner-btn-send").show();
        //         $("#form").submit();
        //     }
        // }

        // function validar_formulario(){
        //     if($("#producto >option:selected").val() == ""){
        //         message_alert("El campo de seleccion <b>[Producto-Item]</b> es un dato obligatorio...");
        //         return false;
        //     }
        //     if($("#cantidad").val() == ""){
        //         message_alert("El campo <b>[Cantidad]</b> es un dato obligatorio...");
        //         return false;
        //     }
        //     return true;
        // }

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

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
    @can('comprasalmacen_aprovadas_access')
    <div class="col-md-2 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{ url('/combustibles/pedido/index2') }}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>
    @endcan

    @can('comprascomb_janeth_access')
    <div class="col-md-2 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{ url('/combustibles/pedido/index') }}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>
    @endcan
    <div class="col-md-10 text-right titulo">
        <b>DETALLE DE LA COMPRA</b>
    </div>
    <div class="col-md-12"  >
        <hr class="hrr">
    </div>
    <div class="col-md-12 text-right">

        @if ($compras->estadocompracomb== 1)
        <b style="color: orange">--Para aprovar la compra seleccione un Proveedor--</b>
      @elseif ($compras->estadocompracomb == 2)

      @can('comprascomb_aprovaralmacen')
      <a href="{{route('combustibles.detalle.almacen',$compras->idcompracomb)}}" 
        onclick="return confirm('Se va a enviar la compra a almace..esta seguro ?..')">
        <button class="btn btn-sm btn-info   font-verdana" type="button" >
            &nbsp;<i class="fa fa-lg fa-plus" aria-hidden="true"></i>&nbsp;Ingresar a almacen
        </button>
    </a>
    @endcan
    @elseif ($compras->estadocompracomb == 5)
    <b style="color: green">Enviado a Almacen</b>

      @endif

        <input type="hidden" value="{{$idcompracomb}}" id="idcompra">
        <input type="hidden" value="{{$compras->estadocompracomb}}" id="idcompra2">
        <input type="hidden" value="{{$compras->idproveedor}}" id="idcompra3">

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
                        <td class="text-justify p-1"><b>PRODUCTO</b></td>
                        <td class="text-right p-1"><b>CANTIDAD</b></td>
                        <td class="text-right p-1"><b>PRECIO</b></td>
                        <td class="text-right p-1"><b>SUBTOTAL</b></td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $num = 1;
                    @endphp
                     @forelse ($prodserv as $key => $prod)
                        <tr>
                            <td class="text-justify p-1">{{$key+1}}</td>
                            <td class="text-justify p-1">{{$prod->nombreprodcomb}}</td>
                            <td class="text-right p-1">{{$prod->cantidad}}</td>
                            <td class="text-right p-1">{{$prod->precio}}</td>
                            <td class="text-right p-1">{{$prod->subtotal}}</td>

                                                
                        </tr>
                    @endforeach
                </tbody>
                    <tfoot>
                    @if (count($prodserv) > 0)
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td class="text-right p-1">
                                <b>TOTAL:</b>
                            </td>
                            <td class="text-right p-1">
                                <b>{{$valor_total}}</b>
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

        function show(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            var idcompra = $("#idcompra").val();
            var url = "{{ route('combustibles.detalle.principalorden',':id') }}";
            url = url.replace(':id',idcompra);
            window.location.href = url;
        }

        function print(){
            $(".btn").hide();
            $(".spinner-btn-send").show();

            window.location.href = "{{ route('combustibles.detalle.show') }}";
        }

        function create(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            var idcompra = $("#idcompra").val();
            var url = "{{ route('combustibles.detalle.principal',':id') }}";
            url = url.replace(':id',idcompra);
            window.location.href = url;
        }

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

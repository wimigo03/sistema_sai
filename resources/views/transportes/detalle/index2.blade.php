@extends('layouts.dashboard')
@section('content')
@include('layouts.message_alert')
@if(Session::has('message'))
    <div class="alert alert-success">
        <em> {!! session('message') !!}</em>
    </div>
@endif
<br>
<div class="row font-verdana-12">

    <div class="col-md-2 titulo">
        <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{ url('/transportes/pedido/index') }}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>

    <div class="col-md-10 text-right titulo">
        <b>DETALLE DE LA SOLICITUD</b>
    </div>

    <div class="col-md-12">
        <hr class="hrr">
    </div>

    <div class="col-md-12 text-right">


        <input type="hidden" value="{{$idsoluconsumo}}" id="idsoluconsumo">

        
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>

      

    </div>

</div>



<div class="row">
    <div class="col-md-12 table-responsive">
        <center>
            <table id="dataTable" class="table display table-bordered responsive font-verdana" style="width:100%">
                <thead>
                    <tr>
                        <td class="text-justify p-1"><b>Nro</b></td>
                        <td class="text-justify p-1"><b>Vehiculo</b></td>
                        <td class="text-right p-1"><b>Marca</b></td>
                        <td class="text-right p-1"><b>placa</b></td>
                        <td class="text-right p-1"><b>klm actual</b></td>
                    </tr>
                </thead>
                <tbody>
                    @php
                   
                        $num = 1;
                    @endphp
                     @forelse ($prodserv as $key => $prod)
                        <tr>
                            <td class="text-justify p-1">{{$key+1}}</td>
                            <td class="text-justify p-1">{{$prod->codigoconsumo}}</td>
                            <td class="text-right p-1">{{$prod->marcaconsumo}}</td>
                            <td class="text-right p-1">{{$prod->placaconsum}}</td>
                            <td class="text-right p-1">{{$prod->kilometrajeactual}}</td>
                          
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

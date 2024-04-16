@extends('layouts.admin')
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
            <a href="{{ url('/almacenes/pedido/index') }}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>

    <div class="col-md-10 text-right titulo">
        <b>DETALLE DEL VALE</b>
    </div>

    <div class="col-md-12">
        <hr class="hrr">
    </div>

    <div class="col-md-12 text-right">


    
        
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>

      

    </div>

</div>


<div class="body-border" style="background-color: #FFFFFF;">
    <form action="{{ route('almacenes.ingreso.store2') }}" method="post" id="form">
        @csrf
        <br>

        <div class="form-group row">


            <div class="col-md-8">
                <label for="ingreso" class="d-inline font-verdana-12">
                    <b>ALMACEN PROGRAMA PRODUCTO</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="ingreso" id="ingreso" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>

                    @foreach ($ingresos as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-8">
                <label for="area" class="d-inline font-verdana-12">
                    <b>ALMACEN PROGRAMA PRODUCTO</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="area" id="area" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>

                    @foreach ($areas as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>





            <div class="col-md-2 text-right">
                <br>
            


                <button class="btn btn-success font-verdana-12" type="button" 
                onclick="save();">
                    <i class="fa-solid fa-plus"></i>
                    &nbsp;Adicionar
                </button>

             


            </div>
        </div>
    </form>
</div>
{{--
<div class="row">
    <div class="col-md-12 table-responsive">
        <center>
            <table id="dataTable" class="table display table-bordered responsive font-verdana" style="width:100%">
                <thead>
                    <tr>
                        <td class="text-justify p-1"><b>Nro</b></td>
                        <td class="text-justify p-1"><b>Programa</b></td>
                        <td class="text-justify p-1"><b>Proveedor</b></td>
                        <td class="text-right p-1"><b>Cantidad restante</b></td>
                        <td class="text-right p-1"><b>Cantidad solic</b></td>
                        <td class="text-right p-1"><b>Precio</b></td>
                        <td class="text-right p-1"><b>Total</b></td>
                        <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                    </tr>
                </thead>
                <tbody>
                    @php
                   
                        $num = 1;
                    @endphp
                     @forelse ($prodserv as $key => $prod)
                        <tr>
                            <td class="text-justify p-1">{{$key+1}}</td>
                            <td class="text-justify p-1">{{$prod->nombreprograma}}</td>
                            <td class="text-justify p-1">{{$prod->nombreproveedor}}</td>
                            <td class="text-right p-1">{{$prod->cantidadsalida}}</td>
                            <td class="text-right p-1">{{$prod->cantidadsol}}</td>
                            <td class="text-right p-1">{{$prod->preciosol}}</td>
                            <td class="text-right p-1">{{$prod->subtotalsol}}</td>
                            <td class="text-center p-1">


                           

                          
 
                         
                              
                             


                             </td> 
                        </tr>
                    @endforeach
                </tbody>
            
            </table>
        </center>
    </div>
</div>
--}}
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

            if($("#ingreso >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[Producto-Item]</b> es un dato obligatorio...");
                return false;
            }
            if($("#area >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[Producto-Item]</b> es un dato obligatorio...");
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

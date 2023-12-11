@extends('layouts.admin')
@section('content')
@include('layouts.message_alert')

<br>
<div class="row font-verdana-bg">

      <div class="col-md-10 text-right titulo">
        <b>Devolucion de combustible</b>
    </div>

    <div class="col-md-12">
        <hr class="hrr">
    </div>

    <div class="col-md-12 text-right">


     
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>

      

    </div>

</div>


<div class="body-border" style="background-color: #FFFFFF;">
    <form method="POST" action="{{ route('almacenes.detalle.update') }}" id="form">
        @csrf
        <br>
        <input type="text" hidden name="iddetallevale" value="{{$detalles->iddetallevale}}">

        <div class="form-group row">
          
            <div class="col-md-3">
                <label for="aproxgas" class="d-inline font-verdana-bg">
                    <b>Cantidad Solicitada :</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
              {{-- el disabled es para que no se pueda editar --}}
                <input type="text" disabled name="aproxgas" value="{{$detalles->cantidadsol}}" 
                class="form-control form-control-sm font-verdana-bg" >
            </div>
         
            <div class="col-md-3">
                <label for="cantidad" class="d-inline font-verdana-bg">
                    <b>Cantidad Cargada :</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="cantidad"  
                class="form-control form-control-sm font-verdana-bg" id="cantidad" 
                onkeypress="return valideNumber(event);" value="{{$detalles->devolucionresta}}">
            </div>
            <div class="col-md-2 text-right">
                <div class="col-md-12 text-right">
                    <button class="btn color-icon-2 font-verdana-bg" type="button" onclick="save();">
                        <i class="fa-solid fa-paper-plane"></i>
                        &nbsp;Actualizar
                    </button>
                    <button class="btn btn-danger font-verdana-bg" type="button" >
    
                        <a href="{{url()->previous()}}" style="color:white">Cancelar</a>
                    </button>
    
                    <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" 
                    style="display: none;"></i>
    
                </div>
            </div>
        </div>


    </form>
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

        function save(){
            if(validar_formulario() == true){
                $(".btn").hide();
                $(".spinner-btn-send").show();
                $("#form").submit();
            }
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            window.location.href = "{{url('almacenes/detalle/index')}}";
        }

        function validar_formulario(){
            
            if($("#cantidad").val() == ""){
                message_alert("El campo <b>[Cantidad]</b> es un dato obligatorio...");
                return false;
            }
            if($("#cantidad").val() == 0){
                $("#cantidad").val('');
                message_alert("El campo <b>[Cantidad]</b> no puede ser menor o igual que cero...");
                return false;
            }
            if($("#cantidad").val() <=0.99){
                $("#cantidad").val('');
                message_alert("El campo <b>[Cantidad]</b> no puede ser menor o igual que 0.99...");
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

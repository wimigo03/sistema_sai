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
        <b>UNIDADES DE TRANSPORTE</b>
    </div>

    <div class="col-md-12">
        <hr class="hrr">
    </div>

    <div class="col-md-12 text-right">


        <input type="hidden" value="{{$idsoluconsumo}}" id="idsoluconsumo">

        
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>

      

    </div>

</div>


<div class="body-border" style="background-color: #FFFFFF;">
    <form action="{{ route('transportes.detalle.store') }}" method="post" id="form">
        @csrf
        <br>

        <div class="form-group row">


            <div class="col-md-8">
                <label for="chofer" class="d-inline font-verdana-12">
                    <b>Personal o conductor</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="chofer" id="chofer" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">--</option>

                    @foreach ($empleados as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

           

            <div class="col-md-8">
                <label for="producto" class="d-inline font-verdana-12">
                    <b>Unidad o Vehiculo</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="producto" id="producto"  placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2" >
                <option value="">--</option>

                @foreach ($productos as $index => $value)
                    <option value="{{ $index }}">{{ $value }}</option>
                @endforeach
            </select>
            </div>


            <div class="col-md-2">
                <label for="cantidad" class="d-inline font-verdana-12">
                    <b>kilometraje Actual</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="cantidad" value="{{request('cantidad')}}" 
                class="form-control form-control-sm font-verdana-12" id="cantidad" 
                onkeypress="return valideNumber(event);">
            </div>


            <div class="col-md-2 text-right">
                <br>
                @if($consumos->estado3 == 1)


                <button class="btn btn-success font-verdana-12" type="button" 
                onclick="save();">
                    <i class="fa-solid fa-plus"></i>
                    &nbsp;Adicionar
                </button>

                @else

                @endif
            </div>
        </div>
    </form>
</div>
<div class="row">
    <div class="col-md-12 table-responsive">
        <center>
            <table id="dataTable" class="table display table-bordered responsive font-verdana" style="width:100%">
                <thead>
                    <tr>
                        <td class="text-justify p-1"><b>Nro</b></td>
                        <td class="text-justify p-1"><b>Codigo</b></td>
                        <td class="text-justify p-1"><b>Nombre</b></td>
                        <td class="text-justify p-1"><b>Marca</b></td>
                        <td class="text-justify p-1"><b>Placa</b></td>
                        <td class="text-justify p-1"><b>Chofer</b></td>
                        <td class="text-justify p-1"><b>klm actual</b></td>
                        <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
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
                            <td class="text-justify p-1">{{$prod->codigoconsumo}}</td>
                            <td class="text-justify p-1">{{$prod->nombreuconsumo}}</td>
                            <td class="text-justify p-1">{{$prod->marcaconsumo}}</td>
                            <td class="text-justify p-1">{{$prod->placaconsum}}</td>
                            <td class="text-justify p-1">{{$prod->chofernombre}}</td>
                            <td class="text-justify p-1">{{$prod->kilometrajeactual}}</td>
                            <td class="text-center p-1">


                           

                                <span class="tts:left tts-slideIn tts-custom" aria-label="Eliminar">
                                    <a href="{{route('transportes.detalle.delete',$prod->iddetallesoluconsumo)}}" 
                                        onclick="return confirm('Se va a eliminar el Item...')">
                                        <span class="text-danger">
                                            <i class="fa-solid fa-xl fa-trash" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                </span>
                            </td>
                                <td class="text-center p-1">
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Aprobar">
                                    <a href="{{route('transportes.detalle.aprovar',$prod->iddetallesoluconsumo)}}" 
                                        onclick="return confirm('Se va a Aprobar la solicitud...')">
                                        <span class="text-success">
                                            <i class="fa-solid fa-xl fa-cart-plus" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                </span>
                            </td>
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

            $('.select2').select2({
                placeholder: "--Seleccionar--"
            });
        });

            $('#dataTable').DataTable({
                language: {
"decimal": "",
"emptyTable": "No hay información",
"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
"infoEmpty": "Mostrando 0 de 0 de 0 Entradas",
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

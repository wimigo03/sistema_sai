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
            <a href="{{ url('/apedido/index') }}">
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

    @if($vales->idcomingreso == 0)

    <div class="col-md-6 text-right titulo">
        <b>DEBE DE TENER UNA CATEGORIA PROGRAMATICA</b> 
    
    </div>

    @else


    <div class="col-md-1 text-right titulo">
        <b>N°</b>  <b style='color:red'>{{$idvale}}</b>
    
    </div>
    <div class="col-md-8 text-right titulo">
        <b>//</b>  <b style='color:red'>{{$id5}}</b>
    
    </div>
    <div class="col-md-3 text-right titulo">
        <b>//</b>  <b style='color:blue'>{{$id4}}</b>
    
    </div>
    @endif
    <div class="col-md-12 text-right">


        <input type="hidden" value="{{$idvale}}" id="idvale">

        
        <i class="fa fa-spinner custom-spinner fa-spin fa-2x fa-fw spinner-btn-send" style="display: none;"></i>

      

    </div>

</div>


<div class="body-border" style="background-color: #FFFFFF;">
    <form action="{{ route('adetalle.store') }}" method="post" id="form">
        @csrf
        <br>

        <div class="form-group row">


            <div class="col-md-7" >
                <label for="producto" class="d-inline font-verdana-bg">
                    <b>PRODUCTO</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="producto" id="producto" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>

                    @foreach ($detallecomingresos as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-3">
                <label for="cantidad" class="d-inline font-verdana-bg">
                    <b>Cantidad Solicitada :</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="cantidad" value="{{request('cantidad')}}" 
                class="form-control form-control-sm font-verdana-bg" id="cantidad" 
                onkeypress="return valideNumber(event);">
            </div>

            <div class="col-md-2">
                <label for="aproxgas" class="d-inline font-verdana-bg">
                    <b>Calculo Aprox.:</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
              {{-- el disabled es para que no se pueda editar --}}
                <input type="text" disabled name="aproxgas" value="{{$vales->aproxgas}}" 
                class="form-control form-control-sm font-verdana-bg" >
            </div>



            <div class="col-md-2 text-right">
                <br>
            
                @if($vales->idcomingreso == 0)

               
                @elseif($vales->estadotemp == 1)

                <button class="btn btn-success font-verdana-bg" type="button" 
                onclick="save();">
                    <i class="fa-solid fa-plus"></i>
                    &nbsp;Adicionar
                </button>
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
                        <td class="text-justify p-1"><b>N°</b></td>
                        <td class="text-justify p-1"><b>Id Vale</b></td>
                        <td class="text-right p-1"><b>Codigo</b></td>
                        <td class="text-right p-1"><b>Nombre</b></td>
                        <td class="text-right p-1"><b>Medida</b></td>
                    
                        <td class="text-right p-1"><b>Precio</b></td>
                        <td class="text-right p-1"><b>Cantidad solic</b></td>
                        <td class="text-right p-1"><b>Total</b></td>
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
                            <td class="text-justify p-1">{{$prod->idvale}}</td>
                            <td class="text-justify p-1">{{$prod->detalleprodcomb}}</td>
                            <td class="text-right p-1">{{$prod->nombreprodcomb}}</td>
                            <td class="text-right p-1">{{$prod->nombremedida}}</td>
                       
                            <td class="text-right p-1">{{$prod->preciosol}}</td>
                            <td class="text-right p-1">{{$prod->cantidadsol}}</td>
                            <td class="text-right p-1">{{$prod->subtotalsol}}</td>
                            

                            <td class="text-center p-1">
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Aprobar">
                                    <a href="{{route('adetalle.aprovar',$prod->iddetallevale)}}" 
                                        onclick="return confirm('Se va a Aprobar la solicitud del vale...')">
                                        <span class="text-success">
                                            <i class="fa-solid fa-xl fa-cart-plus" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                </span> 
                            </td>
                            <td class="text-center p-1">
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Eliminar">
                                    <a href="{{route('adetalle.delete',$prod->iddetallevale)}}" 
                                        onclick="return confirm('Se va a eliminar el registro...Esta seguro?')">
                                        <span class="text-danger">
                                            <i class="fa-solid fa-xl fa-trash" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                </span>


                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    @if (count($prodserv) > 0)
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
                            <td class="text-right p-1">
                                <b>{{$CalAdosDecimdos}}</b>
                            </td>
                        
                            <td>&nbsp;</td>
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

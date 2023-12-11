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
            <a href="{{ url('/almacenes/ingreso/index') }}">
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
                        <td class="text-justify p-1"><b>Nro</b></td>
                        <td class="text-justify p-1"><b>ID VALE</b></td>
                        <td class="text-right p-1"><b>Area</b></td>
                        <td class="text-right p-1"><b>Entregado a</b></td>
                        <td class="text-right p-1"><b>Cargo</b></td>
                        <td class="text-right p-1"><b>Precio</b></td>
                        <td class="text-right p-1"><b>Egreso fisico</b></td>
                        <td class="text-right p-1"><b>Egreso Valorado</b></td>
                        <td class="text-right p-1"><b>Saldo fisico</b></td>
                        <td class="text-right p-1"><b>Saldo Valorado</b></td>
                        <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                    </tr>
                </thead>
                <tbody>
                    @php
                   
                        $num = 1;
                    @endphp
                     @forelse ($detalle as $key => $prod)
                        <tr>
                            <td class="text-justify p-1">{{$key+1}}</td>
                            <td class="text-justify p-1">{{$prod->idvale}}</td>
                            <td class="text-right p-1">{{$prod->idarea}}</td>
                            <td class="text-right p-1">{{$prod->usuarionombre}}</td>
                            <td class="text-right p-1">{{$prod->usuariocargo}}</td>
                            <td class="text-right p-1">{{$prod->preciosol}}</td>

                            <td class="text-right p-1">{{$prod->cantidadsol}}</td>
                            <td class="text-right p-1">{{$prod->subtotalsol}}</td>
                          
                            <td class="text-right p-1">{{$prod->cantidadresta}}</td>
                            <td class="text-right p-1">{{$prod->sudtotalresta}}</td>

                            <td class="text-center p-1">

                            


                           

                                {{-- <span class="tts:left tts-slideIn tts-custom" aria-label="Eliminar">
                                    <a href="{{route('transportes.detalle.delete',$prod->iddetallesoluconsumo)}}" 
                                        onclick="return confirm('Se va a eliminar el Item...')">
                                        <span class="text-danger">
                                            <i class="fa-solid fa-xl fa-trash" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                </span> --}}

                              
                              

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

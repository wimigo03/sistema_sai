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
        {{-- <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
            <a href="{{ url('/almacenes/reporte/index') }}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span> --}}
    </div>

    <div class="col-md-10 text-right titulo">
        <b>REporte por area</b>
    </div>

    <div class="col-md-12">
        <hr class="hrr">
    </div>

  

</div>


<div class="body-border" style="background-color: #FFFFFF;">
    <form action="{{ route('almacenes.reporte.store2') }}" method="post" id="form">
        @csrf
        <br>

        <div class="form-group row">
            <div class="col-md-8">
                <label for="ingreso" class="d-inline font-verdana-bg">
                    <b>Ingreso-Item</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="ingreso" id="ingreso" placeholder="--Seleccionar--" 
                class="form-control form-control-sm select2">
                    <option value="">-</option>

                    @foreach ($ingresoso as $index => $value)
                        <option value="{{ $index }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>


            
            <div class="col-md-3">
                <label for="fechainicio" class="d-inline font-verdana-bg">
                    <b> fechainicio</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="fechainicio" placeholder="dd/mm/aaaa"
                value="{{request('fechainicio')}}" 
                class="form-control form-control-sm font-verdana-bg" 
                id="fechainicio" data-language="es" autocomplete="off" >
            </div>

            <div class="col-md-3">
                <label for="fechafin" class="d-inline font-verdana-bg" cols="2" rows="3">
                    <b> fechafin</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <input type="text" name="fechafin" placeholder="dd/mm/aaaa"
                value="{{request('fechafin')}}" 
                class="form-control form-control-sm font-verdana-bg" 
                id="fechafin" data-language="es" autocomplete="off" >
            </div>


         


            <div class="col-md-2 text-right">
                <br>
           


                <button class="btn btn-success font-verdana-bg" type="button" 
                onclick="save();">
                    <i class="fa-solid fa-plus"></i>
                    &nbsp;Adicionar
                </button>



            </div>
        </div>
    </form>
</div>


<div class="col-md-2 text-right">
    <br>
    <span class="tts:left tts-slideIn tts-custom" aria-label="imprimir ">
        <a href="{{ route('almacenes.reporte.solicituddos', $id) }}">
            <span class="text-primary">
                <i class="fa-2xl fa-solid fa-print"></i>
            </span>
        </a>
    </span>
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
                        < <th style="font-size: 10px;" >Area solicitante</th>
                        <th style="font-size: 10px;" >Entregado a</th>
                        <th style="font-size: 10px;" >Cargo</th>
                        <th style="font-size: 10px;" >PRECIO </th>
                        <th style="font-size: 10px;" class="text-center p-1">INGRESO FISICO</th>
                        <th style="font-size: 10px;" class="text-center p-1">INGRESO VALORADO </th>
                        <th style="font-size: 10px;" class="text-center p-1">EGRESO FISICO</th>
                        <th style="font-size: 10px;" class="text-center p-1">EGRESO VALORADO </th>
                        <th style="font-size: 10px;" class="text-center p-1">SALDO FISICO</th>
                        <th style="font-size: 10px;" class="text-center p-1">SALDO VALORADO </th>

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
            if($("#ingreso >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[Ingreso-Item]</b> es un dato obligatorio...");
                return false;
            }
            if($("#area >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[area-Item]</b> es un dato obligatorio...");
                return false;
            }
            return true;
        }

        $("#fechainicio").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });

        $("#fechafin").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });

    /*var permission_select = new SlimSelect({
        select: '#permissions-select select',
        //showSearch: false,
        placeholder: 'Select Permissions',
        deselectLabel: '<span>&times;</span>',
        hideSelectedOption: true,
    })*/
    </script>
@endsection

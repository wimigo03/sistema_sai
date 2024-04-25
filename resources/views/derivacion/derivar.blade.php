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
            <a href="{{ route('correspondencia.local.gestionar', $idrecepcion) }}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>

    <div class="col-md-4 text-right titulo">
        <b>DERIVAR CORRESPONDENCIA</b>
    </div>

    <div class="col-md-12">
        <hr class="hrr">
    </div>

</div>
<div class="body-border" style="background-color: #FFFFFF;">
    <form action="{{ route('correspondencia.local.guardarderivacion') }}" method="get" id="form">
        @csrf
        <br>
        <input type="hidden" value="{{$idrecepcion}}" name="idrecepcion">
        <div class="form-group row">
            <div class="col-md-8">
                <label for="producto" class="d-inline font-verdana-12">
                    <b>Seleccione la Unidad a derivar</b>&nbsp;<span style="font-size:10px; color: red;">*</span>
                </label>
                <select name="tipo" id="tipo" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                    <option value="">-</option>

                    @foreach ($area as $areas)

                    <option value="{{$areas->idarea}}">{{$areas->nombrearea}}</option>

                    @endforeach
                </select>
            </div>

            <div class="col-md-2 text-right">
                <br>


                <button class="btn btn-info font-verdana-12"  type="button" onclick="save();">
                    <i class="fa-solid fa-plus"></i>
                    &nbsp;Adicionar
                </button>

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
                        <td class="text-justify p-1"><b>UNIDAD AREA</b></td>
                        <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $num = 1;
                    @endphp
                     @forelse ($derivacionCorresp as $key => $derivacionCorresps)
                        <tr>
                            <td class="text-justify p-1">{{$key+1}}</td>
                            <td class="text-justify p-1">{{$derivacionCorresps->nombrearea}}</td>

                            <td class="text-center p-1">
                                <span class="tts:left tts-slideIn tts-custom" aria-label="Eliminar">
                                    <a href="{{route('correspondencia.local.delete',$derivacionCorresps->idderivacion)}}" onclick="return confirm('Se va a eliminar el Item...')">
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
            if($("#tipo >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[tipo de archivo]</b> es un dato obligatorio...");
                return false;
            }

            return true;
        }


    </script>
@endsection

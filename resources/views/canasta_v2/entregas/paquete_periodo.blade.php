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
            <a href="{{ url('entregas') }}">
                <span class="color-icon-1">
                    &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                </span>
            </a>
        </span>
    </div>
    <div class="col-md-10 text-right titulo">
        <b>AGREGAR PERIODOS</b>
    </div>
    <div class="col-md-12">
        <hr class="hrr">
    </div>

</div>
<div class="body-border" style="background-color: #FFFFFF;">
    <form action="{{ route('entregas.paquete_periodo_agregar',$idPaquete) }}" method="post" id="form">
        @csrf
        <br>
            <div class="form-group row">
            <div class="col-md-4">
                <label for="producto" class="d-inline font-verdana-bg">
                    <b>Periodo</b>&nbsp;<span style="font-size:10px; color: red;"></span>
                </label>
                <select name="periodo" id="periodo" placeholder="--Seleccionar--" class="form-control form-control-sm select2">
                    <option value="">-</option>

                    @foreach ($periodos as $periodo)
                        <option value="{{ $periodo->id }}">{{ $periodo->mes }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 text-right">
                <br>
                <button class="btn btn-primary font-verdana-bg" type="button" onclick="save();">
                    <i class="fa-solid fa-plus"></i>
                    &nbsp;Adicionar
                </button>
            </div>
            <div class="col-md-2 text-right">
                <br>
                <button class="btn btn-success font-verdana-bg" type="button" >
                    <a href="{{ route('entregas.finalizar',$idPaquete) }}" class="btn btn-xs btn-success">
                        <i class="fa-regular fa-lg fa-circle-up">&nbsp;Procesar</i>
                    </a>
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
                        <td class="text-justify p-1"><b>Gestion</b></td>
                        <td class="text-justify p-1"><b>Periodo</b></td>

                        <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                    </tr>
                </thead>
                <tbody>

                     @forelse ($PaquetesPeriodos as $PaquetesPeriodo)
                        <tr>
                            <td class="text-justify p-1">{{$PaquetesPeriodo->paquete->gestion}}</td>
                            <td class="text-justify p-1">{{$PaquetesPeriodo->periodo->mes}}</td>

                            <td class="text-center p-1">



                                <span class="tts:left tts-slideIn tts-custom" aria-label="Eliminar">
                                    <a href="{{ route('entregas.eliminar_periodo',$PaquetesPeriodo->id) }}" onclick="return confirm('Se va a eliminar el Item...')">
                                        <span class="text-danger">
                                            <i class="fa-solid fa-xl fa-trash" aria-hidden="true"></i>
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
            var url = "";
            url = url.replace(':id',idcompra);
            window.location.href = url;
        }

        function print(){
            $(".btn").hide();
            $(".spinner-btn-send").show();

            window.location.href = "";
        }

        function create(){
            $(".btn").hide();
            $(".spinner-btn-send").show();
            var idcompra = $("#idcompra").val();
            var url = "";
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
            if($("#periodo >option:selected").val() == ""){
                message_alert("El campo de seleccion <b>[Periodo]</b> es un dato obligatorio...");
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

    /*var permission_select = new SlimSelect({
        select: '#permissions-select select',
        //showSearch: false,
        placeholder: 'Select Permissions',
        deselectLabel: '<span>&times;</span>',
        hideSelectedOption: true,
    })*/
    </script>
@endsection

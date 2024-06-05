@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>AGREGAR PERIODOS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="form-group row font-roboto-12 abs-center">
            <div class="col-md-12 pr-1 pl-1">
                <a href="{{ route('entregas.index') }}" class="btn btn-outline-primary font-roboto-12">
                    <i class="fa-solid fa-angles-left fa-fw"></i> Ir atras
                </a>
                <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
            </div>
        </div>
        <form actidason="{{ route('entregas.paquete_periodo_agregar',$id_paquete) }}" method="post" id="form">
            @csrf
            <div class="form-group row font-roboto-12 abs-center">
                <div class="col-md-3 pr-1 pl-1">
                    <select name="periodo" id="periodo" placeholder="--Seleccionar--" class="form-control font-roboto-12">
                        <option value="">-</option>
                        @foreach ($periodos as $periodo)
                            <option value="{{ $periodo->id }}">{{ $periodo->mes }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 pr-1 pl-1 text-right">
                    <span class="btn btn-primary font-roboto-12" onclick="save();">
                        <i class="fa-solid fa-plus fa-fw"></i>&nbsp;Adicionar
                    </span>
                    <a href="{{ route('entregas.finalizar',$id_paquete) }}" class="btn btn-success font-roboto-12">
                        <i class="fa-regular fa-circle-up fa-fw"></i>&nbsp;Procesar
                    </a>
                    <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                </div>
            </div>
        </form>
        <br>
        <div class="form-group row abs-center">
            <div class="col-md-6 pr-1 pl-1 table-responsive">
                <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="#{{--dataTable--}}">
                    <thead>
                        <tr class="font-roboto-11">
                            <td class="text-center p-1"><b>GESTION</b></td>
                            <td class="text-center p-1"><b>PERIODO</b></td>
                            <td class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($PaquetesPeriodos as $PaquetesPeriodo)
                           <tr class="font-roboto-11">
                               <td class="text-center p-1">{{$PaquetesPeriodo->paquete->gestion}}</td>
                               <td class="text-center p-1">{{$PaquetesPeriodo->periodo->mes}}</td>
                               <td class="text-center p-1">
                                   <span class="tts:left tts-slideIn tts-custom" aria-label="Eliminar">
                                       <a href="{{ route('entregas.eliminar_periodo',$PaquetesPeriodo->id) }}" onclick="return confirm('Se va a eliminar el Item...')" class="badge-with-padding badge badge-danger">
                                            <i class="fa-solid fa-trash fa-fw" aria-hidden="true"></i>
                                       </a>
                                   </span>
                               </td>
                           </tr>
                       @endforeach
                   </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                language: datatableLanguageConfig,
                order: [[ 0, "asc" ]]
            });

            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            $('#periodo').select2({
                theme: "bootstrap4",
                placeholder: "--Periodo--",
                width: '100%'
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

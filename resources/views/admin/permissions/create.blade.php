@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>REGISTRAR PERMISO</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <form method="post" action="{{ route('permissions.store') }}" id="form">
            @csrf
            <input type="hidden" name="dea_id" value="{{ $dea_id }}">
            <div class="form-group row font-roboto-12 align-items-center">
                <div class="col-md-5 pr-1 pl-1 text-right">
                    <label for="titulo" class="d-inline"><b>Titulo: </b></label>
                </div>
                <div class="col-md-2 pr-1 pl-1">
                    <input type="text" name="titulo" value="{{ old('titulo') }}" id="titulo" class="form-control font-roboto-12 intro">
                </div>
            </div>
            <div class="form-group row font-roboto-12 align-items-center">
                <div class="col-md-5 pr-1 pl-1 text-right">
                    <label for="nombre" class="d-inline"><b>Nombre del permiso: </b></label>
                </div>
                <div class="col-md-3 pr-1 pl-1">
                    <input type="text" name="name" value="{{ old('name') }}" id="name" class="form-control font-roboto-12 intro">
                </div>
            </div>
            <div class="form-group row font-roboto-12 align-items-center">
                <div class="col-md-5 pr-1 pl-1 text-right">
                    <label for="descripcion" class="d-inline"><b>Descripcion: </b></label>
                </div>
                <div class="col-md-4 pr-1 pl-1">
                    <input type="text" name="descripcion" value="{{ old('descripcion') }}" id="name" class="form-control font-roboto-12 intro">
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-12 pr-1 pl-1 text-right">
                    <button class="btn btn-outline-primary font-roboto-12" type="button" onclick="procesar();">
                        <i class="fas fa-paper-plane fa-fw"></i> Procesar
                    </button>
                    <button class="btn btn-outline-danger font-roboto-12" type="button" onclick="cancelar();">
                        <i class="fas fa-times fa-fw"></i> Cancelar
                    </button>
                    <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
        });

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        function procesar() {
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function confirmar(){
            var url = "{{ route('permissions.store') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('permissions.index') }}";
            window.location.href = url;
        }
    </script>
@endsection

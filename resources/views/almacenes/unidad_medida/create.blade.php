@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('sucursal.configuracion') }}"> Configuracion</a></li>
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('unidad.medida.index') }}"> Unidades de medida</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Registrar</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fas fa-balance-scale fa-fw"></i>&nbsp;<b class="title-size">REGISTRO DE UNIDAD DE MEDIDA</b>
            </div>
        </div>

        <div class="card-body">
            @include('almacenes.unidad_medida.partials.form-create')
        </div>
    </div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tipo').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });
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
            var url = "{{ route('unidad.medida.store') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('unidad.medida.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection

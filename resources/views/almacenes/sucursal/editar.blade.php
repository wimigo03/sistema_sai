@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('sucursal.configuracion') }}"> Configuracion</a></li>
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('sucursal.index') }}"> Sucursales</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Editar</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fa fa-shop fa-fw"></i>&nbsp;<b class="title-size">MODIFICAR SUCURSAL</b>
            </div>
        </div>

        <div class="card-body">
            @include('almacenes.sucursal.partials.form-editar')
        </div>
    </div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2({
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
            if(!validar()){
                return false;
            }
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function validar(){
            if($("#nombre").val() == ""){
                Modal("<center>[ERROR AL VALIDAR NOMBRE DEL ALMACEN]</center>");
                return false;
            }
            return true;
        }

        function confirmar(){
            var url = "{{ route('sucursal.update') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('sucursal.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection

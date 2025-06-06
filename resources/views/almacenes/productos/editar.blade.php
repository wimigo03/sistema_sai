@extends('layouts.dashboard')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('home.index') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('sucursal.configuracion') }}"> Configuracion</a></li>
    <li class="breadcrumb-item font-roboto-14"><a href="{{ route('producto.index') }}">Materiales</a></li>
    <li class="breadcrumb-item font-roboto-14 active">Modificar</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row d-flex align-items-center">
                <i class="fa-solid fa-list-ul fa-fw"></i>&nbsp;<b class="title-size">MODIFICAR REGISTRO MATERIAL</b>
            </div>
        </div>

        <div class="card-body">
            @include('almacenes.productos.partials.form-editar')
        </div>
    </div>
@section('scripts')
    <script type="text/javascript">
        @if ($producto->estado == '2')
            window.onload = function() {
                var elementos = document.querySelectorAll('.form-control');
                elementos.forEach(function(elemento) {
                    elemento.disabled = true;
                });
            };
        @endif

        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            $('.input-numero-cleave').each(function() {
                new Cleave(this, {
                    numeral: true,
                    numeralDecimalScale: 2,
                    numeralThousandsGroupStyle: 'thousand'
                });
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
            document.getElementById("partida_presupuestaria_id").removeAttribute("disabled");
            document.getElementById("codigo").removeAttribute("disabled");
            var url = "{{ route('producto.update') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function validar() {
            if($("#partida_presupuestaria_id >option:selected").val() == ""){
                Modal("<b>[ERROR] . </b> La Partida Presupuestaria es un dato obligatorio.");
                return false;
            }
            if($("#nombre").val() == ""){
                Modal("<b>[ERROR] . </b> El Nombre del material es un dato obligatorio.");
                return false;
            }
            if($("#unidad_id >option:selected").val() == ""){
                Modal("<b>[ERROR] . </b> La Unidad de Medida es un dato obligatorio.");
                return false;
            }
            if($("#precio").val() == ""){
                Modal("<b>[ERROR] . </b> La Precio es un dato obligatorio.");
                return false;
            }
            return true;
        }

        function cancelar(){
            var url = "{{ route('producto.index') }}";
            window.location.href = url;
        }

        function habilitar(){
            var item_id = $("#item_id").val();
            var url = "{{ route('producto.habilitar', ':id') }}";
            url = url.replace(':id', item_id);
            window.location.href = url;
        }

        function inhabilitar(){
            var item_id = $("#item_id").val();
            var url = "{{ route('producto.inhabilitar', ':id') }}";
            url = url.replace(':id', item_id);
            window.location.href = url;
        }
    </script>
@endsection
@endsection

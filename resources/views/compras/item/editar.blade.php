@extends('layouts.admin')
@section('content')
    <div class="card-body">
        <div class="form-group row font-roboto-20">
            <div class="col-md-12 text-center linea-completa">
                <strong>MODIFICAR ITEM</strong>
            </div>
        </div>
        @include('compras.item.partials.form-editar')
    </div>
@section('scripts')
    <script type="text/javascript">
        @if ($item->estado == '2')
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
            document.getElementById("codigo").removeAttribute("disabled");
            var url = "{{ route('item.update') }}";
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
            var url = "{{ route('item.index') }}";
            window.location.href = url;
        }

        function habilitar(){
            var item_id = $("#item_id").val();
            var url = "{{ route('item.habilitar', ':id') }}";
            url = url.replace(':id', item_id);
            window.location.href = url;
        }

        function inhabilitar(){
            var item_id = $("#item_id").val();
            var url = "{{ route('item.inhabilitar', ':id') }}";
            url = url.replace(':id', item_id);
            window.location.href = url;
        }
    </script>
@endsection
@endsection

@extends('layouts.dashboard')
@section('content')
    <div class="card-body">
        <div class="row abs-center">
            <div class="col-md-10">
                <div class="form-group row font-roboto-18">
                    <div class="col-md-12 text-center linea-completa">
                        <strong>REGISTRAR PROVEEDOR</strong>
                    </div>
                </div>
                @include('compras.proveedor.partials.form-create')
            </div>
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

            var cleave = new Cleave('#nro_ci', {
                numeral: true,
                numeralDecimalMark: '',
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: true
            });

            var cleave = new Cleave('#nit', {
                numeral: true,
                numeralDecimalMark: '',
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: true
            });

            var cleave = new Cleave('#telefono', {
                numeral: true,
                numeralDecimalMark: '',
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: true
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
            var url = "{{ route('proveedor.store') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            var url = "{{ route('proveedor.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection

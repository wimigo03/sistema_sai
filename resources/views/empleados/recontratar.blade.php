@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>RECONTRATAR PERSONAL</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('empleados.partials.recontratar-form')
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.nav-link.active').addClass('font-weight-bold');
            $('.nav-link').on('shown.bs.tab', function (e) {
                $('.nav-link').removeClass('font-weight-bold');
                $(e.target).addClass('font-weight-bold');
            });

            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            var cleave = new Cleave('#natalicio', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#natalicio").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            var cleave = new Cleave('#anhos_servicio', {
                numeral: true,
                numeralDecimalScale: 2,
                rawValueTrimPrefix: true
            });

            var cleave = new Cleave('#telefono', {
                numeral: true,
                numeralDecimalScale: 0,
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: false
            });

            var cleave = new Cleave('#nit', {
                numeral: true,
                numeralDecimalScale: 0,
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: false
            });

            var cleave = new Cleave('#fecha_ingreso', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha_ingreso").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            check_poai();

            var cleave = new Cleave('#exp_poai', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#exp_poai").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            check_declaracion_jurada();

            var cleave = new Cleave('#exp_declaracion_jurada', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#exp_declaracion_jurada").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            check_sippase();

            var cleave = new Cleave('#exp_sippase', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#exp_sippase").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            check_induccion();

            var cleave = new Cleave('#exp_induccion', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#exp_induccion").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            check_programacion_vacacion();

            var cleave = new Cleave('#exp_progvacacion', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#exp_progvacacion").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            verificar_tipo();
        });

        function check_poai() {
            var checkbox = document.getElementById('poai');
            if (checkbox.checked) {
                document.getElementById('exp_poai').disabled = false;
            } else {
                document.getElementById('exp_poai').value = '';
                document.getElementById('exp_poai').disabled = true;
            }
        }

        function check_declaracion_jurada() {
            var checkbox = document.getElementById('declaracion_jurada');
            if (checkbox.checked) {
                document.getElementById('exp_declaracion_jurada').disabled = false;
            } else {
                document.getElementById('exp_declaracion_jurada').value = '';
                document.getElementById('exp_declaracion_jurada').disabled = true;
            }
        }

        function check_sippase() {
            var checkbox = document.getElementById('sippase');
            if (checkbox.checked) {
                document.getElementById('exp_sippase').disabled = false;
            } else {
                document.getElementById('exp_sippase').value = '';
                document.getElementById('exp_sippase').disabled = true;
            }
        }

        function check_induccion() {
            var checkbox = document.getElementById('induccion');
            if (checkbox.checked) {
                document.getElementById('exp_induccion').disabled = false;
            } else {
                document.getElementById('exp_induccion').value = '';
                document.getElementById('exp_induccion').disabled = true;
            }
        }

        function check_programacion_vacacion() {
            var checkbox = document.getElementById('progvacacion');
            if (checkbox.checked) {
                document.getElementById('exp_progvacacion').disabled = false;
            } else {
                document.getElementById('exp_progvacacion').value = '';
                document.getElementById('exp_progvacacion').disabled = true;
            }
        }

        $('#tipo').on('change', function() {
            verificar_tipo();
        });

        function verificar_tipo(){
            if($("#tipo >option:selected").val() != ""){
                if($("#tipo >option:selected").val() == "2"){
                    document.getElementById('n_contrato').disabled = false;
                    document.getElementById('n_preventivo').disabled = false;
                }else{
                    document.getElementById('n_contrato').value = '';
                    document.getElementById('n_contrato').disabled = true;
                    document.getElementById('n_preventivo').value = '';
                    document.getElementById('n_preventivo').disabled = true;
                }
            }
        }

        function eliminarEspaciosEnBlanco() {
            var input_nro_carnet = document.getElementById('nro_carnet');
            input_nro_carnet.value = input_nro_carnet.value.replace(/\s/g, '');
            var input_libreta_militar = document.getElementById('libreta_militar');
            input_libreta_militar.value = input_libreta_militar.value.replace(/\s/g, '');
        }

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('imagePreview');
                output.innerHTML = '<img src="' + reader.result + '" width="65"; height: auto;>';
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
        });

        function procesar() {
            if(!validar()){
                return false;
            }
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function validar() {
            if ($("#nombre").val() == "") {
                Modal('El campo <b>[Nombre]</b> es un dato obligaorio.');
                return false;
            }
            if ($("#nro_carnet").val() == "") {
                Modal('El campo <b>[Numero de carnet]</b> es un dato obligatorio.');
                return false;
            }
            if($("#extension >option:selected").val() == ""){
                Modal("El campo de seleccion <b>[Extension]</b> es un dato obligatorio...");
                return false;
            }
            if($("#area_id >option:selected").val() == ""){
                Modal("El campo de seleccion <b>[Area]</b> es un dato obligatorio...");
                return false;
            }
            if($("#cargo_id >option:selected").val() == ""){
                Modal("El campo de seleccion <b>[Cargo]</b> es un dato obligatorio...");
                return false;
            }
            if ($("#fecha_ingreso").val() == "") {
                Modal('El campo <b>[Fecha de ingreso]</b> es un dato obligatorio.');
                return false;
            }
            if($("#tipo >option:selected").val() == ""){
                Modal("El campo de seleccion <b>[Tipo]</b> es un dato obligatorio...");
                return false;
            }

            var checkbox_poai = document.getElementById('poai');
            if (checkbox_poai.checked) {
                if($("#exp_poai").val() == ""){
                    Modal("El campo de seleccion <b>[Fecha de expiracion de POAI]</b> es un dato obligatorio...");
                    return false;
                }
            }

            var checkbox_declaracion_jurada = document.getElementById('declaracion_jurada');
            if (checkbox_declaracion_jurada.checked) {
                if($("#exp_declaracion_jurada").val() == ""){
                    Modal("El campo de seleccion <b>[Fecha de expiracion de la declaracion jurada]</b> es un dato obligatorio...");
                    return false;
                }
            }

            var checkbox_sippase = document.getElementById('sippase');
            if (checkbox_sippase.checked) {
                if($("#exp_sippase").val() == ""){
                    Modal("El campo de seleccion <b>[Fecha de expiracion del SIPPASE]</b> es un dato obligatorio...");
                    return false;
                }
            }

            var checkbox_induccion = document.getElementById('induccion');
            if (checkbox_induccion.checked) {
                if($("#exp_induccion").val() == ""){
                    Modal("El campo de seleccion <b>[Fecha de expiracion de induccion]</b> es un dato obligatorio...");
                    return false;
                }
            }

            var checkbox_programacion_vacacion = document.getElementById('progvacacion');
            if (checkbox_programacion_vacacion.checked) {
                if($("#exp_progvacacion").val() == ""){
                    Modal("El campo de seleccion <b>[Fecha de expiracion de programacion de vacacion]</b> es un dato obligatorio...");
                    return false;
                }
            }
            return true;
        }

        function confirmar(){
            var url = "{{ route('empleado.procesar.recontrato') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('empleado.index') }}";
            window.location.href = url;
        }
    </script>
@endsection

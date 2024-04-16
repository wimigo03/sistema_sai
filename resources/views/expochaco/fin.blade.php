@extends('layouts.admin3')
@section('content')
    @include('layouts.message_alert')









    <div align='center'>

        <div class="body-border col-md-7" style="background-color: #FFFFFF;">
            <label for="cantidad" class="d-inline font-verdana-12">
                <H5><b>..SU REGISTRO FUE PROCESADO EXITOSAMENTE..</b></H5><p></p><b>DIRIJASE A OFICINAS PARA COMPLETAR EL
                    PROCESO.

                   <p></p>
                    <b>OFICINA: CALLE CREVAUX ENTRE COMERCIO Y MARTIN BARROSO. </b>
                    <p></p>
                    <b>TELEFONOS: 72241462 - 72676526. </b>
            </label>
            <div class="form-group row">
                <div class="col-md-12 text-center">
                    <p></p>
                    <button class="btn color-icon-2 font-verdana-12" type="button" onclick="save();">
                        <i class="fa-solid fa-paper-plane"></i>
                        Aceptar
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select').select2({
                placeholder: "--Seleccionar--"
            });
        });


        function save() {

                $(".btn").hide();
                $(".spinner-btn-send").show();
                window.location.href = "{{ url('https://granchaco.gob.bo/') }}";

        }


    </script>
@endsection

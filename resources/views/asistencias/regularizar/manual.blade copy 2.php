@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="row font-verdana-bg">
        <div class="col-md-8 titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
                <a href="{{route('agregar.regulacion', $registroAsistencia->empleado_id)}}" class="color-icon-1">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>
            </span>

            <b>Regularizar Asistencia Registrada</b>
        </div>


        <div class="col-md-4 text-right">
            <a class="tts:left tts-slideIn tts-custom" aria-label="Recargar">
                <button class="btn btn-sm btn-primary font-verdana" onclick="recargarPagina()">
                    &nbsp; <i class="fa-solid fa-rotate-right"></i>&nbsp;
                </button>
            </a>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
        </div>
    </div>
    <!-- Campos del formulario -->
    <div class="row font-verdana-sm">
        <div class="col-md-6 table-responsive center">
 
            <div class="body-border ">
                @if($registroAsistencia->horario->tipo == 0)
                <div class="row">
                    <div class="form-group col-md-12 form-check">
                        <b>HORARIO :</b>

                        <hr class="hrr">
                        <div class="row">
                            <div class="form-group col-md-12 form-check">
                                <b>TURNO CONTINUO :</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 form-check-sm">
                                <br><b>MARCADO DE ENTRADA:</b></br>
                                <label for="asignado" id="label1">Biometrico</label>
                                <input type="checkbox" name="asignado" id="asignado1" class="form-control" onclick="toggleLabel('label1', 'asignado1', 'registroH_inicio', 'registro_inicio')">
                                <input type="time" id="registroH_inicio" name="registro_entrada" class="form-control" value="{{ $registroAsistencia->horario->hora_inicio }}" required>

                            </div>
                            <div class="form-group col-md-6 form-check">
                                <br><b>MARCADO DE SALIDA:</b></br>
                                <label for="asignado" id="label4">Biometrico</label>
                                <input type="checkbox" name="asignado" id="asignado4" class="form-control" onclick="toggleLabel('label4', 'asignado4','registroH_final','registro_final')">
                                <input type="time" id="registroH_final" name="registro_final" class="form-control" value="{{ $registroAsistencia->horario->hora_final}}" required>
                            </div>

                        </div>
                    </div>


                    <div class="form-group col-md-12">
                        <div class="row">
                            <div class="form-group col-md-12 form-check">
                                <b>REGULARIZADO :</b>

                                <hr class="hrr">
                            </div>
                        </div>

                        <div class="row">

                            <!-- Agrega más campos según sea necesario -->
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckDefault">
                                    BOLETA OFICIAL
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="BOLETA OFICIAL" id="flexCheckDefault">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    COMUNICACIóN INTERNA
                                </label>

                                <input class="form-control checkbox" type="checkbox" value="COMUNICACION INTERNA" id="flexCheckDefault1">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckChecked2">
                                    LICENCIAS
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="LICENCIAS" id="flexCheckChecked2">

                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckChecked3">
                                    VACACIONES
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="VACACIONES" id="flexCheckChecked3">

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 form-check">
                                <hr class="hr">
                            </div>
                        </div>

                        <div class="form-group row font-verdana-bg">

                            @if(isset($permiso))
                            <!-- Agrega más campos según sea necesario -->
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckDefault0">
                                    BOLETA PERSONAL
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="BOLETA PERSONAL" id="flexCheckDefault0">
                            </div>
                            <div class="form-check">
                                <b>Fecha de <br>Solicitud:</b> {{ $permiso->fecha_solicitud }}</p>

                            </div>
                            <div class="form-check">
                                <b>Hora de <br>Retorno:</b> {{ $permiso->hora_retorno }}</p>

                            </div>
                            @else
                            <div class="form-check">
                                <p>No se encontró <br>ningún permiso</p>

                            </div>
                            @endif


                        </div>
                    </div>
                </div>
                @else
                <div class="row font-verdana-sm">
                    <div class="form-group col-md-12 form-check">
                        <b>HORARIO :</b>

                        <hr class="hrr">


                        <div class="row">

                            <div class="form-group col-md-6 form-check">

                                <div class="row">
                                    <div class="form-group col-md-12 form-check">
                                        <b>TURNO MAÑANA :</b>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 form-check">
                                        <br><b>ENTRADA:</b></br>
                                        <label for="asignado" id="label1">Biometrico</label>
                                        <input type="checkbox" name="asignado" id="asignado1" class="form-control" onclick="toggleLabel('label1', 'asignado1', 'registroH_inicio', 'registro_inicio')">
                                        <input type="time" id="registroH_inicio" name="registro_inicio" class="form-control form-control-sm" value="{{ $registroAsistencia->horario->hora_inicio }}" required>

                                    </div>
                                    <div class="form-group col-md-6 form-check">
                                        <br><b>SALIDA:</b></br>
                                        <label for="asignado" id="label2">Biometrico</label>
                                        <input type="checkbox" name="asignado" id="asignado2" class="form-control" onclick="toggleLabel('label2', 'asignado2', 'registroH_salida', 'registro_salida')">
                                        <input type="time" id="registroH_salida" name="registro_salida" class="form-control form-control-sm" value="{{ $registroAsistencia->horario->hora_salida }}" required>

                                    </div>

                                </div>
                            </div>
                            <div class="form-group col-md-6 form-check">

                                <div class="row">
                                    <div class="form-group col-md-12 form-check">
                                        <b>TURNO TARDE :</b>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 form-check">
                                        <br><b>ENTRADA:</b></br>
                                        <label for="asignado" id="label3">Biometrico</label>
                                        <input type="checkbox" name="asignado" id="asignado3" class="form-control" onclick="toggleLabel('label3', 'asignado3','registroH_entrada','registro_entrada')">
                                        <input type="time" id="registroH_entrada" name="registro_entrada" class="form-control form-control-sm" value="{{ $registroAsistencia->horario->hora_entrada }}" required>

                                    </div>
                                    <div class="form-group col-md-6 form-check">
                                        <br><b>SALIDA:</b></br>
                                        <label for="asignado" id="label4">Biometrico</label>
                                        <input type="checkbox" name="asignado" id="asignado4" class="form-control" onclick="toggleLabel('label4', 'asignado4','registroH_final','registro_final')">
                                        <input type="time" id="registroH_final" name="registro_final" class="form-control form-control-sm" value="{{ $registroAsistencia->horario->hora_final}}" required>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="row">
                            <div class="form-group col-md-12 form-check">
                                <b>REGULARIZADO :</b>

                                <hr class="hrr">
                            </div>
                        </div>

                        <div class="row">

                            <!-- Agrega más campos según sea necesario -->
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckDefault">
                                    BOLETA OFICIAL
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="BOLETA OFICIAL" id="flexCheckDefault">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    COMUNICACIóN INTERNA
                                </label>

                                <input class="form-control checkbox" type="checkbox" value="COMUNICACION INTERNA" id="flexCheckDefault1">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckChecked2">
                                    LICENCIAS
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="LICENCIAS" id="flexCheckChecked2">

                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckChecked3">
                                    VACACIONES
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="VACACIONES" id="flexCheckChecked3">

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 form-check">
                                <hr class="hr">
                            </div>
                        </div>

                        <div class="form-group row font-verdana-bg">

                            @if(isset($permiso))
                            <!-- Agrega más campos según sea necesario -->
                            <div class="form-check">
                                <label class="form-check-label" for="flexCheckDefault0">
                                    BOLETA PERSONAL
                                </label>
                                <input class="form-control checkbox" type="checkbox" value="BOLETA PERSONAL" id="flexCheckDefault0">
                            </div>
                            <div class="form-check">
                                <b>Fecha de <br>Solicitud:</b> {{ $permiso->fecha_solicitud }}</p>

                            </div>
                            <div class="form-check">
                                <b>Hora de <br>Retorno:</b> {{ $permiso->hora_retorno }}</p>

                            </div>
                            @else
                            <div class="form-check">
                                <p>No tiene Boletas de Salida Personal Registrada</p>

                            </div>
                            @endif


                        </div>
                    </div>
                </div>
                @endif
            </div>


        </div>

         <div class="col-md-6 table-responsive center">

            <div class="body-border ">
                <b>DATOS DE REGISTRO DE ASISTENCIA:</b>
                <hr class="hrr">

                <form method="POST" action="{{ route('regularizar_asistencia.update', $registroAsistencia->id) }} " id="actualizarForm">
                    @csrf
                    @method('PUT')

                    <div class="form-group row ">
                        <div class="form-group col-md-6">
                            <label for="descripcion"><b>Nombres y Apellidos :</b></label>
                            <input type="text" name="descripcion" value="{{ $registroAsistencia->empleado->nombres }} {{$registroAsistencia->empleado->ap_pat}} {{$registroAsistencia->empleado->ap_mat}}" class="form-control form-control-sm" readonly>
                            <input type="hidden" name="observ" value="Regularizado" class="form-control form-control-sm" readonly>

                        </div>

                        <div class="form-group col-md-6">
                            <label for="fecha"><b>Fecha :</b></label>
                            <input type="date" name="fecha" class="form-control form-control-sm" value="{{ $registroAsistencia->asistencia->fecha }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row font-verdana-sm">
                        @if($registroAsistencia->registro_inicio)
                        <div class="form-group col-md-6">
                            <label for="registro_inicio"><b>Registro de Entrada</b></label>
                            <input type="time" id="registro_inicio" name="registro_inicio" class="form-control form-control-sm" value="{{ $registroAsistencia->registro_inicio }}" readonly>
                        </div>
                        @else
                        <div class="form-group col-md-6">
                            <label for="registro_inicio"><b>Registro de Entrada</b></label>
                            <input type="time" id="registro_inicio" name="registro_inicio" class="form-control form-control-sm" value="">
                        </div>
                        @endif
                        @if($registroAsistencia->registro_final)
                        <div class="form-group col-md-6">
                            <label for="registro_final"><b>Registro de Salida</b> </label>
                            <input type="time" id="registro_final" name="registro_final" class="form-control form-control-sm" value="{{ $registroAsistencia->registro_final }}" readonly>
                        </div>
                        @else
                        <div class="form-group col-md-6">
                            <label for="registro_final"><b>Registro de Salida</b> </label>
                            <input type="time" id="registro_final" name="registro_final" class="form-control form-control-sm" value="">
                        </div>
                        @endif
                    </div>
                    @if($registroAsistencia->horario->tipo == 0)

                    @else
                    <b>DESCANZO:</b>
                    <div class="col-md-12">
                        <hr class="hrr">
                    </div>
                    <div class="form-group row font-verdana-sm">
                        @if($registroAsistencia->registro_salida)
                        <div class="form-group col-md-6">
                            <label for="registro_salida">Hora de salida</label>
                            <input type="time" id="registro_salida" name="registro_salida" class="form-control form-control-sm" value="{{ $registroAsistencia->registro_salida }}" readonly required>
                        </div>
                        @else
                        <div class="form-group col-md-6">
                            <label for="registro_salida">Hora de salida</label>
                            <input type="time" id="registro_salida" name="registro_salida" class="form-control form-control-sm" value="">
                        </div>
                        @endif
                        @if($registroAsistencia->registro_entrada)
                        <div class="form-group col-md-6">
                            <label for="registro_entrada">Hora de retorno</label>
                            <input type="time" id="registro_entrada" name="registro_entrada" class="form-control form-control-sm" value="{{ $registroAsistencia->registro_entrada }}" readonly required>
                        </div>
                        @else
                        <div class="form-group col-md-6">
                            <label for="registro_entrada">Hora de retorno</label>
                            <input type="time" id="registro_entrada" name="registro_entrada" class="form-control form-control-sm" value="">
                        </div>
                        @endif
                    </div>
                    @endif
                    <div class="col-md-12 form-check">

                        <label for="asignado"><b>OBSERVACIONES:</b></label><br>

                        <input type="hidden" id="observ2" name="observ2" class="form-control form-control-sm" value="{{$registroAsistencia->observ}}">

                        <textarea class="form-control form-control-sm" name="observ" id="exampleTextarea" rows="5" required>{{$registroAsistencia->observ}}</textarea>

                    </div>

                    <div class="col-md-12 text-right">
                        <hr class="hrr">
                        <button type="submit" class="btn btn-success">Regularizar</button>
                    </div>

                </form>

            </div>
    </div>
</div>
</div>
</div>




<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmarModal" tabindex="-1" role="dialog" aria-labelledby="confirmarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmarModalLabel">Confirmar Actualización</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas actualizar el horario?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmarBtn">Confirmar</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')


<script>
    // Variable para almacenar el valor original de registro_inicio
    var originalRegistroInicioValue = $("#registro_inicio").val();

    function toggleLabel(labelId, checkboxId, sourceInputId, targetInputId) {
        // Obtener el texto original del label
        var originalText = $("#" + labelId).text();

        // Verificar el estado actual del checkbox
        var isChecked = $("#" + checkboxId).prop("checked");

        // Cambiar el texto del label según el estado del checkbox
        $("#" + labelId).text(isChecked ? originalText + " (MANUAL)" : originalText.replace(" (MANUAL)", ""));

        // Obtener el valor del input fuente
        var sourceValue = $("#" + sourceInputId).val();

        // Asignar el valor del input fuente al input destino si el checkbox está marcado
        $("#" + targetInputId).val(isChecked ? sourceValue : originalRegistroInicioValue);
    }
</script>

<!-- Agrega este script al final de tu vista Blade -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var confirmarBtn = document.getElementById('confirmarBtn');
        var confirmarModal = new bootstrap.Modal(document.getElementById('confirmarModal'));

        confirmarBtn.addEventListener('click', function() {
            // Simplemente envía el formulario cuando el usuario confirma
            document.forms['actualizarForm'].submit();
            confirmarModal.hide();
        });

        // Agrega un event listener al formulario para evitar el envío directo
        document.forms['actualizarForm'].addEventListener('submit', function(event) {
            event.preventDefault();
            confirmarModal.show();
        });
    });
</script>
<script>
    function recargarPagina() {
        location.reload(true); // El parámetro true fuerza la recarga desde el servidor y no desde la caché
    }
</script>
<script>
    $(document).ready(function() {
        $('.checkbox').change(function() {
            var text = '';
            $('.checkbox:checked').each(function() {
                text += $(this).val() + '\n';
            });
            $('#exampleTextarea').val(text.trim());
        });
        $('.checkbox').change(function() {
            updateTextarea();
            // Almacenar el estado en el campo oculto
            $('#observ2').val($('#exampleTextarea').val());
        });

        // Leer el valor almacenado en el campo oculto al cargar la página
        var storedValue = $('#observ2').val();
        if (storedValue) {
            // Dividir el valor en líneas y marcar los checkboxes correspondientes
            var lines = storedValue.split('\n');
            lines.forEach(function(line) {
                $('.checkbox[value="' + line.trim() + '"]').prop('checked', true);
            });
            updateTextarea();
        }
    });
</script>
@endsection
@endsection
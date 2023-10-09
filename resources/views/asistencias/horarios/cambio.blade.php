@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row  font-verdana">
        <div class="col-md-8 titulo mt-3">
            <b>Modificar Horarios Asignados</b>
        </div>
        <div class="col-md-4 text-right">
            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{ route('empleadoasistencias.index') }}">
                <button class="btn btn-sm btn-danger font-verdana" type="button" aria-label="Cerrar">
                    &nbsp;<i class="fa fa-times" aria-hidden="true"></i>&nbsp;
                </button>
            </a>
        </div>
    </div>
    <div class="row font-verdana">
        <div class="col-md-12">
            <!-- Dentro de tu vista -->
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            @if(session('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
            @endif
            <hr class="hrr">
        </div>
        <div class="col-md-12 table-responsive center font-verdana">
            <div class="body-border">
                <form action="{{ route('horarios.guardar', $empleado->idemp) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Primera Fila -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>NOMBRES y APELLIDOS</label>
                                <input type="text" readonly class="form-control" value="{{ $empleado->nombres }} {{ $empleado->ap_pat }} {{ $empleado->ap_mat }}">
                            </div>
                        </div>
                    </div>

                    <!-- Fin de la Primera Fila -->

                    <div class="form-group row">
                        <label for="horarios" class="col-md-12 col-form-label">{{ __('HORARIOS') }}</label>

                        <div class="col-md-12" id="horarios-select">
                            <select name="horarios[]" id="horarios" class="@error('horarios') is-invalid @enderror" class="form-control" required multiple>
                                @foreach ($horarios as $id => $horario)
                                @php
                                // Obtén el horario completo a partir del ID
                                $horarioCompleto = $horariosCompletos->firstWhere('id', $id);
                    
                          
                                @endphp
                                <option value="{{ $id }}"     {{ (in_array($id, old('horarios', [])) || $empleado->horarios->contains($id)) ? 'selected' : '' }}>
                                    {{ $horario }} -   {{ $horarioCompleto->hora_entrada ?? 'N/A' }} -   {{ $horarioCompleto->hora_salida ?? 'N/A' }} - Estado: {{ $horarioCompleto->estado ?? 'N/A' }}
                                </option>
                                @endforeach
 


                            </select>
                            <a href="#" id="horario-select-all" class="btn btn-success  btn-sm">Seleccionar Todo</a>
                            <a href="#" id="horario-deselect-all" class="btn btn-danger  btn-sm">Quitar Selección</a>

                            @error('horarios')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                    </div>


                    <!-- Campos para los horarios -->

                    <!-- Fin de los Campos para los horarios -->

                    <!-- Botón para actualizar -->
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>



</div>
@endsection
@section('scripts')
<script>
    var horario_select = new SlimSelect({
        select: '#horarios-select select',
        //showSearch: false,
        placeholder: 'Seleccionar Horarios',
        deselectLabel: '<span>&times;</span>',
        hideSelectedOption: true,
    })

    $('#horarios-select #horario-select-all').click(function() {
        var options = [];
        $('#horarios-select select option').each(function() {
            options.push($(this).attr('value'));
        });

        horario_select.set(options);
    })

    $('#horarios-select #horario-deselect-all').click(function() {
        horario_select.set([]);
    })
</script>
@endsection
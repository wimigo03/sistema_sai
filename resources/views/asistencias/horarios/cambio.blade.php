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
        <div class="col-md-6 center font-verdana">
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
                        <!-- ... (código anterior) ... -->

                        <div class="col-md-12" id="horarios-select">
                            <select name="horarios[]" id="horarios" class="@error('horarios') is-invalid @enderror" class="form-control" required>
                                @foreach ($horarios as $id => $horario)
                                @php
                                $horarioCompleto = $horariosCompletos->firstWhere('id', $id);
                                @endphp
                                <option value="{{ $id }}" data-horario-info="{{ json_encode($horarioCompleto) }}" {{ ($horarioCompleto->estado == 1 && (in_array($id, old('horarios', [])) || $empleado->horarios->contains($id))) ? 'selected' : '' }}>
                                    @if($horarioCompleto->estado == 1)
                                    <!-- Resaltar los horarios con estado 1 -->
                                    <strong>
                                        @endif
                                        Mañana: {{ $horarioCompleto->hora_inicio ?? '-' }} - {{ $horarioCompleto->hora_salida ?? ' - ' }} - Tarde:{{ $horarioCompleto->hora_entrada ?? '-' }} - {{ $horarioCompleto->hora_final ?? 'N/A' }}
                                        @if($horarioCompleto->estado == 1)
                                        <!-- Cerrar la etiqueta strong -->
                                    </strong>
                                    @endif
                                </option>
                                @endforeach
                            </select>

                            @error('horarios')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- ... (código posterior) ... -->

                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
        

    </div>



</div>
@section('scripts')
<script>
    var horario_select = new SlimSelect({
        select: '#horarios-select select',
        placeholder: 'Seleccionar Horarios',
        deselectLabel: '<span>&times;</span>',
        hideSelectedOption: true
    });
</script>
@endsection



@endsection
@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row  font-verdana">
        <div class="col-md-8 titulo ">
         Cambios de Horarios Personal
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
        <b>Modificar Horarios Asignados</b>
            <div class="body-border">
                <form action="{{ route('horarios.guardar', $empleado->idemp) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Primera Fila -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label> <b>NOMBRES y APELLIDOS</b></label>
                                <input type="text" readonly class="form-control" value="{{ $empleado->nombres }} {{ $empleado->ap_pat }} {{ $empleado->ap_mat }}">
                            </div>
                        </div>
                    </div>

                    <!-- Fin de la Primera Fila -->

                    <div class="form-group row">
                        <label for="horarios" class="col-md-12 col-form-label"> <b>{{ __('HORARIOS') }}</b></label>
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
                                        Mañana: {{ $horarioCompleto->hora_inicio ?? '-' }} - {{ $horarioCompleto->hora_salida ?? ' - ' }} - Tarde:{{ $horarioCompleto->hora_entrada ?? '-' }} - {{ $horarioCompleto->hora_final ?? '-' }}
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
                    <p>Este empleado tiene horarios activos.</p>

                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
        <div class="col-md-6 center font-verdana">
        <b>Datos de Control Asignados</b>
            <div class="body-border">
                <form action="{{ route('pin.guardar', $empleado->idemp) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Primera Fila -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>HUELLAS DACTILARES</b></label>
                                <input type="text" readonly class="form-control" value="{{ $cantidadHuellas }}">


                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                @if ($cantidadHuellas > 0)
                                <label>
                                    @for ($i = 0; $i < $cantidadHuellas; $i++) <i class="fa-solid fa-2xl fa-fingerprint"></i>
                                        @endfor
                                </label>
                                <p>Este empleado tiene {{ $cantidadHuellas }} huellas dactilares:</p>

                                @else
                                <p>Este empleado no tiene huellas dactilares registradas.</p>
                                @endif
                            </div>


                        </div>

                    </div>

                    <!-- Fin de la Primera Fila -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="horarios" class="col-md-12 col-form-label"><b>{{ __('PIN') }}<b></label>
                                <!-- ... (código anterior) ... -->
                                <div class="form-group">
                                    <input type="password" class="form-control" id="pin" name="pin"  value="{{$empleado->pin}}" required>
                                </div>
                                <!-- ... (código posterior) ... -->

                            </div>

                        </div>
                        <div class="col-md-6">
                            <label for="opcion" class="col-md-12 col-form-label">{{ __('OPCION') }}</label>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="btnActualizar">Actualizar</button>
                            </div>
                        </div>
                    </div>
                </form>
                     <!-- ...  <input type="hidden" class="form-control" id="pin2" name="pin2" maxlength="4" value="{{$empleado->pin}}" required>... -->

            <!-- ... <button class="btn btn-success" onclick="obtenerValor()">Obtener Valor</button> ... -->

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
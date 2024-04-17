@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row  font-verdana">
        <div class="col-md-8 titulo ">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Ir a gestionar-c">
                <a href="{{route('empleadoasistencias.index') }}" class="color-icon-1">
                    <i class="fa fa-lg fa-reply" aria-hidden="true"></i>
                </a>
            </span>
            Horarios y Datos de Control de Personal
        </div>
        <div class="col-md-4 text-right">

            <a class="tts:left tts-slideIn tts-custom" aria-label="Cerrar" href="{{ route('admin.home') }}">
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
            <b>Horario Asignado</b>
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
                            <select name="horarios[]" id="horarios" class="@error('horarios') is-invalid @enderror" class="form-control" required >
                                @foreach ($horarios as $id => $horario)
                                @php
                                $horarioCompleto = $horariosCompletos->firstWhere('id', $id);
                                @endphp
                                <option value="{{ $id }}" data-horario-info="{{ json_encode($horarioCompleto) }}" {{ ($horarioCompleto->estado == 1 && (in_array($id, old('horarios', [])) || $empleado->horarios->contains($id))) ? 'selected' : '' }}>
                                    @if($horarioCompleto->estado == 1)
                                    <!-- Resaltar los horarios con estado 1 -->
                                    <strong>
                                        @endif
                                        {{ $horarioCompleto->hora_inicio ?? '-' }} - {{ $horarioCompleto->hora_salida ?? ' - ' }} - {{ $horarioCompleto->hora_entrada ?? '-' }} - {{ $horarioCompleto->hora_final ?? '-' }} <strong> {{ $horarioCompleto->Nombre ?? '-' }}</strong>

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

                    <!--    <button type="submit" class="btn btn-primary">Actualizar</button> ... -->
                    <button type="submit" class="btn btn-primary">Actualizar</button> 

                </form>
            </div>
        </div>
        <div class="col-md-6 center font-verdana">
            <b>Datos de Control Asignados</b>
            <div class="body-border">


                <!-- Primera Fila -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>HUELLAS DACTILARES</b></label><br>
                            @if ($cantidadHuellas->count() > 0)
                            <label>
                                @for ($i = 0; $i < $cantidadHuellas->count(); $i++)
                                    <i class="fa-solid fa-2xl fa-fingerprint"></i>
                                    @endfor
                            </label>
                            <p>Este empleado tiene {{ $cantidadHuellas->count() }} huellas dactilares:</p>
                            @else
                            <p>Este empleado no tiene huellas dactilares registradas.</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>OPCIONES:</b></label>

                            <div class="row">


                                @foreach ($cantidadHuellas as $huella)

                                <div class="col-md-3 mb-3">
                                    <div>
                                        <i class="fa-solid fa-2xl fa-fingerprint"></i>
                                        <!-- Agrega más contenido según sea necesario -->

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">

                                    <form action="{{ route('huellas.update-estado', $huella->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        @if($huella->estado == 1)
                                        <button type="submit" class="btn btn-danger btn-sm">Desactivar</button>
                                        @else
                                        <button type="submit" class="btn btn-success btn-sm">Activar</button>
                                        @endif
                                    </form>
                                </div>

                                @endforeach
                            </div>
                        </div>
                    </div>



                </div>

                <!-- Fin de la Primera Fila -->

                <div class="row">


                </div>

                <!-- ...  <input type="hidden" class="form-control" id="pin2" name="pin2" maxlength="4" value="{{$empleado->pin}}" required>... -->

                <!-- ... <button class="btn btn-success" onclick="obtenerValor()">Obtener Valor</button> ... -->

                <form action="{{ route('pin.guardar', $empleado->idemp) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Primera Fila -->


                    <!-- Fin de la Primera Fila -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="horarios" class="col-md-12 col-form-label"><b>{{ __('PIN') }}<b></label>
                                <!-- ... (código anterior) ... -->
                                <div class="form-group">
                                    <input type="password" class="form-control" id="pin" name="pin" value="{{$empleado->pin}}" required>
                                </div>
                                @if (!$empleado->pin)
                                <!-- ... (código posterior) ... -->

                                @else
                                <p>Este empleado tiene código PIN registradas.</p>
                                @endif
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
@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>ACTUALIZAR CORRESPONDENCIA</b>
            </div>
        </div>
    </div>
    <input type="hidden" value="{{ $recepcion->id_recepcion }}" id="recepcion_id">
    <div class="card-body body">
        <form method="post" action="{{ route('correspondencia.local.update', $recepcion->id_recepcion) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group row font-roboto-12">
                <div class="col-md-2 pr-1 pl-1">
                    <label for="fecha" class="d-inline"><b>Fecha recepcion</b></label>
                    <input type="text" name="fecha" placeholder="dd/mm/aaaa" class="form-control font-roboto-12" id="fecha" data-language="es" value="{{ $fecha_d_m_y }}">
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-10 pr-1 pl-1">
                    <label for="remitente" class="d-inline"><b>Remitente</b></label>
                    <select name="emp" id="emp" class="form-control font-roboto-12 select2">
                        @foreach ($remitentes as $remitente)
                            @if ($recepcion->id_remitente == $remitente->id_remitente)
                                <option value="{{ $remitente->id_remitente }}" selected>
                                    {{ $remitente->nombres_remitente }}
                                    {{ $remitente->apellidos_remitente }}
                                    --
                                    {{ $remitente->nombre_unidad }}
                                </option>
                            @else
                                <option value="{{ $remitente->id_remitente }}">
                                    {{ $remitente->nombres_remitente }}
                                    {{ $remitente->apellidos_remitente }}
                                    --
                                    {{ $remitente->nombre_unidad }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-10 pr-1 pl-1">
                    <label for="asunto" class="d-inline"><b>Asunto</b></label>
                    <textarea type="text" name="asunto" class="form-control font-roboto-12" id="asunto" onchange="javascript:this.value=this.value.toUpperCase();" required>{{ $recepcion->asunto }}</textarea>
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-2 pr-1 pl-1">
                    <label for="codigo" class="d-inline"><b>Codigo</b></label>
                    <input type="text" name="codigo" class="form-control font-roboto-12" value="{{ $recepcion->n_oficio }}" required>
                </div>
                <div class="col-md-2 pr-1 pl-1">
                    <label for="hoja_ruta" class="d-inline"><b>Hoja de ruta</b></label>
                    <input type="text" name="hojaruta" class="form-control font-roboto-12" value="{{ $recepcion->observaciones }}" required>
                </div>
            </div>
            <div class="form-group row font-roboto-12">
                <div class="col-md-12 pr-1 pl-1 text-right">
                    <button class="btn btn-outline-primary font-roboto-12" type="submit">
                        <i class="fa-solid fa-paper-plane fa-fw"></i> Guardar
                    </button>
                    <button class="btn btn-outline-danger font-roboto-12" type="button" onclick="cancelar();">
                        <i class="fas fa-times fa-fw"></i> Cancelar
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });
        });

        function cancelar(){
            var id = $("#recepcion_id").val();
            var url = "{{ route('correspondencia.local.gestionar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        $("#fecha").datepicker({
            inline: false,
            dateFormat: "dd/mm/yyyy",
            autoClose: true
        });
    </script>
@endsection

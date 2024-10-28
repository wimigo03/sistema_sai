@extends('layouts.admin')
@section('content')
    <div class="form-group row font-roboto-16">
        <div class="col-md-12 text-center">
            <strong>FORMULARIO EDICION DETALLE</strong>
        </div>
    </div>
    <form action="#" method="post" id="form">
        @csrf
        <input type="hidden" id="mantenimiento_id" value="{{ $edicion->mantenimiento_id }}">
        <input type="hidden" name="mantenimiento_detalle_id" value="{{ $edicion->id }}">
        <div class="card" style="border: 2px solid #17A2B8;">
            <div class="card-body">
                <div class="row font-roboto-12">
                    <div class="col-md-6 pr-1 pl-1 mb-2">
                        <label for="procedencia" class="d-inline"><b>Procedencia</b></label>
                        <select id="area_id" class="form-control select2" disabled>
                            <option value="">-</option>
                            @foreach ($areas as $index => $value)
                                <option value="{{ $index }}"
                                    @if(old('area_id') == $index || (isset($mantenimiento) && $mantenimiento->idarea == $index))
                                        selected
                                    @endif>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 pr-1 pl-1 mb-2">
                        <label for="empleado" class="d-inline"><b>Funcionario</b></label>
                        <select id="empleado_id" class="form-control select2" disabled>
                            <option value="">-</option>
                            @foreach ($empleados as $index => $value)
                                <option value="{{ $index }}"
                                    @if(old('empleado_id') == $index || (isset($mantenimiento) && $mantenimiento->idemp == $index))
                                        selected
                                    @endif>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 pr-1 pl-1 mb-2">
                        <label for="nro_comunicacion_interna" class="d-inline"><b>Nro Comunicacion Interna</b></label>
                        <input type="text" id="nro_comunicacion_interna" value="{{ isset($mantenimiento) ? $mantenimiento->nro_comunicacion_interna : old('nro_comunicacion_interna') }}" oninput="this.value = this.value.toUpperCase()" class="form-control font-roboto-11 intro" disabled>
                    </div>
                    <div class="col-md-12 pr-1 pl-1 mb-2">
                        <label for="observaciones" class="d-inline"><b>Observaciones</b></label>
                        <textarea id="observaciones" class="form-control font-roboto-11 intro" oninput="this.value = this.value.toUpperCase()" disabled>{{ isset($mantenimiento) ? $mantenimiento->observaciones : old('observaciones') }}</textarea>
                    </div>
                </div>
                <div class="row font-roboto-12">
                    <div class="col-md-2 pr-1 pl-1 mb-2">
                        <label for="codigo_serie" class="d-inline"><b>Codigo/Nro. Serie</b></label>
                        <input type="text" name="codigo_serie" value="{{ $edicion->codigo_serie }}" id="codigo_serie" oninput="this.value = this.value.toUpperCase()" class="form-control font-roboto-11 intro">
                    </div>
                    <div class="col-md-2 pr-1 pl-1 mb-2">
                        <label for="clasificacion" class="d-inline"><b>Clasificacion</b></label>
                        <select name="clasificacion" id="clasificacion" class="form-control select2">
                            <option value="">-</option>
                            @foreach ($clasificaciones as $index => $value)
                                <option value="{{ $index }}"
                                    @if($edicion->clasificacion == $index) selected @endif>{{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-8 pr-1 pl-1 mb-2">
                        <label for="problema" class="d-inline"><b>Estado del Equipo</b></label>
                        <input type="text" name="descripcion" value="{{ $edicion->problema_equipo }}" id="problema" class="form-control font-roboto-11 intro" oninput="this.value = this.value.toUpperCase()">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 pr-1 pl-1">
                        <table id="tabla_detalle" class="table table-striped table-bordered hover-orange" style="width:100%;">
                            <thead>
                                <tr class="font-roboto-11">
                                    <td class="text-justify p-1"><b>N°</b></td>
                                    <td class="text-justify p-1"><b>CODIGO/SERIE</b></td>
                                    <td class="text-justify p-1"><b>CLASIFICION</b></td>
                                    <td class="text-justify p-1"><b>ESTADO DEL EQUIPO</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($mantenimiento_detalles))
                                    @php
                                        $cont = 1;
                                    @endphp
                                    @foreach($mantenimiento_detalles as $datos)
                                        <tr class="@if ($edicion->id == $datos->id) bg-warning @endif font-roboto-11">
                                            <td class="text-justify p-1">{{ $cont++ }}</td>
                                            <td class="text-justify p-1">{{ $datos->codigo_serie }}</td>
                                            <td class="text-justify p-1">{{ $datos->clasificacion_equipo }}</td>
                                            <td class="text-justify p-1">{{ $datos->problema_equipo }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 pr-1 pl-1 text-center">
                        <span class="btn btn-lg btn-primary font-roboto-12" onclick="procesar();" id="btn-proceso">
                            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>&nbsp;Continuar
                        </span>
                        <span class="btn btn-lg btn-danger font-roboto-12" onclick="cancelar();">
                            <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
                        </span>
                        <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                    </div>
                </div>
            </div>
        </div>
    </form>
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

        function Modal(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        function valideNumberSinDecimal(evt) {
            var code = (evt.which) ? evt.which : evt.keyCode;
            if ((code >= 48 && code <= 57) || code === 8) {
                return true;
            } else {
                return false;
            }
        }

        function cancelar(){
            var mantenimiento_id = $("#mantenimiento_id").val();
            var url = "{{ route('mantenimientos.editar', ':id') }}";
            url = url.replace(':id', mantenimiento_id);
            window.location.href = url;
        }

        function procesar() {
            if(!validar_detalle()){
                return false;
            }
            var url = "{{ route('mantenimientos.updateDetalle') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function validar_detalle() {
            if ($("#codigo_serie").val() == "") {
                Modal("<b>[ERROR. CODIGO/SERIE]</b>");
                return false;
            }
            if ($("#clasificacion >option:selected").val() == "") {
                Modal("<b>[ERROR. CLASIFICACION]</b>");
                return false;
            }
            if ($("#problema").val() == "") {
                Modal("<b>[ERROR. PROBLEMA]</b>");
                return false;
            }
            return true;
        }
    </script>
@endsection

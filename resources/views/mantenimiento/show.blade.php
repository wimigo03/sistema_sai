@extends('layouts.admin')
@section('content')
    <div class="form-group row font-roboto-16">
        <div class="col-md-12 text-center">
            <strong>DETALLE DEL MANTENIMIENTO</strong>
        </div>
    </div>
    <form action="#" method="post" id="form">
        @csrf
        <div class="card" style="border: 2px solid #17A2B8;">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-12 pr-1 pl-1">
                        @if ($mantenimiento->estado == '1')
                            <span class="btn btn-success font-roboto-12" onclick="finalizar();">
                                <i class="fa-solid fa-bolt fa-fw"></i> Finalizar
                            </span>
                        @else
                            @if( Auth::user()->id == 102)
                                <span class="btn btn-warning font-roboto-12" onclick="habilitar();">
                                    <i class="fa-solid fa-bolt fa-fw"></i> Habilitar
                                </span>
                            @endif
                        @endif
                        <span class="btn btn-danger font-roboto-12 float-right" onclick="pdf();">
                            <i class="fas fa-file-pdf fa-fw"></i>
                        </span>
                        @if ($mantenimiento->estado == '1')
                            <span class="btn btn-warning font-roboto-12 float-right mr-1" onclick="editar();">
                                <i class="fas fa-edit fa-fw"></i>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row font-roboto-12">
                    <div class="col-md-4 pr-1 pl-1 mb-2">
                        <label for="procedencia" class="d-inline"><b>Procedencia</b></label>
                        <input type="text" value="{{ $mantenimiento->area->nombrearea }}" class="form-control font-roboto-11" disabled>
                    </div>
                    <div class="col-md-3 pr-1 pl-1 mb-2">
                        <label for="empleado" class="d-inline"><b>Funcionario Encargado</b></label>
                        <input type="text" value="{{ $mantenimiento->funcionario != null ? $mantenimiento->funcionario->full_name : 'NO REGISTRADO' }}" class="form-control font-roboto-11" disabled>
                    </div>
                    <div class="col-md-1 pr-1 pl-1 mb-2">
                        <label for="nro_comunicacion_interna" class="d-inline"><b>N° C. I.</b></label>
                        <input type="text" value="{{ $mantenimiento->nro_comunicacion_interna }}" class="form-control font-roboto-11" disabled>
                    </div>
                    <div class="col-md-2 pr-1 pl-1 mb-2">
                        <label for="registrado" class="d-inline"><b>Registrado por</b></label>
                        <input type="text" value="{{ strtoupper($mantenimiento->user->name) }}" class="form-control font-roboto-11" disabled>
                    </div>
                    <div class="col-md-2 pr-1 pl-1 mb-2">
                        <label for="hora_registro" class="d-inline"><b>Fecha y Hora</b></label>
                        <input type="text" value="{{ \Carbon\Carbon::parse($mantenimiento->f_h_registro)->format('d/m/Y H:i') }}" class="form-control font-roboto-11" disabled>
                    </div>
                    <div class="col-md-12 pr-1 pl-1 mb-2">
                        <label for="observaciones" class="d-inline"><b>Observaciones</b> (Si Corresponde)</label>
                        <textarea class="form-control font-roboto-11" disabled>{{ $mantenimiento->observaciones }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card" style="border: 2px solid #17A2B8;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 pr-1 pl-1">
                        <table id="tabla_detalle" class="table table-striped table-bordered hover-orange" style="width:100%;">
                            <thead>
                                <tr class="font-roboto-10">
                                    <td class="text-justify p-1"><b>N°</b></td>
                                    <td class="text-justify p-1"><b>CODIGO/SERIE</b></td>
                                    <td class="text-justify p-1"><b>CLASIFICION</b></td>
                                    <td class="text-justify p-1"><b>ESTADO DEL EQUIPO</b></td>
                                    <td class="text-justify p-1"><b>DIAGNOSTICO</b></td>
                                    <td class="text-justify p-1"><b>TRABAJO REALIZADO</b></td>
                                    <td class="text-center p-1"><b>ESTADO</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($mantenimiento_detalles))
                                    @php
                                        $cont = 1;
                                        $disabled = '';
                                        if($mantenimiento->estado == '2'){
                                            $disabled = 'disabled';
                                        }
                                    @endphp
                                    @foreach($mantenimiento_detalles as $datos)
                                        <tr data-codigo-serie="{{ $datos->codigo_serie }}" class="detalle-{{ $datos->id }} font-roboto-10">
                                            <td class="text-justify p-1" style="vertical-align: middle;">
                                                <input type="hidden" name="id[]" value="{{ $datos->id }}" {{ $disabled }}>
                                                {{ $cont++ }}
                                            </td>
                                            <td class="text-justify p-1" style="vertical-align: middle;">{{ $datos->codigo_serie }}</td>
                                            <td class="text-justify p-1" style="vertical-align: middle;">{{ $datos->clasificacion_equipo }}</td>
                                            <td class="text-justify p-1" style="vertical-align: middle;">{{ $datos->problema_equipo }}</td>
                                            <td class="text-center p-1">
                                                <textarea name="diagnostico[]" class="form-control font-roboto-10 diagnostico" oninput="this.value = this.value.toUpperCase()" {{ $disabled }}>{{ $datos->diagnostico }}</textarea>
                                            </td>
                                            <td class="text-center p-1">
                                                <textarea name="solucion_equipo[]" class="form-control font-roboto-10 solucion_equipo" oninput="this.value = this.value.toUpperCase()" {{ $disabled }}>{{ $datos->solucion_equipo }}</textarea>
                                            </td>
                                            <td class="text-center p-1" style="vertical-align: middle;">
                                                <span class="{{ $datos->color_status }}">
                                                    {{ $datos->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 pr-1 pl-1 text-center">
                        @if ($mantenimiento->estado == '1')
                            <span class="btn btn-lg btn-primary font-roboto-12" onclick="procesar();" id="btn-proceso">
                                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>&nbsp;Procesar
                            </span>
                        @endif
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
            window.location.href = "{{ route('mantenimientos.index') }}";
        }

        function procesar() {
            var url = "{{ route('mantenimientos.store.detalle') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function editar(){
            var id = "{{ $mantenimiento->id }}";
            var url = "{{ route('mantenimientos.editar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function pdf(){
            var id = "{{ $mantenimiento->id }}";
            var url = "{{ route('mantenimientos.pdf', ':id') }}";
            url = url.replace(':id', id);
            window.open(url, '_blank');
        }

        function finalizar(){
            var id = "{{ $mantenimiento->id }}";
            var url = "{{ route('mantenimientos.finalizar', ':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function habilitar(){
            var id = "{{ $mantenimiento->id }}";
            var url = "{{ route('mantenimientos.habilitar', ':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@endsection

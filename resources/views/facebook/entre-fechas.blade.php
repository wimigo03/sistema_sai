@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>ENTRE FECHAS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <form action="#" method="get" id="form">
            <div class="form-group row">
                <div class="col-md-7 pr-1 pl-1">
                    <input type="hidden" name="dea_id" value="{{ $dea_id }}" id="dea_id">
                    <select name="area_id" id="area_id" class="form-control select2">
                        <option value="">-</option>
                        @foreach ($areas as $index => $value)
                            <option value="{{ $index }}" @if(request('area_id') == $index) selected @endif >{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 pr-1 pl-1">
                    <input type="text" name="fecha_i" value="{{ request('fecha_i') }}" id="fecha_i" placeholder="--Inicio--" class="form-control font-roboto-12 intro" data-language="es">
                </div>
                <div class="col-md-2 pr-1 pl-1">
                    <input type="text" name="fecha_f" value="{{ request('fecha_f') }}" id="fecha_f" placeholder="--Final--" class="form-control font-roboto-12 intro" data-language="es">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6 pr-1 pl-1">
                    <span class="btn btn-outline-primary font-roboto-12" onclick="limpiar();">
                        <i class="fas fa-angle-double-left fa-fw"></i> Ir atras
                    </span>
                    <span class="tts:right tts-slideIn tts-custom root" aria-label="Exportar a excel" style="cursor: pointer;">
                        <span class="btn btn-outline-success font-roboto-12" onclick="excel();">
                            <i class="fas fa-file-excel fa-fw"></i>
                        </span>
                    </span>
                    <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                </div>
                <div class="col-md-6 pr-1 pl-1 text-right">
                    <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();">
                        <i class="fas fa-search fa-fw"></i> Procesar
                    </span>
                    <span class="btn btn-outline-danger font-roboto-12" onclick="limpiar();">
                        <i class="fas fa-eraser fa-fw"></i> Limpiar
                    </span>
                    <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
                </div>
            </div>
        </form>
        @if (isset($empleados))
            <div class="form-group row abs-center">
                <div class="col-md-12 pr-1 pl-1 table-responsive">
                    <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="#">
                        <thead>
                            <tr class="font-roboto-11">
                                <th class="text-center p-1">N°</th>
                                <th class="text-left p-1">AREA</th>
                                <th class="text-left p-1">CARGO</th>
                                <th class="text-center p-1">TIPO</th>
                                <th class="text-left p-1">NOMBRE COMPLETO</th>
                                <th class="text-center p-1">NRO CI</th>
                                <th class="text-center p-1">SHARES</th>
                                <th class="text-center p-1">LIKES</th>
                                <th class="text-center p-1">COMMENTS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($empleados as $datos)
                                <tr class="font-roboto-11">
                                    <td class="text-left p-1">{{ $cont++ }}</td>
                                    <td class="text-left p-1">{{ $datos->empleado->area->nombrearea }}</td>
                                    <td class="text-left p-1">{{ $datos->empleado->cargo_file . ' - ' . $datos->empleado->file_cargo }}</td>
                                    <td class="text-center p-1">{{ $datos->empleado->ultimo_tipo_contrato }}</td>
                                    <td class="text-left p-1">{{ $datos->empleado->nombres . ' ' . $datos->empleado->ap_pat . ' ' . $datos->empleado->ap_mat }}</td>
                                    <td class="text-center p-1">{{ $datos->empleado->ci . ' - ' . $datos->empleado->extension }}</td>
                                    <td class="text-center p-1">{{ $datos->total_shares }}</td>
                                    <td class="text-center p-1">{{ $datos->total_likes }}</td>
                                    <td class="text-center p-1">{{ $datos->total_comments }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#area_id').select2({
                theme: "bootstrap4",
                placeholder: "--Todas las areas--",
                width: '100%'
            });

            var cleave = new Cleave('#fecha_i', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            var cleave = new Cleave('#fecha_f', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha_i").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            $("#fecha_f").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
        });

        function procesar(){
            var url = "{{ route('facebook.search.entre.fechas') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function excel(){
            var url = "{{ route('facebook.excel.entre.fechas') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var dea_id = $("#dea_id").val()
            var url = "{{ route('facebook.entre.fechas',':dea_id') }}";
            url = url.replace(':dea_id',dea_id);
            window.location.href = url;
        }
    </script>
@endsection

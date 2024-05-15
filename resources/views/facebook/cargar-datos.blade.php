@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>REGISTRAR PUBLICACION</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="form-group row font-roboto-12">
            <div class="col-md-6 pr-1 pl-1">
                <label for="titulo" class="d-inline"><b>Titulo.- </b></label>
                {{ $facebook->titulo }}
            </div>
            <div class="col-md-6 pr-1 pl-1">
                <label for="fecha" class="d-inline"><b>Fecha.- </b></label>
                {{ Carbon\Carbon::parse($facebook->fecha)->format('d/m/Y') }}
            </div>
        </div>
        <div class="form-group row font-roboto-12">
            <div class="col-md-12 pr-1 pl-1">
                <label for="enlace" class="d-inline"><b>Enlace.- </b></label>
                <a href="{{$facebook->publicacion}}" target="_blank">
                    {{ $facebook->publicacion }}
                </a>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-4 pr-1 pl-1">
                <span class="btn btn-outline-primary font-roboto-12" onclick="cancelar();">
                    <i class="fas fa-angle-double-left fa-fw"></i> Ir atras
                </span>
                <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
            </div>
            <div class="col-md-4 pr-1 pl-1">
                <input type="text" id="busqueda" class="form-control font-roboto-12 text-center" onkeyup="search();" placeholder="--Buscar nombre completo--">
            </div>
            <div class="col-md-4 pr-1 pl-1 text-right">
                <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();">
                    <i class="fas fa-paper-plane fa-fw"></i> Actualizar
                </span>
                <span class="btn btn-outline-danger font-roboto-12" onclick="cancelar();">
                    <i class="fas fa-times fa-fw"></i> Cancelar
                </span>
                <i class="fa fa-spinner fa-spin fa-lg fa-fw spinner-btn" style="display: none;"></i>
            </div>
        </div>
        <form action="#" method="post" id="form">
            @csrf
            <input type="hidden" name="facebook_id" value="{{ $facebook->id }}">
            <div class="form-group row abs-center">
                <div class="col-md-12 pr-1 pl-1 table-responsive">
                    <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="#">
                        <thead>
                            <tr class="font-roboto-11">
                                <th class="text-center p-1">N°</th>
                                <th class="text-center p-1">AREA</th>
                                <th class="text-center p-1">CARGO</th>
                                <th class="text-center p-1">TIPO</th>
                                <th class="text-center p-1">NOMBRE COMPLETO</th>
                                <th class="text-center p-1">NRO C.I.</th>
                                <th class="text-center p-1">SHARE</th>
                                <th class="text-center p-1">LIKE</th>
                                <th class="text-center p-1">COMMENT</th>
                                {{--<th class="text-center p-1"><i class="fa fa-bars" aria-hidden="true"></i></th>--}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($facebook_detalles as $datos)
                                <tr class="font-roboto-11 fila {{ $datos->id }}">
                                    <td class="text-left p-1">{{ $cont++ }}</td>
                                    <td class="text-left p-1">{{ $datos->area->nombrearea }}</td>
                                    <td class="text-left p-1">{{ $datos->empleado->file_cargo }}</td>
                                    <td class="text-center p-1">{{ $datos->empleado->ultimo_tipo_contrato }}</td>
                                    <td class="text-left p-1 nombre_completo">{{ $datos->empleado->nombres . ' ' . $datos->empleado->ap_pat . ' ' . $datos->empleado->ap_mat }}</td>
                                    <td class="text-center p-1">{{ $datos->empleado->ci }}</td>
                                    <td class="text-center p-1">
                                        <input type="checkbox" name="share[]" value="{{ $datos->id }}" {{ $datos->_share == '1' ? 'checked' : '' }}>
                                    </td>
                                    <td class="text-center p-1">
                                        <input type="checkbox" name="like[]" value="{{ $datos->id }}" {{ $datos->_like == '1' ? 'checked' : '' }}>
                                    </td>
                                    <td class="text-center p-1">
                                        <input type="checkbox" name="comment[]" value="{{ $datos->id }}" {{ $datos->_comment == '1' ? 'checked' : '' }}>
                                    </td>
                                    {{--@canany(['facebook.cargar.datos','facebook.editar'])
                                        <td class="text-center p-1">
                                            <div class="d-flex justify-content-center">
                                                @can('facebook.cargar.datos')
                                                    <span class="tts:left tts-slideIn tts-custom" aria-label="Cargar datos" style="cursor: pointer;">
                                                        <a href="{{ route('facebook.cargar.datos',$datos->id) }}" class="badge-with-padding badge badge-primary">
                                                            <i class="fas fa-list fa-fw"></i>
                                                        </a>
                                                    </span>
                                                @endcan
                                            </div>
                                        </td>
                                    @endcanany--}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        function search(){
            let valor = $("#busqueda").val().toUpperCase();
            if(valor != ""){
                $(".fila").hide();
                $(".nombre_completo").each(function() {
                    let textoCelda = $(this).text().toUpperCase();
                    if(textoCelda.includes(valor)) {
                        $(this).closest('.fila').show();
                    }
                });
            } else {
                $(".fila").show();
            }
        }

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                procesar();
                event.preventDefault();
            }
        });

        function procesar() {
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function confirmar(){
            var url = "{{ route('facebook.actualizar.datos') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('facebook.index') }}";
            window.location.href = url;
        }
    </script>
@endsection

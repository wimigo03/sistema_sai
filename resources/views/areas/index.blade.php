<!DOCTYPE html>
@extends('layouts.dashboard')
@section('content')
    @if (isset($areas))
        <div class="card-header header">
            <div class="row">
                <div class="col-md-12 pr-1 pl-1 text-center">
                    <b>ORGANIGRAMA</b>
                </div>
            </div>
        </div>
        <br>
        <div class="form-group row">
            <div class="col-md-12">
                <div class="card card-body">
                    <div id="contenido font-roboto-12">
                        <input type="hidden" value="{{ $areas[0]->idarea  }}" name="area_id" id="area_id">
                        @include('areas.partials.contenido')
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-md-11">
                            <div id="treeview" class="font-roboto-12"></div>
                        </div>
                        <div class="col-md-1 text-right">
                            @can('areas.create')
                                <span class="tts:left tts-slideIn tts-custom root" aria-label="Crear un dependiente" style="cursor: pointer;">
                                    <span class="btn btn-sm btn-outline-success font-verdana mb-1" onclick="create();" id="btn_create">
                                        <i class="fas fa-plus fa-fw"></i>
                                    </span>
                                </span>
                            @endcan
                            @can('areas.editar')
                                <span class="tts:left tts-slideIn tts-custom root" aria-label="Modificar datos" style="cursor: pointer;">
                                    <span class="btn btn-sm btn-outline-warning font-verdana mb-1" onclick="editar();" id="btn_editar">
                                        <i class="fas fa-edit fa-fw"></i>
                                    </span>
                                </span>
                            @endcan
                            @can('areas.eliminar')
                                <span class="tts:left tts-slideIn tts-custom root" aria-label="Eliminar area" style="cursor: pointer;">
                                    <span class="btn btn-sm btn-outline-danger font-verdana mb-1" onclick="procesar();" id="btn_eliminar">
                                        <i class="fas fa-eraser fa-fw"></i>
                                    </span>
                                </span>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#btn_create").hide();
            $("#btn_editar").hide();
            $("#btn_eliminar").hide();
        });

        var Modal = function(mensaje){
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({keyboard: false});
        }

        $(function () {
            var nodo_id = {{ request('nodeId', 0) }};

            $('#treeview').jstree({
                'core': {
                    'data': {!! json_encode($tree) !!},
                    'themes' : {
                        'variant' : 'large',
                        'animation' : 0
                    }
                }
            });

            $('#treeview').on('activate_node.jstree', function (e, data) {
                if (data.node && data.node.children.length > 0) {
                    $('#treeview').jstree('toggle_node', data.node);
                }
                datos_area(data.node.id);
            });

            $('#treeview').on('ready.jstree', function () {
                $('#treeview').jstree('select_node', nodo_id);
                if(nodo_id != ''){
                    datos_area(nodo_id);
                }
            });

            function datos_area(id){
                $("#btn_create").show();
                $("#btn_editar").show();
                $("#btn_eliminar").show();

                $.ajax({
                    type: 'GET',
                    url: '/area/get_datos/'+id,
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(json){
                        $('#area_id').val(json.area_id);
                        $('#dependiente').text(json.dependiente);
                        $('#nombre').text(json.nombre);
                        $('#tipo').text(json.tipo);
                        $('#nivel').text(json.nivel);
                        $('#estado').text(json.estado);
                    },
                    error: function(xhr){
                        console.log(xhr.responseText);
                    }
                });
            }
        });

        function create(){
            var area_id = $("#area_id").val()
            var url = "{{ route('area.create',':area_id') }}";
            url = url.replace(':area_id',area_id);
            window.location.href = url;
        }

        function editar(){
            var id = $("#area_id").val();
            var url = "{{ route('area.editar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }

        function procesar() {
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function confirmar(){
            var id = $("#area_id").val();
            var url = "{{ route('area.eliminar',':id') }}";
            url = url.replace(':id',id);
            window.location.href = url;
        }
    </script>
@endsection

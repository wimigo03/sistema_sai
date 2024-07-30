<!DOCTYPE html>
@extends('layouts.admin')
<style>
    .jstree li > a > .jstree-icon {
        display:none !important;
    }
    #treeview {
        min-height: 200px;
    }
    #treeview li a {
        font-size: 11px;
        font-family: "Roboto", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    }
    .bordered-group {
        position: relative;
        padding: 10px; /* Espacio interno */
        margin: 10px; /* Ajustar el margen si es necesario */
        border-radius: 5px; /* Esquinas redondeadas */
    }
    .bordered-group::before {
        content: '';
        display: block;
        border: 1px solid #ccc;
        border-radius: 10px; /* Esquinas redondeadas */
        position: absolute;
        top: 0;
        left: 5px;
        right: 5px;
        bottom: 0;
        pointer-events: none; /* Permite la interacción con el contenido dentro del borde */
    }
</style>
@section('content')
    <div class="card-body">
        <div class="form-group row font-roboto-20">
            <div class="col-md-12 text-center linea-completa">
                <strong>PARTIDAS PRESUPUESTARIAS</strong>
            </div>
        </div>
        @if (isset($partidas_presupuestarias))
            <div class="row bordered-group" id="view-detalle">
                <div class="col-md-12">
                    <div class="form-group row font-roboto-12">
                        <div class="col-md-8">
                            <label for="categoria_programatica" class="d-inline"><b>Categoria Programatica</b></label>
                            <input type="hidden" name="partida_presupuestaria_id" id="partida_presupuestaria_id">
                            <input type="text" id="categoria_programatica" placeholder="--Partida Presupuestaria Seleccionada--" class="form-control font-roboto-11" disabled>
                        </div>
                    </div>
                    <div class="row font-roboto-12">
                        <div class="col-md-12">
                            <label for="partida_presupuetaria_detalle" class="d-inline"><b>Partida Presupuestaria Detalle</b></label>
                            <textarea id="partida_presupuestaria_detalle" placeholder="--Partida Presupuestaria Seleccionada--" class="form-control font-roboto-11" disabled></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row bordered-group">
                <div class="col-md-12">
                    <div class="form-group row font-roboto-12">
                        <div class="col-md-11 pr-1 pl-1">
                            <div id="treeview"></div>
                        </div>
                        <div class="col-md-1 text-right">
                            <span class="tts:left tts-slideIn tts-custom mb-1" id="btn-create-principal" aria-label="Registrar Partida Presupuestaria Principal" style="cursor: pointer;">
                                <span class="btn btn-sm btn-primary font-roboto-12" onclick="createPartidaPresupuestariaPrincipal();">
                                    <i class="fa-solid fa-plus fa-fw"></i>
                                </span>
                            </span>
                            <span class="tts:left tts-slideIn tts-custom mb-1" id="btn-create-dependiente" aria-label="Registrar Partida Presupuestaria Dependiente" style="cursor: pointer;">
                                <span class="btn btn-sm btn-success font-roboto-12" onclick="createPartidaPresupuestariaDependiente();">
                                    <i class="fa-solid fa-stream fa-fw"></i>
                                </span>
                            </span>
                            <span class="tts:left tts-slideIn tts-custom" id="btn-modificar" aria-label="Modificar" style="cursor: pointer;">
                                <span class="btn btn-sm btn-warning font-roboto-12" onclick="editar();">
                                    <i class="fa-solid fa-edit fa-fw"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('#btn-partida-prespuestaria').removeClass("btn-outline-dark").addClass("btn-dark");
        $("#btn-create-dependiente").hide();
        $("#btn-modificar").hide();
        $(document).ready(function() {
            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });

            /*var cleave = new Cleave('#codigo', {
                numeral: true,
                numeralDecimalMark: '',
                numeralThousandsGroupStyle: 'none',
                rawValueTrimPrefix: true
            });*/
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

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
                datosPartidaPrespuestaria(data.node.id);
            });

            $('#treeview').on('ready.jstree', function () {
                $('#treeview').jstree('select_node', nodo_id);
                if(nodo_id != ''){
                    datosPartidaPrespuestaria(nodo_id);
                }
            });
        });

        function adjustTextareaHeight(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
        }

        function datosPartidaPrespuestaria(partida_presupuestaria_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'GET',
                url: '/partida-presupuestaria/get_datos',
                data: {
                    _token: CSRF_TOKEN,
                    partida_presupuestaria_id: partida_presupuestaria_id
                },
                success: function(data){
                    if(data.partida_presupuestaria.detalle == '1'){
                        $("#btn-create-dependiente").hide();
                    }else{
                        $("#btn-create-dependiente").show();
                    }

                    $("#btn-modificar").show();

                    if(data.categoria_programatica){
                        document.getElementById("categoria_programatica").value = data.categoria_programatica.codigo + ' - ' + data.categoria_programatica.nombre;
                    }
                    if(data.partida_presupuestaria){
                        document.getElementById("partida_presupuestaria_id").value = data.partida_presupuestaria.id;
                        var textarea = document.getElementById("partida_presupuestaria_detalle");
                        textarea.value = data.partida_presupuestaria.descripcion.toUpperCase();
                        adjustTextareaHeight(textarea);
                    }
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }

        function createPartidaPresupuestariaPrincipal(){
            var url = "{{ route('partida.presupuestaria.create') }}";
            window.location.href = url;
        }

        function createPartidaPresupuestariaDependiente(){
            var partida_presupuestaria_id = $("#partida_presupuestaria_id").val();
            var url = "{{ route('partida.presupuestaria.create',['partida_presupuestaria_id'=> '']) }}";
            url += partida_presupuestaria_id;
            window.location.href = url;
        }

        function editar(){
            var partida_presupuestaria_id = $("#partida_presupuestaria_id").val();
            var url = "{{ route('partida.presupuestaria.editar',['partida_presupuestaria_id'=> '']) }}";
            url += partida_presupuestaria_id;
            window.location.href = url;
        }

        function get_items(){
            var url = "{{ route('item.index') }}";
            window.location.href = url;
        }

        function get_unidades(){
            var url = "{{ route('unidad.medida.index') }}";
            window.location.href = url;
        }

        function search(){
            var url = "{{ route('partida.presupuestaria.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            var url = "{{ route('partida.presupuestaria.index') }}";
            window.location.href = url;
        }
    </script>
@endsection

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
        padding: 10px;
        margin: 10px;
        border-radius: 5px;
        /* background-color: red !important; */
    }
    .bordered-group::before {
        content: '';
        display: block;
        border: 1px solid #ccc;
        border-radius: 10px;
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
        @can('partida.presupuestaria.create')
            <div class="row bordered-group" id="view-detalle">
                <div class="col-md-12 mb-1 text-justify">
                    <input type="hidden" name="partida_presupuestaria_id" id="partida_presupuestaria_id">
                    <span class="font-roboto-11" id="partida_presupuestaria_detalle"></span>
                </div>
            </div>
        @endcan
        @if (isset($partidas_presupuestarias))
            <div class="row">
                <div class="col-md-5">
                    <span class="tts:right tts-slideIn tts-custom" id="btn-create-principal" aria-label="Registrar Partida Presupuestaria Principal" style="cursor: pointer;">
                        <span class="btn btn-sm btn-primary font-roboto-12" onclick="createPartidaPresupuestariaPrincipal();">
                            <i class="fa-solid fa-plus fa-fw"></i>
                        </span>
                    </span>
                    <span class="tts:right tts-slideIn tts-custom" id="btn-exportar-excel" aria-label="Exportar a Excel" style="cursor: pointer;">
                        <span class="btn btn-sm btn-success font-roboto-12" onclick="excel();">
                            <i class="fa-solid fa-file-excel fa-fw"></i>
                        </span>
                    </span>
                    <i class="fa fa-spinner custom-spinner fa-spin fa-lg fa-fw spinner-btn-send" style="display: none;"></i>
                </div>
                <div class="col-md-2">
                    <form action="#" method="get" id="form">
                        <input type="text" name="numeracion" value="{{ request('numeracion') }}" id="numeracion" placeholder="Buscar Codigo" class="form-control font-roboto-12 text-center numero-entero" style="font-weight: bold;">
                    </form>
                </div>
                <div class="col-md-5">
                    <span class="tts:left tts-slideIn tts-custom float-right" id="btn-modificar" aria-label="Modificar" style="cursor: pointer;">
                        <span class="btn btn-sm btn-warning font-roboto-12" onclick="editar();">
                            <i class="fa-solid fa-edit fa-fw"></i>
                        </span>
                    </span>
                    <span class="tts:left tts-slideIn tts-custom float-right mr-1" id="btn-create-dependiente" aria-label="Registrar Partida Presupuestaria Dependiente" style="cursor: pointer;">
                        <span class="btn btn-sm btn-success font-roboto-12" onclick="createPartidaPresupuestariaDependiente();">
                            <i class="fa-solid fa-plus fa-fw"></i>
                        </span>
                    </span>
                </div>
            </div>
            <div class="row bordered-group">
                <div class="col-md-12" style="height:400px;overflow-y: scroll;">
                    <div id="treeview"></div>
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
        $("#view-detalle").hide();

        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });

            $('.numero-entero').each(function() {
                new Cleave(this, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'none',
                    numeralDecimalScale: 0,
                });
            });

            $('#numeracion').on('input', function() {
                let valor = $(this).val().replace(/\D/g, '');
                if (valor.length > 5) {
                    $(this).val(valor.substring(0, 5));
                }
            });
        });

        $(function () {
            var nodo_id = {{ request('nodeId', $search_nodeId) }};

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
                    if(data.partida_presupuestaria){
                        if(data.partida_presupuestaria.detalle == '1'){
                            $("#btn-create-dependiente").hide();
                        }else{
                            $("#btn-create-dependiente").show();
                        }

                        $("#btn-modificar").show();
                        $("#view-detalle").show();

                        document.getElementById("partida_presupuestaria_id").value = data.partida_presupuestaria.id;
                        var div = document.getElementById("partida_presupuestaria_detalle");
                        if(data.partida_presupuestaria.descripcion != null){
                            div.textContent = data.partida_presupuestaria.descripcion.toUpperCase();
                        }else{
                            div.textContent = '';
                        }
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

        /* function excel(){
            var url = "{{ route('partida.presupuestaria.excel') }}";
            window.location.href = url;
        } */

        function excel() {
            var url = "{{ route('partida.presupuestaria.excel') }}";
            $(".btn").hide();
            $(".spinner-btn-send").show();
            $.ajax({
                url: url,
                type: 'GET',
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(response);
                    a.href = url;
                    a.download = 'clasificadores.xlsx';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    $(".spinner-btn-send").hide();
                    $(".btn").show();
                },
                error: function(xhr, status, error) {
                    alert('Hubo un error al exportar el archivo: ' + xhr.responseText);
                    $(".spinner-btn-send").hide();
                    $(".btn").show();
                }
            });
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

        $('#categoria_programatica_id').change(function() {
            var url = "{{ route('partida.presupuestaria.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        });

        function limpiar(){
            var url = "{{ route('partida.presupuestaria.index') }}";
            window.location.href = url;
        }

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function search(){
            var url = "{{ route('partida.presupuestaria.index') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }
    </script>
@endsection

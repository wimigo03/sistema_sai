@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>REGISTRAR USUARIO</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('admin.users.partials._form')
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        if($("#dea >option:selected").val() != ''){
            var id = $("#dea >option:selected").val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            getAreas(id,CSRF_TOKEN);
        }

        if($("#area_idd").val() != ''){
            var id = $("#area_idd").val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            getEmpleados(id,CSRF_TOKEN);
        }

        $('.select2').select2({
            theme: "bootstrap4",
            placeholder: "--Seleccionar--",
            width: '100%'
        });
    });

    $('#dea').change(function() {
        localStorage.clear();
        var id = $(this).val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        getAreas(id,CSRF_TOKEN);
    });

    $('#area_id').change(function() {
        localStorage.clear();
        var id = $(this).val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        getEmpleados(id,CSRF_TOKEN);
    });

    function getAreas(id,CSRF_TOKEN){
        $.ajax({
            type: 'GET',
            url: '/users/get_areas',
            data: {
                _token: CSRF_TOKEN,
                id: id
            },
            success: function(data){
                var arr = Object.values($.parseJSON(data.areas));
                $("#area_id").empty();
                var select = $("#area_id");
                select.append($("<option></option>").attr("value", '').text('--Area--'));
                var areaIdSeleccionado = localStorage.getItem('areaIdSeleccionado');
                $.each(arr, function(index, json) {
                    var opcion = $("<option></option>").attr("value", json.idarea).text(json.nombrearea);
                    if (json.idarea == areaIdSeleccionado) {
                        opcion.attr('selected', 'selected');
                    }
                    select.append(opcion);
                });
                select.on('change', function() {
                    localStorage.setItem('areaIdSeleccionado', $(this).val());
                });
            },
            error: function(xhr){
                console.log(xhr.responseText);
            }
        });
    }

    function getEmpleados(id,CSRF_TOKEN){
        $.ajax({
            type: 'GET',
            url: '/users/get_empleados',
            data: {
                _token: CSRF_TOKEN,
                id: id
            },
            success: function(data){
                var arr = Object.values($.parseJSON(data.empleados));
                $("#empleado_id").empty();
                var select = $("#empleado_id");
                $("#area_idd").val($("#area_id >option:selected").val());
                select.append($("<option></option>").attr("value", '').text('--Empleado--'));
                var empleadoIdSeleccionado = localStorage.getItem('empleadoIdSeleccionado');
                $.each(arr, function(index, json) {
                    var opcion = $("<option></option>").attr("value", json.id).text(json.nombre_completo);
                    if (json.id == empleadoIdSeleccionado) {
                        opcion.attr('selected', 'selected');
                    }
                    select.append(opcion);
                });
                select.on('change', function() {
                    localStorage.setItem('empleadoIdSeleccionado', $(this).val());
                });
            },
            error: function(xhr){
                console.log(xhr.responseText);
            }
        });
    }

    function procesar() {
        $('#modal_confirmacion').modal({
            keyboard: false
        })
    }

    function confirmar(){
        var url = "{{ route('users.store') }}";
        $("#form").attr('action', url);
        $(".btn").hide();
        $(".btn-importar").hide();
        $(".spinner-btn").show();
        $("#form").submit();
    }
    function cancelar(){
        $(".btn").hide();
        $(".btn-importar").hide();
        $(".spinner-btn").show();
        window.location.href = "{{ route('users.index') }}";
    }




    var permission_select = new SlimSelect({
            select: '#permissions-select select',
            //showSearch: false,
            placeholder: 'Select Permissions',
            deselectLabel: '<span>&times;</span>',
            hideSelectedOption: true,
        })

        $('#permissions-select #permission-select-all').click(function(){
            var options = [];
            $('#permissions-select select option').each(function(){
                options.push($(this).attr('value'));
            });

            permission_select.set(options);
        })

        $('#permissions-select #permission-deselect-all').click(function(){
            permission_select.set([]);
        })

        document.getElementById('password-confirm').addEventListener('input', function() {
            document.getElementById('_email').value = this.value;
        });
</script>
@endsection

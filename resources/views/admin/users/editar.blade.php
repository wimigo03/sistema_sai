@extends('layouts.dashboard')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>MODIFICAR USUARIO</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('admin.users.partials.form-editar')
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "--Seleccionar--"
        });
    });

    function procesar() {
        $('#modal_confirmacion').modal({
            keyboard: false
        })
    }

    function confirmar(){
        var url = "{{ route('users.update') }}";
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
        placeholder: 'Select Permissions',
        deselectLabel: '<span>&times;</span>',
        hideSelectedOption: true,
    });

    $('#permissions-select #permission-select-all').click(function(){
        var options = [];
        $('#permissions-select select option').each(function(){
            options.push($(this).attr('value'));
        });

        permission_select.set(options);
    });

    $('#permissions-select #permission-deselect-all').click(function(){
        permission_select.set([]);
    });

    document.getElementById('password-confirm').addEventListener('input', function() {
        document.getElementById('_email').value = this.value;
    });
</script>
@endsection

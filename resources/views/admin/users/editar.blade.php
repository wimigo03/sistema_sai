@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="card card-custom">
    <div class="card-header font-verdana-15">
        <div class="row">
            <div class="col-md-6">
                <b>MODIFICAR USUARIO</b>
            </div>
            <div class="col-md-6 text-right">
                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir atras">
                    <a href="{{ route('users.index') }}" class="text-dark">
                        <i class="fa fa-reply"></i>
                    </a>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('admin.users.partials.form-editar')
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "--Seleccionar--"
        });
    });
    function procesar(){
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
</script>
@endsection

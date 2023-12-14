@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="card card-custom">
    <div class="card-header font-verdana-bgt">
        <div class="row">
            <div class="col-md-6">
                <b>REGISTRO DE ROL</b>
            </div>
            <div class="col-md-6 text-right">
                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir atras">
                    <a href="{{ route('roles.index') }}" class="text-dark">
                        <i class="fa fa-reply"></i>
                    </a>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('admin.roles.partials.form-create')
    </div>
</div>
@endsection
@section('scripts')
    <script>
        function procesar() {
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function confirmar(){
            var url = "{{ route('roles.store') }}";
            $("#form").attr('action', url);
            $(".btn").hide();
            $(".spinner-btn").show();
            $("#form").submit();
        }

        function cancelar(){
            $(".btn").hide();
            $(".spinner-btn").show();
            window.location.href = "{{ route('roles.index') }}";
        }

        var permission_select = new SlimSelect({
            select: '#permissions-select select',
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
    </script>
@endsection

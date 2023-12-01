@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="card card-custom">
    <div class="card-header font-verdana-bgt">
        <div class="row">
            <div class="col-md-6">
                <b>REGISTRO DE USUARIO</b>
            </div>
            <div class="col-md-6 text-right">
                <span class="tts:left tts-slideIn tts-custom" aria-label="Ir atras">
                    <a href="{{ url('admin/users/index') }}" class="text-black">
                        <i class="fa fa-reply"></i>
                    </a>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('admin.users.partials.form')
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
    function store(){
        var url = "{{ route('admin.users.store') }}";
        $("#form").attr('action', url);
        $(".btn").hide();
        $(".btn-importar").hide();
        $(".spinner-btn").show();
        $("#form").submit();
    }
</script>
@endsection

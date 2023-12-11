@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="/css/font-verdana.css" rel="stylesheet">
<div class="header">
    <div class="row font-verdana-bg">
        <div class="col-md-10 titulo">
            <b>CANASTA - HISTORIAL BENEFICIARIO</b>
        </div>
        <div class="col-md-2 titulo text-right">
            <span class="tts:left tts-slideIn tts-custom" aria-label="Ir atras">
                <a href="{{ route('canasta.beneficiarios.index') }}" class="text-black">
                    <i class="fa fa-reply"></i>
                </a>
            </span>
        </div>
        <div class="col-md-12">
            <hr class="hrr">
        </div>
    </div>
    @include('canasta.beneficiarios.partials.show-header')
    <div class="form-group row font-verdana mb-2">
        <div class="col-md-12 text-right">
            <span class="tts:left tts-slideIn tts-custom" aria-label="Exportar a Pdf">
                <a href="{{ route('canasta.beneficiarios.show.pdf',$beneficiario->idUsuario) }}" class="btn btn-danger font-verdana" target="_blank">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>
            </span>
        </div>
    </div>
</div>
@include('canasta.beneficiarios.partials.show-table')
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            /**/
        });
    </script>
@endsection

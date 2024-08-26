<!DOCTYPE html>
@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>BUSCAR BENEFICIARIOS</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <form action="#" method="get" id="form">
            <div class="form-group row abs-center">
                <div class="col-md-2 pr-1 pl-1">
                    <input type="text" name="ci" id="ci" placeholder="--N° de documento--" value="{{ request('ci') }}" class="form-control font-roboto-12 text-center intro" onchange="javascript:this.value=this.value.toUpperCase();">
                </div>
            </div>
            <div class="form-group row abs-center">
                <div class="col-md-2 pr-1 pl-1 mb-2">
                    <span class="btn btn-block btn-outline-primary font-roboto-12" onclick="search();">
                        <i class="fa fa-search fa-fw" aria-hidden="true"></i>&nbsp;Buscar
                    </span>
                </div>
                <div class="col-md-2 pr-1 pl-1">
                    <span class="btn btn-block btn-outline-danger font-roboto-12" onclick="limpiar();">
                        <i class="fa fa-eraser fa-fw"></i>&nbsp;Limpiar
                    </span>
                </div>
            </div>
        </form>

        
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar--",
                width: '100%'
            });
        });

        function Modal(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function search(){
            var url = "{{ route('beneficiarios.brigadista.search') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function limpiar(){
            window.location.href = "{{ route('beneficiarios.brigadista.index') }}";
        }
    </script>
@endsection

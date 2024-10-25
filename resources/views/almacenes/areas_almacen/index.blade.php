@extends('layouts.admin')
@section('content')
<div class="row abs-center">
    <div class="col-md-8">
        <div class="card-body">
            <div class="form-group row abs-center font-roboto-14">
                <div class="col-md-12 text-center linea-completa">
                    <strong>
                        {{ $almacen->nombre }}
                    </strong>
                </div>
            </div>
            @include('almacenes.areas_almacen.partials.search')
            @include('almacenes.areas_almacen.partials.table')
        </div>
    </div>
</div>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#area_id').select2({
                theme: "bootstrap4",
                placeholder: "--Seleccionar Area--",
                width: '100%'
            });

            $('#indexAjax').DataTable({
                "processing":true,
                "iDisplayLength": 10,
                "order": [[ 0, "asc" ]],
                language: datatableLanguageConfig
            });
        });

        function procesar(){
            var url = "{{ route('almacen.asignar.store') }}";
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function cancelar(){
            var url = "{{ route('almacen.index') }}";
            window.location.href = url;
        }
    </script>
@endsection
@endsection

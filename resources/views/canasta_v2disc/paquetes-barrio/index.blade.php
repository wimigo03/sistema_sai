@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>CRONOGRAMA DE ENTREGA - BARRIOS - DISCAPACIDAD</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        <div class="form-group row">
            <div class="col-md-12 pr-1 pl-1 text-center font-roboto-16">
                <b>
                    <u>
                        {{ $paquete->numero }} ENTREGA
                        /
                        @php
                            $periodos = DB::table('paquete_periodo as a')
                                            ->join('periodos as b','b.id','a.id_periodo')
                                            ->where('a.id_paquete',$paquete->id)
                                            ->where('a.estado','1')
                                            ->get();
                        @endphp
                        @foreach ($periodos as $periodo)
                            {{ $periodo->mes }}
                        @endforeach
                        ({{ $paquete->gestion }})
                    </u>
                </b>
                <br>
                <b class="font-roboto-12">Registrados =&nbsp;</b> <span class="font-roboto-12">{{ $paquete->registrados }}</span>
                &nbsp;|&nbsp;
                <b class="font-roboto-12">Entregados =&nbsp;</b> <span class="font-roboto-12">{{ $paquete->entregados }}</span>
                &nbsp;|&nbsp;
                <b class="font-roboto-12">No entregados =&nbsp;</b> <span class="font-roboto-12">{{ $paquete->no_entregados }}</span>
                &nbsp;|&nbsp;
                <b class="font-roboto-12">Resagados =&nbsp;</b> <span class="font-roboto-12">{{ $paquete->resagados }}</span>
            </div>
        </div>
        @include('canasta_v2disc.paquetes-barrio.partials.search')
        @include('canasta_v2disc.paquetes-barrio.partials.table')
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#distrito_id').select2({
                theme: "bootstrap4",
                placeholder: "--Distrito--",
                width: '100%'
            });

            $('#barrio_id').select2({
                theme: "bootstrap4",
                placeholder: "--Barrio--",
                width: '100%'
            });

            $('#lugar_entrega').select2({
                theme: "bootstrap4",
                placeholder: "--Lugar de entrega--",
                width: '100%'
            });

            $('#estado').select2({
                theme: "bootstrap4",
                placeholder: "--Estado--",
                width: '100%'
            });

            var cleave = new Cleave('#fecha_inicial', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha_inicial").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });

            var cleave = new Cleave('#fecha_final', {
                date: true,
                datePattern: ['d', 'm', 'Y']
            });

            $("#fecha_final").datepicker({
                inline: false,
                dateFormat: "dd/mm/yyyy",
                autoClose: true,
            });
        });

        $('.intro').on('keypress', function(event) {
            if (event.which === 13) {
                search();
                event.preventDefault();
            }
        });

        function Modal(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        function search() {
            var paquete_id = $("#paquete_id").val();
            var url = "{{ route('paquetes.barrio.search', ':id') }}";
            url = url.replace(':id', paquete_id);
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function pdf() {
            var paquete_barrio_id = $("#paquete_id").val();
            var url = "{{ route('paquetes.barrio.pdf', ':id') }}"+"?"+$('#form').serialize();
            url = url.replace(':id', paquete_barrio_id);
            window.open(url,"_blank")
        }

        function excel() {
            var paquete_id = $("#paquete_id").val();
            var url = "{{ route('paquetes.barrio.excel', ':id') }}";
            url = url.replace(':id', paquete_id);
            $(".btn").hide();
            $(".spinner-btn-send").show();
            var form = $("#form");
            var formData = form.serialize();
            $.ajax({
                url: url,
                type: 'GET',
                data: formData,
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(response);
                    a.href = url;
                    a.download = 'cronograma_barrios.xlsx';
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

        function ir_atras() {
            var url = "{{ route('paquetes.index') }}";
            window.location.href = url;
        }

        function limpiar() {
            var paquete_id = $("#paquete_id").val();
            var url = "{{ route('paquetes.barrio.index', ':id') }}";
            url = url.replace(':id', paquete_id);
            window.location.href = url;
        }

        function create() {
            var paquete_id = $("#paquete_id").val();
            var url = "{{ route('paquetes.barriodisc.create', ':id') }}";
            url = url.replace(':id', paquete_id);
            window.location.href = url;
        }
    </script>
@endsection

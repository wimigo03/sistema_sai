@extends('layouts.admin')
@section('content')
    <div class="card-header header">
        <div class="row">
            <div class="col-md-12 pr-1 pl-1 text-center">
                <b>REGISTRAR BENEFICIARIOS - GESTION {{ $paquete_barrio->paquete->gestion }}</b>
            </div>
        </div>
    </div>
    <div class="card-body body">
        @include('canasta_v2.entregas.partials.create')
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

            $('#tabla_detalle').DataTable({
                dom: '<"row"<"col-md-6"<"btn-group btn-group-left">><"col-md-6"f>>t<"row"<"col-md-6"i><"col-md-6"p>>',
                bFilter: true,
                responsive: true,
                processing: true,
                serverSide: false,
                paging: false,
                autoWidth: false,
                //lengthMenu: [[10,25,50,-1],[10,25,50,'Todos']],
                //pageLength: 10,
                order: [[1, 'asc'], [2, 'asc']],
                language: datatableLanguageConfig,
                        rowCallback: function(row, data, index) {
                    $('td:eq(0)', row).html(index + 1);
                },
                initComplete: function () {
                    $('.btn-group-left').append(`
                        <span class="btn btn-outline-danger font-roboto-12 mr-1" onclick="cancelar();">
                            <i class="fa-solid fa-xmark fa-fw"></i>&nbsp;Cancelar
                        </span>
                        <span class="btn btn-outline-primary font-roboto-12" onclick="procesar();" id="btn-proceso">
                            <i class="fa-solid fa-paper-plane fa-fw" aria-hidden="true"></i>&nbsp;Registrar
                        </span>
                    `);
                },
                columnDefs: [
                    {
                        targets: -1,
                        orderable: false
                    },
                    {
                        targets: -2,
                        orderable: false
                    }
                ]
            });
        });

        $('#toggle-all-checkboxes').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('.checkbox-item').prop('checked', isChecked);
        });

        function registrar(){
            if(!validar_detalle()){
                return false;
            }
            if(duplicado()){
                Modal("El <b>[BARRIO]</b> seleccionado ya existe en el registro");
                return false;
            }
            registrar_detalle();
        }

        function procesar() {
            $('#modal_confirmacion').modal({
                keyboard: false
            })
        }

        function confirmar(){
            var paquete_barrio_id = $("#paquete_barrio_id").val();
            var url = "{{ route('entregas.store', ':id') }}";
            url = url.replace(':id', paquete_barrio_id);
            $("#form").attr('action', url);
            $("#form").submit();
        }

        function Modal(mensaje) {
            $("#modal-alert .modal-body").html(mensaje);
            $('#modal-alert').modal({
                keyboard: false
            });
        }

        function cancelar(){
            var paquete_barrio_id = $("#paquete_barrio_id").val();
            var url = "{{ route('entregas.index', ':id') }}";
            url = url.replace(':id', paquete_barrio_id);
            window.location.href = url;
        }
    </script>
@endsection

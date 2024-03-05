@extends('layouts.admin')

@section('content')
    <div class="row font-verdana-12 mb-3">
        <div class="col-md-12 titulo">
            <span class="tts:right tts-slideIn tts-custom" aria-label="Retroceder">
                <a href="javascript:void(0);" onclick="window.history.back()">
                    <span class="color-icon-1">
                        &nbsp;<i class="fa-solid fa-xl fa-circle-chevron-left"></i>&nbsp;
                    </span>
                </a>
            </span>
            <b>RESPONSABLES</b>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <center>
                <table class="table-bordered yajra-datatable hoverTable" style="width:100%;">
                    <thead class="font-courier">
                        <tr>
                            <td class="text-center p-1 font-weight-bold"><b>N°</b></td>
                            <td class="text-center p-1 font-weight-bold"><b>NOMBRE</b></td>
                            <td class="text-center p-1 font-weight-bold"><b>APELLIDO PATERNO</b></td>
                            <td class="text-center p-1 font-weight-bold"><b>APELLIDO MATERNO</b></td>
                            <td class="text-center p-1 font-weight-bold"><b>CARGO</b></td>
                            <td class="text-center p-1 font-weight-bold"><b>C.I.</b></td>
                            <td class="text-center p-1 font-weight-bold"><b>ESTADO</b></td>
                            <th class="text-center"><i class="fa fa-bars" aria-hidden="true"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </center>
        </div>
    </div>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $('.yajra-datatable').DataTable({

                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ route('activo.responsable.listado', $id) }}",
                columns: [

                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'nombres',
                        name: 'nombres',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'ap_pat',
                        name: 'ap_pat',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'ap_mat',
                        name: 'ap_mat',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'cargo',
                        name: 'cargo',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'ci',
                        name: 'ci',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'estadoemp1',
                        name: 'estadoemp1',
                        class: 'text-justify p-1 font-verdana'
                    },
                    {
                        data: 'btns',
                        name: 'btns',
                        class: 'text-justify p-1 font-verdana'
                    },
                ],

                language: {
                    // Configuración del idioma, si es necesario
                },

            });

        });
    </script>
@endsection
@endsection

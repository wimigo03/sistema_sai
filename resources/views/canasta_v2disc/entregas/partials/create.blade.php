<div class="form-group row">
    <div class="col-md-12 pr-1 pl-1 text-center">
        <b>
            <u>
                {{ $paquete_barrio->distrito->nombre }} - {{ $paquete_barrio->barrio->nombre }}
                /
                {{ $paquete_barrio->paquete->numero}} ENTREGA "{{ $paquete_barrio->periodos }}"
                <br>
            </u>
            ({{ count($beneficiarios) }} HABILITADOS)
        </b>
    </div>
</div>
<form action="#"  method="post" id="form">
    @csrf
    <input type="hidden" name="paquete_barrio_id" value="{{ $paquete_barrio->id }}" id="paquete_barrio_id">
    <div class="form-group row">
        <div class="col-md-12 pr-1 pl-1">
            <table id="tabla_detalle" class="display" style="width:100%;">
                <thead>
                    <tr class="font-roboto-11 bg-warning text-white">
                        <th class="text-justify p-1">N°</th>
                        <th class="text-justify p-1">NOMBRES</th>
                        <th class="text-justify p-1">APELLIDO PATERNO</th>
                        <th class="text-justify p-1">APELLIDO MATERNO</th>
                        <th class="text-justify p-1">N°CARNET</th>
                        <th class="text-center p-1">FECHA NAC.</th>
                        <th class="text-center p-1">EDAD.</th>
                        <th class="text-center p-1">SEXO</th>
                        <th class="text-center p-1">FOTO</th>
                        <th class="text-center p-1">
                            <input type="checkbox" id="toggle-all-checkboxes">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($beneficiarios as $datos)
                        <tr class="font-roboto-11">
                            <td class="text-justify p-1" style="vertical-align: middle;"></td>
                            <td class="text-justify p-1" style="vertical-align: middle;">{{ $datos->nombres }}</td>
                            <td class="text-justify p-1" style="vertical-align: middle;">{{ $datos->ap }}</td>
                            <td class="text-justify p-1" style="vertical-align: middle;">{{ $datos->am }}</td>
                            <td class="text-justify p-1" style="vertical-align: middle;">{{ $datos->ci . ' ' . $datos->expedido }}</td>
                            <td class="text-center p-1" style="vertical-align: middle;">{{ $datos->fecha_nac != null ? \Carbon\Carbon::parse($datos->fecha_nac)->format('d/m/Y') : '' }}</td>
                            <td class="text-center p-1" style="vertical-align: middle;">{{ $datos->fecha_nac != null ? \Carbon\Carbon::parse($datos->fecha_nac)->age : '' }}</td>
                            <td class="text-center p-1" style="vertical-align: middle;">{{ $datos->sexo }}</td>
                            <td class="text-center p-1" style="vertical-align: middle;">
                                <img src="{{ asset(substr($datos->dir_foto, 3)) }}" class="imagen-beneficiario-table"/>
                            </td>
                            <td class="text-center p-1" style="vertical-align: middle;">
                                <input type="checkbox" name="beneficiario_id[]" value="{{ $datos->id }}" class="checkbox-item">
                                <input type="hidden" name="ocupacion_id[]" value="{{ $datos->id_ocupacion }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</form>

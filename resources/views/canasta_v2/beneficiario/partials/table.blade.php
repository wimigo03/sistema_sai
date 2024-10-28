<div class="row font-roboto-12">
    <div class="col-md-12 pr-1 pl-1 table-responsive">
        <table class="table display table-striped table-bordered responsive hover-orange" style="width:100%;" id="dataTable">
            <thead>
                <tr class="font-roboto-11">
                    <th></th>
                    <th>DTTO.</th>
                    <th width="20%">BARRIO</th>
                    <th>BENEFICIARIO</th>
                    <th>CARNET-EXP</th>
                    <th>H/M</th>
                    <th>EDAD</th>
                    <th>INSCRIPCION</th>
                    <th>OCUPACION</th>
                    <th width="7%">ESTADO</th>
                    <th>USUARIO</th>
                    <th width="7%"><b>CENSO&nbsp;2024</b></th>
                    <th><i class="fa-solid fa-location-dot fa-lg"></i></th>
                    <th><i class="fa-solid fa-camera-retro fa-lg"></i></th>
                    @canany(['canasta.beneficiarios.editar', 'canasta.beneficiarios.show'])
                        <th>
                            <i class="fa fa-bars fa-lg" aria-hidden="true"></i>
                        </th>
                    @endcanany
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>DTTO.</th>
                    <th>BARRIO</th>
                    <th>BENEFICIARIO</th>
                    <th>CARNET</th>
                    <th>SEXO</th>
                    <th>EDAD</th>
                    <th>INSCRIPCION</th>
                    <th>OCUPACION</th>
                    <th>ESTADO</th>
                    <th>USUARIO</th>
                    <th>CENSO2024</th>
                    <th></th>
                    <th></th>
                    @canany(['canasta.beneficiarios.editar', 'canasta.beneficiarios.show'])
                        <th></th>
                    @endcanany
                </tr>
            </tfoot>
        </table>
    </div>
</div>

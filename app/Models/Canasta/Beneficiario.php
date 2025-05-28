<?php

namespace App\Models\Canasta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Canasta\Dea;
use App\Models\Canasta\Distrito;
use App\Models\Canasta\Barrio;
use App\Models\Canasta\Ocupaciones;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Beneficiario extends Model
{
    protected $table = 'beneficiarios';
    const CREATED_AT = 'created_att';
    const UPDATED_AT = 'updated_att';
    protected $fillable = [
        'nombres',
        'ap',
        'am',
        'fecha_nac',
        'estado_civil',
        'sexo',
        'direccion',
        'dir_foto',
        'firma',
        'obs',
        'estado',
        'created_att',
        'updated_att',
        'id_barrio',
        'user_id',
        'dea_id',
        'ci',
        'expedido',
        'id_ocupacion',
        'distrito_id',
        'photo',
        'id_tipo',
        'codigo',
        'id_discgrado',
        'tutor',
        'parentesco',
        'celular',
        'latitud',
        'longitud',
        'utmx',
        'utmy',
        'profesion_id',
        'seguro_medico',
        'detalle_vivienda',
        'tipo_vivienda',
        'vecino_1',
        'vecino_2',
        'vecino_3',
        'file_ci_anverso',
        'file_ci_reverso',
        'censado',
        'titular_seguro_medico',
        'material_vivienda',
        'informacion',
        'user_censo_id',
        'fecha_censo',
        'ci_pareja',
        'categoria',
        'estado_salud'
    ];

    const HABILITADO = 'A';
    const FALLECIDO = 'F';
    const BAJA = 'B';
    const PENDIENTE = 'X';
    const ELIMINADO = 'E';
    const OBSERVADO = 'O';

    const TITULAR_SEGURO_MEDICO = [
        '1' => 'NO ES TITULAR DEL SEGURO MEDICO',
        '2' => 'SI ES TITULAR DEL SEGURO MEDICO'
    ];

    const INFORMACION = [
        '1' => 'BENEFICIARIO CENSADO',
        '2' => 'EL BENEFICIARIO SE NEGO A DAR INFORMACION'
    ];

    const ESTADOS = [
        'A' => 'HABILITADO',
        'F' => 'FALLECIDO',
        'B' => 'BAJA',
        'X' => 'PENDIENTE',
        'E' => 'ELIMINADO',
        'O' => 'OBSERVADO'
    ];

    const ESTADOS_SALUD = [
        'DIABETES' => 'DIABETES',
        'PRESION ALTA' => 'PRESION ALTA',
        'HIPERTENSION' => 'HIPERTENSION',
        'ARTRITIS' => 'ARTRITIS',
        'ARTROSIS' => 'ARTROSIS',
        'CHAGAS' => 'CHAGAS',
        'CANCER' => 'CANCER',
        'INSUFICIENCIA RENAL' => 'INSUFICIENCIA RENAL',
        'PROBLEMAS DE CORAZON' => 'PROBLEMAS DE CORAZON',
        'CON MARCAPASO' => 'CON MARCAPASO',
        'PROBLEMAS DE RODILLAS' => 'PROBLEMAS DE RODILLAS',
        'GASTRITIS' => 'GASTRITIS',
        'ING. PERDIDA DE AUDICIÓN' => 'ING. PERDIDA DE AUDICIÓN',
        'PERDIDA DE VISIÓN' => 'PERDIDA DE VISIÓN',
        'SORDERA' => 'SORDERA',
        'CEGUERA' => 'CEGUERA',
        'PERSONA CON DISCAPACIDAD' => 'PERSONA CON DISCAPACIDAD',
        'HERNIA' => 'HERNIA',
        'PRÓSTATA' => 'PRÓSTATA',
        'FRACTURA' => 'FRACTURA',
        'ÚLCERAS' => 'ÚLCERAS',
        'VARICES' => 'VARICES',
        'NERVIOS' => 'NERVIOS',
        'REUMATISMO' => 'REUMATISMO',
        'ASMA' => 'ASMA',
        'PROBLEMAS DE COLUMNA' => 'PROBLEMAS DE COLUMNA',
        'CANSANCIO POR VEJEZ' => 'CANSANCIO POR VEJEZ',
        'ACV' => 'ACV',
        'DESGARRE CONGÉNITO' => 'DESGARRE CONGÉNITO',
        'ARRITMIA CARDÍACA' => 'ARRITMIA CARDÍACA',
        'BESICULA' => 'BESICULA',
        'EMBOLIA' => 'EMBOLIA',
        'PARÁLISIS' => 'PARÁLISIS',
        'PULMONÍA' => 'PULMONÍA',
        'TUMOR' => 'TUMOR',
        'SIATICA' => 'SIATICA',
        'PARAPLEJICO' => 'PARAPLEJICO',
        'NINGUNO' => 'NINGUNO'
    ];

    const NO_CENSADO = '1';
    const CENSADO = '2';

    const ESTADOS_CENSO = [
        '1' => 'PENDIENTE',
        '2' => 'CENSADO'
    ];

    const _SEGUROS = [
        '1' => 'CAJA NACIONAL DE SALUD',
        '2' => 'CAJA BANCA ESTATAL',
        '3' => 'CAJA CORDES',
        '4' => 'COORPORACION DEL SEGURO SOCIAL MILITAR',
        '5' => 'CAJA DE LA BANCA PRIVADA',
        '6' => 'CAJA PETROLERA',
        '7' => 'CAJA DE CAMINOS',
        '8' => 'SUS',
    ];

    const TIPOS_VIVIENDAS = [
        '1' => 'PROPIA',
        '2' => 'ALQUILER',
        '3' => 'ANTICRETICO',
        '4' => 'OTRO'
    ];

    const MATERIALES_VIVIENDAS = [
        '1' => 'MADERA',
        '2' => 'LADRILLO',
        '3' => 'ADOBE',
        '4' => 'CEMENTO',
        '5' => 'OTRO'
    ];

    const SEXOS = [
        'H' => 'H',
        'M' => 'M',
    ];

    const TERCERA_EDAD = 1;
    const DISCAPACIDAD = 2;

    const TIPOS = [
        '1' => '3RA EDAD',
        '2' => 'DISCAPACIDAD'
    ];

    const EXTENSIONES = [
        'TJA' => 'TARIJA',
        'SCZ' => 'SANTA CRUZ',
        'BN' => 'BENI',
        'LPZ' => 'LA PAZ',
        'CBBA' => 'COCHABAMBA',
        'SC' => 'CHUQUISACA',
        'ORU' => 'ORURO',
        'PTS' => 'POTOSI',
        'PND' => 'PANDO',
    ];

    public function getStatusAttribute(){
        switch ($this->estado) {
            case 'A':
                return "HABILITADO";
            case 'F':
                return "FALLECIDO";
            case 'B':
                    return "BAJA";
            case 'X':
                    return "PENDIENTE";
            case 'E':
                return "ELIMINADO";
            case 'O':
                return "OBSERVADO";
        }
    }

    public function getSegurosMedicosAttribute(){
        switch ($this->seguro_medico) {
            case '1':
                return "CAJA NACIONAL DE SALUD";
            case '2':
                return "CAJA BANCA ESTATAL";
            case '3':
                    return "CAJA CORDES";
            case '4':
                    return "COORPORACION DEL SEGURO SOCIAL MILITAR";
            case '5':
                return "CAJA DE LA BANCA PRIVADA";
            case '6':
                return "CAJA PETROLERA";
            case '7':
                return "CAJA DE CAMINOS";
            case '8':
                return "SUS";
        }
    }

    public function getTitularSeguroAttribute(){
        switch ($this->titular_seguro_medico) {
            case '1':
                return "NO";
            case '2':
                return "SI";
        }
    }

    public function getcolorStatusAttribute(){
        switch ($this->estado) {
            case 'A':
                return "badge-with-padding badge badge-success";
            case 'F':
                return "badge-with-padding badge badge-danger";
            case 'B':
                return "badge-with-padding badge badge-warning";
            case 'X':
                return "badge-with-padding badge badge-secondary";
            case 'E':
                return "badge-with-padding badge badge-danger";
            case 'O':
                return "badge-with-padding badge badge-danger";
        }
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function user_censo(){
        return $this->belongsTo(User::class,'user_censo_id','id');
    }

    public function profesion(){
        return $this->belongsTo(Ocupaciones::class,'profesion_id','id');
    }

    public function ocupacion(){
        return $this->belongsTo(Ocupaciones::class,'id_ocupacion','id');
    }

    public function distrito(){
        return $this->belongsTo(Distrito::class,'distrito_id','id');
    }

    public function barrio(){
        return $this->belongsTo(Barrio::class,'id_barrio','id');
    }

    public function dea(){
        return $this->belongsTo(Dea::class,'dea_id','id');
    }

    public function scopeByCodigo($query, $codigo){
        if($codigo){
            return $query->where('id', $codigo);
        }
    }

    public function scopeByDistrito($query, $distrito){
        if($distrito != null){
            return $query->where('distrito_id', $distrito);
        }
    }

    public function scopeByBarrio($query, $barrio){
        if($barrio != null){
            return $query->where('id_barrio', $barrio);
        }
    }

    public function scopeByNombreCompleto($query, $nombre_completo){
        if($nombre_completo != null){
            //return $query->whereRaw('upper(nombres) like ?', ['%'.strtoupper($nombre_completo).'%']);
            return $query->whereRaw(
                "UPPER(CONCAT(nombres, ' ', ap, ' ', am)) LIKE ?",
                ['%' . strtoupper($nombre_completo) . '%']
            );
        }
    }

    public function scopeByNombre($query, $nombre){
        if($nombre != null){
            return $query->whereRaw('upper(nombres) like ?', ['%'.strtoupper($nombre).'%']);

        }
    }

    public function scopeByApellidoPaterno($query, $ap){
        if($ap != null){
            return $query->whereRaw('upper(ap) like ?', ['%'.strtoupper($ap).'%']);

        }
    }

    public function scopeByApellidoMaterno($query, $am){
        if($am != null){
            return $query->whereRaw('upper(am) like ?', ['%'.strtoupper($am).'%']);

        }
    }

    public function scopeByNumeroCarnet($query, $ci){
        if($ci != null){
            return $query->whereRaw('upper(ci) like ?', ['%'.strtoupper($ci).'%']);

        }
    }

    public function scopeByNumeroCarnetBrigadista($query, $ci){
        if($ci != null){
            return $query->where('ci',$ci);

        }
    }

    public function scopeBySexo($query, $sexo){
        if($sexo != null){
            return $query->where('sexo',$sexo);

        }
    }

    public function scopeByEdad($query, $edad_inicial, $edad_final){
        if ($edad_inicial != null && $edad_final != null) {
            $fecha_actual = Carbon::now();
            $fecha_nacimiento_final = $fecha_actual->copy()->subYears($edad_final + 1)->startOfDay();
            $fecha_nacimiento_inicial = $fecha_actual->copy()->subYears($edad_inicial)->addDay()->startOfDay();
            return $query->whereBetween('fecha_nac', [$fecha_nacimiento_final, $fecha_nacimiento_inicial]);
        }
    }

    public function scopeByInscripcion($query, $finicial, $ffinal){
        if(!is_null($finicial) && !is_null($ffinal)){
            $finicial = Carbon::createFromFormat('d/m/Y', $finicial)->format('Y-m-d 00:00:00');
            $ffinal = Carbon::createFromFormat('d/m/Y', $ffinal)->format('Y-m-d 23:59:59');
            return $query->whereBetween('created_att',[$finicial,$ffinal]);
        }
    }

    /* public function scopeByEntreFechas($query, $finicial, $ffinal)
    {
        if (!is_null($finicial) && !is_null($ffinal)) {
            $finicial = Carbon::createFromFormat('d/m/Y', $finicial)->startOfDay()->format('Y-m-d H:i:s');
            $ffinal = Carbon::createFromFormat('d/m/Y', $ffinal)->endOfDay()->format('Y-m-d H:i:s');

            return $query->leftJoin(DB::raw("(
                    SELECT id_beneficiario, observacion, fecha
                    FROM historialmod
                    WHERE (id_beneficiario, fecha) IN (
                        SELECT id_beneficiario, MAX(fecha)
                        FROM historialmod
                        GROUP BY id_beneficiario
                    )
                ) as b"), 'beneficiarios.id', 'b.id_beneficiario')
                ->whereBetween('b.fecha', [$finicial, $ffinal]);
        }

        return $query;
    } */

    public function scopeByEntreFechas($query, $finicial, $ffinal)
    {
        if (!is_null($finicial) && !is_null($ffinal)) {
            $finicial = Carbon::createFromFormat('d/m/Y', $finicial)->startOfDay()->format('Y-m-d H:i:s');
            $ffinal = Carbon::createFromFormat('d/m/Y', $ffinal)->endOfDay()->format('Y-m-d H:i:s');

            return $query->leftJoin(DB::raw("(
                        SELECT id_beneficiario, observacion, fecha
                        FROM historialmod
                        WHERE (id_beneficiario, fecha) IN (
                            SELECT id_beneficiario, MAX(fecha)
                            FROM historialmod
                            GROUP BY id_beneficiario
                        )
                    ) as b"), 'beneficiarios.id', '=', 'b.id_beneficiario')
                    /* ->where('b.id_beneficiario',NULL) */
                    ->where(function ($query) use ($finicial, $ffinal) {
                        $query->whereBetween('b.fecha', [$finicial, $ffinal])
                              ->orWhereNull('b.fecha');
                    });
        }

        return $query;
    }

    public function scopeByOcupacion($query, $ocupacion_id){
        if($ocupacion_id != null){
            return $query->where('id_ocupacion', $ocupacion_id);
        }
    }

    public function scopeByUsuario($query, $usuario){
        if ($usuario != null) {
                return $query
                    ->whereIn('user_id', function ($subquery) use($usuario) {
                        $subquery->select('id')
                            ->from('users')
                            ->whereRaw('upper(name) like ?', [strtoupper($usuario)]);
                    });
        }
    }

    public function scopeByDea($query, $dea_id){
        if($dea_id != null){
            return $query->where('beneficiarios.dea_id',$dea_id);
        }
    }

    public function scopeByTipoSistema($query, $tipo){
        if($tipo != null){
            return $query->where('id_tipo',$tipo);
        }
    }

    public function scopeByEstado($query, $estado){
        if($estado != null){
            return $query->where('beneficiarios.estado',$estado);
        }
    }

    public function scopeByUsuarioTwo($query, $user_id){
        if($user_id != null){
            return $query->where('user_censo_id', $user_id);
        }
    }

    public function scopeByEstadoBrigadista($query, $estados){
        if($estados != null){
            return $query->whereIn('estado',$estados);
        }
    }

    public function scopeByEstadoCenso($query, $estado_censo){
        if($estado_censo != null){
            return $query->where('censado',$estado_censo);
        }
    }

    public function age()
    {
        return Carbon::parse($this->attributes['fecha_nac'])->age;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCompraModel extends Model
{
    protected $table = 'ordencompra';

    protected $primaryKey= 'idorden';

    public $timestamps = false;

    protected $fillable = [
      'numinforme',
      'fechaorden',
      'nombrecompra',
      'solicitante',
      'modalidadcontratacion',
      'precioreferencial',
      'proveedor',
      'representante',
      'cedula',
      'nitci',
      'telefono',
      'approgramatica',
      'partida',
      'actividad',
      'nordencompra',
      'npreventivo',
      'hojaruta',
      'numcontrolinterno',
      'plazoentrega',
      'fechainicio',
      'fechaconclusion',
      'fechainvitacion',
      'fechaaceptacion',
      'codciteinvitacion',
      'horapresentacion',
      'cedulaaceptacion',
      'numnotaadjudicacion',
      'fechainiciosolproc',
      'controlinter',
      'autoridadsolicitante',
      'memorandum1',
      'memorandum2',
      'comision1',
      'comision2',
      'informe1',
      'informe2'
    ];

    protected $guarded = [

    ];

}

<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissions = [
              //COMBUSTIBLE
              //23
             ['name' => 'combustiblescomb_panel_access','estado'=>'1',],
             ['name' => 'combustiblescomb_panel_solicitud','estado'=>'1',],
             ['name' => 'pedidoparcialcomb.index','estado'=>'1',],
             ['name' => 'pedidoparcialcomb.create','estado'=>'1',],
             ['name' => 'pedidoparcialcomb.editaruno','estado'=>'1',],
             ['name' => 'pedidoparcialcomb.edit','estado'=>'1',],
             ['name' => 'pedidoparcialcomb.editar','estado'=>'1',],
             ['name' => 'pedidoparcialcomb.ver','estado'=>'1',],
             ['name' => 'pedidoparcialcomb.editable','estado'=>'1',],
             ['name' => 'pedidoparcialcomb.vercinco','estado'=>'1',],
             ['name' => 'pedidoparcialcomb.editalma','estado'=>'1',],
             ['name' => 'pedidoparcialcomb.verdiez','estado'=>'1',],
             ['name' => 'pedidoparcialcomb.editrecha','estado'=>'1',],
//36
             ['name' => 'pedidocomb.index','estado'=>'1',],
             ['name' => 'pedidocomb.edit','estado'=>'1',],
             ['name' => 'pedidocomb.editabledos','estado'=>'1',],
             ['name' => 'pedidocomb.editabletres','estado'=>'1',],
             ['name' => 'pedidocomb.ver','estado'=>'1',],

             ['name' => 'pedidocomb.index2','estado'=>'1',],
             ['name' => 'pedidocomb.verr','estado'=>'1',],

             ['name' => 'combustiblescomb_panel_producto','estado'=>'1',],
             ['name' => 'producto.index','estado'=>'1',],
             ['name' => 'producto.create','estado'=>'1',],
             ['name' => 'producto.edit','estado'=>'1',],

//47
             ['name' => 'partidacomb.index','estado'=>'1',],
             ['name' => 'partidacomb.create','estado'=>'1',],
             ['name' => 'partidacomb.edit','estado'=>'1',],

             ['name' => 'medidacomb.index','estado'=>'1',],
             ['name' => 'medidacomb.create','estado'=>'1',],
             ['name' => 'medidacomb.edit','estado'=>'1',],

             ['name' => 'combustiblescomb_panel_proveedores','estado'=>'1',],	 
             ['name' => 'proveedor.index','estado'=>'1',],
             ['name' => 'proveedor.create','estado'=>'1',],
             ['name' => 'proveedor.edit','estado'=>'1',],
             ['name' => 'proveedor.editardoc','estado'=>'1',],
             ['name' => 'proveedor.createdoc','estado'=>'1',],
             ['name' => 'proveedor.verdoc','estado'=>'1',],
             ['name' => 'proveedor.editararchivo','estado'=>'1',],
//61
             ['name' => 'combustiblescomb_panel_programas','estado'=>'1',],
             ['name' => 'programa.index','estado'=>'1',],	
             ['name' => 'programa.create','estado'=>'1',],	
             ['name' => 'programa.edit','estado'=>'1',],	

             ['name' => 'combustiblescomb_panel_programatica','estado'=>'1',],	
             ['name' => 'catprogcomb.index','estado'=>'1',],	
             ['name' => 'catprogcomb.create','estado'=>'1',],
             ['name' => 'catprogcomb.edit','estado'=>'1',],
             
             
             // ALMACEN
             //69
            ['name' => 'almacencomb_panel_access','estado'=>'1',],
            ['name' => 'almacencomb_panel_comprobante','estado'=>'1',],
            ['name' => 'ingreso.index','estado'=>'1',],

            ['name' => 'comingreso.index','estado'=>'1',],
            ['name' => 'comegreso.index2','estado'=>'1',],
            ['name' => 'tipocomingreso.index','estado'=>'1',],
            
            ['name' => 'almacencomb_panel_reporte','estado'=>'1',],	 
            ['name' => 'reporte.index','estado'=>'1',],
            ['name' => 'reporte.index2','estado'=>'1',],

            
            ['name' => 'almacencomb_panel_vale','estado'=>'1',],
            ['name' => 'apedido.index','estado'=>'1',],	
         
            ['name' => 'almacencomb_panel_localidad','estado'=>'1',],	
            ['name' => 'localidad.index','estado'=>'1',],	
//82
            ['name' => 'almacencomb_panel_grafico','estado'=>'1',],
            ['name' => 'ingreso.grafico','estado'=>'1',],


        //   TRANSPORTE
//84
            ['name' => 'transportecomb_panel_access','estado'=>'1',],
            ['name' => 'transportecomb_panel_solicitudes','estado'=>'1',],
            ['name' => 'upedidoparcial.index','estado'=>'1',],

            ['name' => 'upedido.index3','estado'=>'1',],
            ['name' => 'upedido.index','estado'=>'1',],

            ['name' => 'transportecomb_panel_vehiculo','estado'=>'1',],	 
            ['name' => 'uconsumo.index','estado'=>'1',],
            ['name' => 'tipo.index','estado'=>'1',],
            ['name' => 'marca.index','estado'=>'1',],
//92
        ];

        foreach($permissions as $permission){
            Permission::create($permission);
        }

    }
}

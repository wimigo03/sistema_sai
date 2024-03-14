<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Role::create([
             'title' => 'Unidad_administrativa_combustible',
             'short_code' => 'Uadmincombustible',
             'estado' => '1',
             'dea_id' => '1'
         ]);

          Role::create([
              'title' => 'Unidad_administrativa_almacen',
              'short_code' => 'Uadminalmacen',
              'estado' => '1',
              'dea_id' => '1'
          ]);

          Role::create([
             'title' => 'Unidad_administrativa_transporte',
             'short_code' => 'Uadmintransporte',
             'estado' => '1',
             'dea_id' => '1'
         ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RegistroAsistenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Models\RegistroAsistencia::factory(10)->create();
    }
}

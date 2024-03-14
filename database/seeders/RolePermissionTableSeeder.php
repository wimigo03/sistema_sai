<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          //$admin_permissions = Permission::all();
          //Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));

         Role::findOrFail(3)->permissions()->sync([23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68]);
         Role::findOrFail(4)->permissions()->sync([69,70,71,72,73,74,75,76,77,78,79,80,81,82,83]);
         Role::findOrFail(5)->permissions()->sync([84,85,86,87,8,89,90,91,92]);

        
        
         //  Role::findOrFail(107)->roleusers()->sync([1,2,97,98,99,100,101,102,103,104,105,106,107,108]);
         //Role::findOrFail(107)->roleusers()->sync([30]);

    }
}

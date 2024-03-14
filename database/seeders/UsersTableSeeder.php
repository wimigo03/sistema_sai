<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'jhona',
            'email' => 'jhon@gmail.com',
            'password' => bcrypt('12345678'),
            'idemp' => '1415',
            'estadouser' => '1',
            'dea_id' => '1'
        ]);

        // User::create([
        //     'name' => 'User',
        //     'email' => 'user@user.com',
        //     'password' => bcrypt('secret'),
        //     'role_id' => '2'
        // ]);
    }
}

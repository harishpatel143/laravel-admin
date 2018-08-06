<?php

use Illuminate\Database\Seeder;

class AdministratorsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'super admin',
            'description' => 'super admin',
            'status' => '1',
        ]);
        DB::table('administrators')->insert([
            'role_id' => '1',
            'first_name' => 'admin',
            'last_name' => 'admin',
            'username' => 'admin',
            'email' => 'demo@gmail.com',
            'password' => bcrypt('thinker99'),
        ]);
    }

}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Budi X',
                'email' => 'budi.x@test.com',
                'password' => bcrypt('password'),
                'picture' => env('AVATAR_GENERATOR_URL') . 'Budi X',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Dadang Z',
                'email' => 'dadang.z@test.com',
                'password' => bcrypt('password'),
                'picture' => env('AVATAR_GENERATOR_URL') . 'Dadang Z',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]); 
    }
}

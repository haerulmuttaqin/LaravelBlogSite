<?php

namespace Database\Seeders;

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
        \App\Models\User::create([
            'name' => 'Haerul Muttaqin',
            'username' => 'haerul',
            'password' => bcrypt('password'),
            'email' => 'haerulmuttaqin@gmail.com'
        ]);
    }
}
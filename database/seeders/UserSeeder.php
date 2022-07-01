<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'Miguel',
            'email'=>'mortmr9@gmail.com',
            'password'=>bcrypt('12345678')
        ])->assignRole('Administrador');

        User::create([
            'name'=>'Jose Ignacio Ruiz Garcia',
            'email'=>'ruizgarciajoseignacio7@gmail.com',
            'password'=>bcrypt('RGconstrucciones')
        ])->assignRole('Administrador');

        //User::factory(20)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cliente::create([
            'businessname' => 'Publico en General',
            'email' => 'mortmr9@gmail.com',
            'typePerson' => '601',
            'rfc' => 'XAXX010101000',
            'cp' => '24085'
        ]);
    }
}

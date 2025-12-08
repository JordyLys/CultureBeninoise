<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Langue;

class LangueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Langue::create(['nom' => 'Fon', 'codeLangue' => 'fon', 'description' => 'Langue majoritaire du sud du Bénin']);
        Langue::create( ['nom' => 'Yoruba', 'codeLangue' => 'yor', 'description' => 'Langue parlée dans le sud-ouest du Bénin']);
        Langue::create(['nom' => 'Bariba', 'codeLangue' => 'bba', 'description' => 'Langue parlée dans le nord-est du Bénin']);
        Langue::create(['nom' => 'Dendi', 'codeLangue' => 'dnd', 'description' => 'Langue parlée dans le nord du Bénin']);
        Langue::create( ['nom' => 'Goun', 'codeLangue' => 'gon', 'description' => 'Langue parlée dans le sud-ouest du Bénin']);
        Langue::create(['nom' => 'Français', 'codeLangue' => 'fr', 'description' => 'Langue officielle du Bénin']);


    }
}

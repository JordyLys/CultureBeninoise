<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Region;


class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Region::create(['nom' => 'Atlantique', 'description' => 'Région côtière du sud du Bénin', 'population' => 1122296, 'superficie' => 6600, 'localisation' => 'Sud']);
        Region::create(['nom' => 'Ouémé', 'description' => 'Région du sud-est du Bénin', 'population' => 1187780, 'superficie' => 3307, 'localisation' => 'Sud-Est']);
        Region::create(['nom' => 'Collines', 'description' => 'Région centrale du Bénin', 'population' => 732921, 'superficie' => 13963, 'localisation' => 'Centre']);
        Region::create(['nom' => 'Borgou', 'description' => 'Région du nord-est du Bénin', 'population' => 1281206, 'superficie' => 25000, 'localisation' => 'Nord-Est']);
        Region::create(['nom' => 'Atacora', 'description' => 'Région du nord-ouest du Bénin', 'population' => 676824, 'superficie' => 20300, 'localisation' => 'Nord-Ouest']);
    }
}

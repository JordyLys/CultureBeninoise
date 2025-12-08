<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeContenu;

class TypeContenuSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Histoire',
            'Conte',
            'Recette',
            'Rituel',
            'Musique traditionnelle',
            'Danse',
            'Personnalité historique',
            'Artisanat',
            'Mythe',
            'Fête traditionnelle'
        ];

        foreach ($types as $t) TypeContenu::create(['nom' => $t]);
    }
}

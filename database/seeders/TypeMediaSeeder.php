<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeMedia;

class TypeMediaSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Image',
            'Vidéo',
            'Audio',
            'Document',
            'Illustration'
        ];

        foreach ($types as $t) TypeMedia::create(['nom' => $t]);
    }
}

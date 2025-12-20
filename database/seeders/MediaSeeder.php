<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Media;

class MediaSeeder extends Seeder
{
    public function run(): void
    {
        $medias = [
            ['idContenu' => 1, 'fichier' => 'danxome.jpg', 'type' => 1],
            ['idContenu' => 2, 'fichier' => 'te_agbanlin_conte.mp4', 'type' => 2],
            ['idContenu' => 3, 'fichier' => 'sakpata.jpg', 'type' => 1],
            ['idContenu' => 4, 'fichier' => 'wassa_wassa.mp4', 'type' => 2],
            ['idContenu' => 5, 'fichier' => 'fete_gaani.mp4', 'type' => 2],
            ['idContenu' => 6, 'fichier' => 'tam tam.jpg', 'type' => 1],
            ['idContenu' => 7, 'fichier' => 'rituel.jpg', 'type' => 1],
            ['idContenu' => 8, 'fichier' => 'roi.jpg', 'type' => 1],
            ['idContenu' => 9, 'fichier' => 'zangbéto.jpg', 'type' => 1],
            ['idContenu' => 10, 'fichier' => 'amiwo.jpg', 'type' => 1],
            ['idContenu' => 11, 'fichier' => 'agodjie.mp4', 'type' => 2],
            ['idContenu' => 12, 'fichier' => 'foret.jpg', 'type' => 1],
            ['idContenu' => 13, 'fichier' => 'yogbo.jpeg', 'type' => 1],
            ['idContenu' => 14, 'fichier' => 'sauceMan.jpg', 'type' => 1],
            ['idContenu' => 15, 'fichier' => 'kouvito.jpg', 'type' => 1],
        ];

        foreach ($medias as $media) {
            Media::create([
                'chemin' => 'adminlte/img/' . $media['fichier'],
                'description' => 'Media associé au contenu ' . $media['idContenu'],
                'idTypeMedia' => $media['type'],
                'idContenu' => $media['idContenu'],
            ]);
        }
    }
}

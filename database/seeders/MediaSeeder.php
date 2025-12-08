<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Media;
use App\Models\Contenu;

class MediaSeeder extends Seeder
{
    public function run(): void
    {
        // Définir les médias à assigner spécifiquement
        $mediasSpecifiques = [
            1  => 'danxome.jpg',
            2  => 'agbanlin.jpg',
            6  => 'sakpata.jpg',
            12 => 'zangbeto.jpg',
            13 => 'amiwo.jpg',
        ];

        // Autres images restantes pour compléter les 15 médias
        $autresImages = [
            'chevaux.jpg',
            'ouidah.jpg',
            'bio_guera.jpg',
            'porto.jpg',
            'kouvitoo.jpg',
            'atassii.jpg',
            'agodjie.jpg',
            'nonRetour.jpg',
            'mur.jpg',
            'sauceMan.jpg',
            'kouvito.jpg',
        ];

        // Récupère tous les contenus existants
        $contenus = Contenu::all();

        $compteur = 0;

        foreach ($contenus as $contenu) {

            // Si ce contenu a un média spécifique, on l'assigne
            if (isset($mediasSpecifiques[$contenu->id])) {
                Media::create([
                    'chemin' => 'adminlte/img/' . $mediasSpecifiques[$contenu->id],
                    'description' => 'Media associé au contenu ' . $contenu->id,
                    'idTypeMedia' => 1,
                    'idContenu' => $contenu->id,
                ]);
                $compteur++;
            }
            // Sinon on prend la prochaine image disponible dans la liste
            elseif (!empty($autresImages) && $compteur < 15) {
                $image = array_shift($autresImages);
                Media::create([
                    'chemin' => 'adminlte/img/' . $image,
                    'description' => 'Media associé au contenu ' . $contenu->id,
                    'idTypeMedia' => 1,
                    'idContenu' => $contenu->id,
                ]);
                $compteur++;
            }

            if ($compteur >= 15) break; // Limite à 15 médias
        }
    }
}

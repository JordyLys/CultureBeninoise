<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contenu;
use Carbon\Carbon;

class ContenuSeeder extends Seeder
{
    public function run(): void
    {
        // Auteurs (role 1 uniquement)
        $auteurs = [2, 3, 5, 6];

        // Modérateurs (role 3 uniquement)
        $moderateurs = [4];

        // Types de contenu disponibles
        $typesContenu = [
            1 => 'Histoire',
            2 => 'Conte',
            3 => 'Recette',
            4 => 'Rituel'
        ];

        $contenus = [
            [
                'titre' => 'Origine du Danxomɛ',
                'texte' => fake()->paragraph(40),
                'idRegion' => 1, 'idLangue' => 1, 'idTypeContenu' => 1,
            ],
            [
                'titre' => 'La légende de Tê Agbanlin',
                'texte' => fake()->paragraph(35),
                'idRegion' => 2, 'idLangue' => 1, 'idTypeContenu' => 2,
            ],
            [
                'titre' => 'Rituel Vodun Sakpata',
                'texte' => fake()->paragraph(50),
                'idRegion' => 1, 'idLangue' => 6, 'idTypeContenu' => 4,
            ],
            [
                'titre' => 'Recette traditionnelle du Wassa-Wassa',
                'texte' => fake()->paragraph(30),
                'idRegion' => 4, 'idLangue' => 3, 'idTypeContenu' => 3,
            ],
            [
                'titre' => 'La fête du Gaani chez les Bariba',
                'texte' => fake()->paragraph(32),
                'idRegion' => 4, 'idLangue' => 3, 'idTypeContenu' => 1,
            ],
            [
                'titre' => 'Conte Yoruba : Ajantè et le tam-tam magique',
                'texte' => fake()->paragraph(28),
                'idRegion' => 1, 'idLangue' => 2, 'idTypeContenu' => 2,
            ],
            [
                'titre' => 'Les rituels du Nouvel An au Bénin',
                'texte' => fake()->paragraph(45),
                'idRegion' => 2, 'idLangue' => 6, 'idTypeContenu' => 4,
            ],
            [
                'titre' => 'Histoire du roi Guézo',
                'texte' => fake()->paragraph(34),
                'idRegion' => 1, 'idLangue' => 1, 'idTypeContenu' => 1,
            ],
            [
                'titre' => 'La danse Zangbéto',
                'texte' => fake()->paragraph(42),
                'idRegion' => 1, 'idLangue' => 1, 'idTypeContenu' => 4,
            ],
            [
                'titre' => 'Recette du Amiwô',
                'texte' => fake()->paragraph(25),
                'idRegion' => 2, 'idLangue' => 6, 'idTypeContenu' => 3,
            ],
            [
                'titre' => 'La reine Tassi Hangbé',
                'texte' => fake()->paragraph(33),
                'idRegion' => 1, 'idLangue' => 1, 'idTypeContenu' => 1,
            ],
            [
                'titre' => 'Forêt de Kpassa : mythes et protections',
                'texte' => fake()->paragraph(38),
                'idRegion' => 4, 'idLangue' => 3, 'idTypeContenu' => 4,
            ],
            [
                'titre' => 'Le conte du lézard et du soleil',
                'texte' => fake()->paragraph(26),
                'idRegion' => 2, 'idLangue' => 6, 'idTypeContenu' => 2,
            ],
            [
                'titre' => 'Recette du Gboman dessi',
                'texte' => fake()->paragraph(25),
                'idRegion' => 1, 'idLangue' => 1, 'idTypeContenu' => 3,
            ],
            [
                'titre' => 'Le cérémonial du Kouvito',
                'texte' => fake()->paragraph(40),
                'idRegion' => 1, 'idLangue' => 1, 'idTypeContenu' => 4,
            ],
        ];

        foreach ($contenus as $c) {

            // Un auteur au hasard
            $auteur = fake()->randomElement($auteurs);

            // On décide si le contenu est validé ou en cours
            $estValide = fake()->boolean(60); // 60 % seront validés

            Contenu::create([
                'titre' => $c['titre'],
                'texte' => $c['texte'],
                'statut' => $estValide ? 'validé' : 'en cours',
                'dateCreation' => now(),
                'dateValidation' => $estValide ? now() : null,
                'idTypeContenu' => $c['idTypeContenu'],
                'idAuteur' => $auteur,
                'idParent' => null,
                'idRegion' => $c['idRegion'],
                'idLangue' => $c['idLangue'],
                'idModerateur' => $estValide ? fake()->randomElement($moderateurs) : null
            ]);
        }
    }
}

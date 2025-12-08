<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ----- UTILISATEURS EXISTANTS -----
        User::create([
            'nom' => 'ZOUGOUI',
            'prenom' => 'Junior',
            'password' => Hash::make('Azerty12'),
            'email' => 'zouzou@gmail.com',
            'sexe' => 'masculin',
            'dateNaissance' => '2005-04-12',
            'idRole' => 4,
            'idLangue' => 3
        ]);

        User::create([
            'nom' => 'ATCHAOUE',
            'prenom' => 'Jordy',
            'password' => Hash::make('Abcd12'),
            'email' => 'jordyatchaoue@gmail.com',
            'sexe' => 'féminin',
            'dateNaissance' => '2007-04-14',
            'idRole' => 1,    // Auteur possible
            'idLangue' => 1
        ]);

        User::create([
            'nom' => 'COMLAN',
            'prenom' => 'Maurice',
            'password' => Hash::make('Eneam123'),
            'email' => 'maurice.comlan@uac.bj',
            'sexe' => 'masculin',
            'dateNaissance' => '1979-04-17',
            'idRole' => 1,    // Auteur possible
            'idLangue' => 4
        ]);

        // ----- NOUVEAUX UTILISATEURS -----
        User::create([
            'nom' => 'AGOSSOU',
            'prenom' => 'Rebecca',
            'password' => Hash::make('Pass123'),
            'email' => 'rebecca.agossou@example.com',
            'sexe' => 'féminin',
            'dateNaissance' => '2002-09-02',
            'idRole' => 3,   // Modératrice possible
            'idLangue' => 6
        ]);

        User::create([
            'nom' => 'KPOSSOU',
            'prenom' => 'Rodrigue',
            'password' => Hash::make('Test123'),
            'email' => 'rodrigue.kpossou@example.com',
            'sexe' => 'masculin',
            'dateNaissance' => '2000-01-22',
            'idRole' => 2,
            'idLangue' => 1
        ]);

        User::create([
            'nom' => 'SODOKIN',
            'prenom' => 'Mireille',
            'password' => Hash::make('Test123'),
            'email' => 'mireille.sodokin@example.com',
            'sexe' => 'féminin',
            'dateNaissance' => '1998-05-05',
            'idRole' => 5,
            'idLangue' => 2
        ]);
    }
}

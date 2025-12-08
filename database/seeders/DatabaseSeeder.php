<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
         $this->call([
            // 1. Rôles et références de base
            RoleSeeder::class,

            // 2. Données de référence
            LangueSeeder::class,
            RegionSeeder::class,
            TypeMediaSeeder::class,
            TypeContenuSeeder::class,

            // 3. Utilisateurs (auteurs, modérateurs, autres rôles)
            UserSeeder::class,

            // 4. Contenus (doivent avoir auteurs, langues, régions, type de contenu)
            ContenusSeeder::class,

            // 5. Médias (doivent avoir contenus et type média)
            MediaSeeder::class,
        ]);



    }
}

<?php


use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\front\ProfileController;
use App\Http\Controllers\front\CommentairesFrontController;
use App\Http\Controllers\admin\ContenusController;
use App\Http\Controllers\ThemeController;



use App\Models\Media;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


Route::get('/', function () {
    return response('OK', 200);
});

Route::get('/', function(Request $request) {
    // Si c'est une redirection depuis FedaPay
    if ($request->has('status') && $request->has('id')) {
        \Log::info('Redirection FedaPay reçue', $request->all());

        // Stocker les paramètres
        session([
            'fedapay_redirect' => [
                'status' => $request->status,
                'transaction_id' => $request->id
            ]
        ]);

        // Rediriger vers la vraie page success
        return redirect()->route('front.abonnement.success');
    }

    // Sinon, page d'accueil normale
    return view('front.home');
})->name('home');

// Groupe pour les routes nécessitant une authentification
Route::middleware('auth')->group(function () {

    // Routes de profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/photo/upload', [ProfileController::class, 'uploadPhoto'])->name('profile.photo.upload');
    Route::post('/profile/photo/delete', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');

    // Routes pour commentaires
    Route::post('/contenu/{id}/commentaire', [CommentairesFrontController::class, 'store'])->name('front.commentaire.store');

    // Routes pour contenus
    Route::get('contenus/create', [ContenusController::class, 'create'])->name('front.contenus.create');
    Route::post('contenus', [ContenusController::class, 'store'])->name('front.contenus.store');
    Route::get('contenus/{id}/edit', [ContenusController::class, 'edit'])->name('front.contenus.edit');
    Route::put('contenus/{id}', [ContenusController::class, 'update'])->name('front.contenus.update');
    Route::delete('contenus/{id}', [ContenusController::class, 'destroy'])->name('front.contenus.destroy');

});

// Route pour changer le thème
Route::post('/theme-toggle', [ThemeController::class, 'toggle'])->name('theme.toggle');

// Vérification DB
Route::get('/db-check', function() {
    try {
        // Test connexion
        DB::connection()->getPdo();

        // Récupérer le nom de la base de données
        $databaseName = DB::connection()->getDatabaseName();

        // Compter les tables
        $tables = DB::select('SHOW TABLES');

        // Compter les lignes
        $counts = [];
        foreach ($tables as $table) {
            $tableName = $table->{'Tables_in_' . $databaseName};
            $counts[$tableName] = DB::table($tableName)->count();
        }

        return response()->json([
            'connected' => true,
            'database' => $databaseName,
            'tables_count' => count($tables),
            'data_counts' => $counts,
            'needs_seeding' => array_sum($counts) === 0
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'connected' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});

// Inclure les autres fichiers de routes
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/front.php';

// Route temporaire pour exécuter les migrations
Route::get('/admin/deploy-run', function() {
    // Protection basique (à améliorer)
    if (request('token') !== env('DEPLOY_TOKEN', 'secret123')) {
        abort(403);
    }

    $output = [];

    // Exécuter les migrations
    Artisan::call('migrate --force');
    $output[] = Artisan::output();

    // Exécuter les seeders
    Artisan::call('db:seed --force');
    $output[] = Artisan::output();

    return '<pre>' . implode("\n\n", $output) . '</pre>';
})->name('deploy.run');

Route::get('/seed-users-direct', function () {

    // 🔐 Sécurité minimale (OBLIGATOIRE)
    if (app()->environment('production')) {
        abort(403, 'Accès interdit');
    }

    // --- UTILISATEURS ---
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
        'idRole' => 1,
        'idLangue' => 1
    ]);

    User::create([
        'nom' => 'COMLAN',
        'prenom' => 'Maurice',
        'password' => Hash::make('Eneam123'),
        'email' => 'maurice.comlan@uac.bj',
        'sexe' => 'masculin',
        'dateNaissance' => '1979-04-17',
        'idRole' => 1,
        'idLangue' => 4
    ]);

    User::create([
        'nom' => 'AGOSSOU',
        'prenom' => 'Rebecca',
        'password' => Hash::make('Pass123'),
        'email' => 'rebecca.agossou@example.com',
        'sexe' => 'féminin',
        'dateNaissance' => '2002-09-02',
        'idRole' => 3,
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

    return response()->json([
        'status' => 'OK',
        'message' => 'Seed exécuté directement depuis la route'
    ]);
});


Route::get('/seed-medias-direct', function () {

    // 🔐 Sécurité minimale
    if (app()->environment('production')) {
        abort(403, 'Accès interdit');
    }

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
        // Evite doublons
        Media::firstOrCreate(
            ['chemin' => 'adminlte/img/' . $media['fichier']],
            [
                'description' => 'Media associé au contenu ' . $media['idContenu'],
                'idTypeMedia' => $media['type'],
                'idContenu' => $media['idContenu'],
            ]
        );
    }

    return response()->json([
        'status' => 'OK',
        'message' => 'Medias seedés directement depuis la route'
    ]);
});


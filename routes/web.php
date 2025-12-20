<?php


use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\front\ProfileController;
use App\Http\Controllers\front\CommentairesFrontController;
use App\Http\Controllers\admin\ContenusController;
use App\Http\Controllers\ThemeController;

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

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\front\{
    AbonnementController,
    ContenusFrontController
};
use App\Models\Contenu;

// Route de test
Route::get('/test-paiement', function(Request $request) {
    $contenuId = $request->id ?? 1;
    $transactionId = 'TEST_' . time();

    // Simuler un retour FedaPay
    return redirect()->route('front.abonnement.success', [
        'contenu_id' => $contenuId,
        'id' => $transactionId,
        'status' => 'approved'
    ]);
});

// Home
Route::get('/', function () {
    $sections = [
        'histoire' => Contenu::whereHas('typeContenu', fn($q) => $q->where('nom', 'Histoire'))->take(4)->get(),
        'conte' => Contenu::whereHas('typeContenu', fn($q) => $q->where('nom', 'Conte'))->take(4)->get(),
        'recette' => Contenu::whereHas('typeContenu', fn($q) => $q->where('nom', 'Recette'))->take(4)->get(),
        'danse' => Contenu::whereHas('typeContenu', fn($q) => $q->where('nom', 'Danse'))->take(4)->get(),
        'rituel' => Contenu::whereHas('typeContenu', fn($q) => $q->where('nom', 'Rituel'))->take(4)->get(),
    ];
    return view('front.home', compact('sections'));
})->name('home');

// Routes d'abonnement
Route::get('/abonnement/{id}', [AbonnementController::class, 'show'])->name('front.abonnement.show');
Route::post('/abonnement/payer', [AbonnementController::class, 'payer'])->name('front.abonnement.payer');


// IMPORTANT : Les deux routes pour callback (POST et GET)
Route::post('/abonnement/callback', [AbonnementController::class, 'callback'])->name('front.abonnement.callback');
Route::get('/abonnement/callback', [AbonnementController::class, 'callbackRedirect'])->name('front.abonnement.callback.redirect');

Route::post('/abonnement/initier', [AbonnementController::class, 'initier'])->name('front.abonnement.initier');

// Route success (GET uniquement)
Route::get('/abonnement/success', [AbonnementController::class, 'success'])->name('front.abonnement.success');

// Routes contenu
Route::get('/contenus', [ContenusFrontController::class, 'index'])->name('front.contenus.index');
Route::get('/contenu/{id}', [ContenusFrontController::class, 'show'])->name('front.contenu.show');
Route::get('/contenus/section/{slug}', [ContenusFrontController::class, 'section'])->name('front.contenus.section');


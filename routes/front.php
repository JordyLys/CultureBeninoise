<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\front\{
    AbonnementController,
    ContenusFrontController
};
use App\Models\Contenu;

// Home
Route::get('/', function () {
    $sections = [

    'histoire' => Contenu::with(['media','langue','region','typeContenu'])
                    ->whereHas('typeContenu', fn($q) => $q->where('nom', 'Histoire'))
                    ->take(4)->get(),

    'conte' => Contenu::with(['media','langue','region','typeContenu'])
                    ->whereHas('typeContenu', fn($q) => $q->where('nom', 'Conte'))
                    ->take(4)->get(),

    'recette' => Contenu::with(['media','langue','region','typeContenu'])
                    ->whereHas('typeContenu', fn($q) => $q->where('nom', 'Recette'))
                    ->take(4)->get(),

    'danse' => Contenu::with(['media','langue','region','typeContenu'])
                    ->whereHas('typeContenu', fn($q) => $q->where('nom', 'Danse'))
                    ->take(4)->get(),

    'rituel' => Contenu::with(['media','langue','region','typeContenu'])
                    ->whereHas('typeContenu', fn($q) => $q->where('nom', 'Rituel'))
                    ->take(4)->get(),
];


    return view('front.home', compact('sections'));
})->name('home');


Route::get('/contenus/section/{slug}', [ContenusFrontController::class, 'section'])
    ->name('front.contenus.section');


// Abonnement
Route::get('/abonnement', function () {
    $id = null; // valeur par défaut
    return view('front.abonnement', compact('id'));
})->name('front.abonnement');

// Routes abonnement avec controller
Route::get('/abonnement/{id}', [AbonnementController::class, 'show'])->name('front.abonnement.show');
Route::post('/abonnement/payer', [AbonnementController::class, 'payer'])->name('front.abonnement.payer');
Route::get('/abonnement/callback', [AbonnementController::class, 'callback'])->name('front.abonnement.callback');

// Contenus front
Route::get('/contenus', [ContenusFrontController::class, 'index'])->name('front.contenus.index');
Route::get('/contenu/{id}', [ContenusFrontController::class, 'show'])->name('front.contenu.show');

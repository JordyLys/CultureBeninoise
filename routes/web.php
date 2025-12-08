<?php

use App\Http\Controllers\front\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\front\CommentairesFrontController;

use App\Http\Controllers\front\ContenusFrontController;


Route::middleware('auth')->group(function () {
  //  Route::get('/acceuil', function () {
   // return view('welcome');
//})->name('acceuil');



Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update'); // email/telephone
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password'); // mot de passe
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // supprimer compte
     Route::post('/profile/photo/upload', [ProfileController::class, 'uploadPhoto'])->name('profile.photo.upload');
    Route::post('/profile/photo/delete', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');


});

    Route::get('/contenus', [ContenusFrontController::class, 'index'])->name('front.contenus.index');
     Route::get('/contenu/{id}', [ContenusFrontController::class, 'show'])->name('front.contenu');

    Route::post('/contenu/{id}/commentaire', [CommentairesFrontController::class, 'store'])->name('front.commentaire.store');

      Route::get('contenus/create', [ContenusController::class, 'create'])->name('contenus.create');
    Route::post('contenus', [ContenusController::class, 'store'])->name('contenus.store');
    Route::get('contenus/{id}/edit', [ContenusController::class, 'edit'])->name('contenus.edit');
    Route::put('contenus/{id}', [ContenusController::class, 'update'])->name('contenus.update');
    Route::delete('contenus/{id}', [ContenusController::class, 'destroy'])->name('contenus.destroy');

});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/front.php';

Route::post('/theme-toggle', [App\Http\Controllers\ThemeController::class, 'toggle'])
->name('theme.toggle');


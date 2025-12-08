<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\{
    LanguesController,
    RegionsController,
    RolesController,
    TypeMediasController,
    TypeContenusController,
    UsersController,
    ContenusController,
    MediasController,
    CommentairesController,
    AdminController
};

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('langues', LanguesController::class);
    Route::resource('regions', RegionsController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('typeMedias', TypeMediasController::class);
    Route::resource('typeContenus', TypeContenusController::class);
    Route::resource('medias', MediasController::class);
    Route::resource('users', UsersController::class);

    // Contenus : lister et show séparés
    Route::get('contenus', [ContenusController::class, 'index'])->name('admin.contenus.index');
    Route::get('contenus/{id}', [ContenusController::class, 'show'])->name('admin.contenus.show');
    Route::resource('contenus', ContenusController::class)->except(['index', 'show']);

    Route::resource('commentaires', CommentairesController::class);

});

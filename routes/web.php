<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPokemonController;
use App\Http\Controllers\UserPokemonDislikeController;
use App\Http\Controllers\UserPokemonLikeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AppController::class, 'landing']);

Route::middleware(['auth'])->get('dashboard', [AppController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::prefix('user')->group(function () {
        Route::get('list', [UserController::class, 'index']);
        Route::put('update/{user}', [UserController::class, 'updateUserProfile']);
        Route::put('update-password/{user}', [UserController::class, 'updateUserPassword']);
    });

    Route::prefix('pokemon')->group(function () {
        Route::get('user', [UserPokemonController::class, 'userPokemon']);
        Route::post('add-to-likes', [UserPokemonLikeController::class, 'addToLikes']);
        Route::post('add-to-dislikes', [UserPokemonDislikeController::class, 'addToDislikes']);
        Route::get('my-pokemon-likes', [UserPokemonLikeController::class, 'myPokemonLikes']);
        Route::get('my-pokemon-dislikes', [UserPokemonDislikeController::class, 'myPokemonDislikes']);
    });
});
require __DIR__ . '/auth.php';

Route::get('{any}', [AppController::class, 'index'])->where('any', '.*');

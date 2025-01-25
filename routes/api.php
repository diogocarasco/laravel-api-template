<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FavouriteController;

Route::middleware('auth:sanctum')->prefix('messages')->group(function () {
    // Criar uma nova mensagem
    Route::post('/', [MessageController::class, 'store'])->name('messages.store');

    // Listar todas as mensagens
    Route::get('/', [MessageController::class, 'index'])->name('messages.index');

    // Mostrar uma mensagem específica
    Route::get('{id}', [MessageController::class, 'show'])->name('messages.show');

    // Atualizar uma mensagem específica
    Route::put('{id}', [MessageController::class, 'update'])->name('messages.update');

    // Deletar uma mensagem específica
    Route::delete('{id}', [MessageController::class, 'destroy'])->name('messages.destroy');
});

Route::middleware('auth:sanctum')->prefix('users')->group(function () {
    // Mostrar o perfil do usuário autenticado
    Route::get('profile', [UserController::class, 'showProfile'])->name('users.profile');

    // Atualizar o perfil do usuário autenticado
    Route::put('profile', [UserController::class, 'updateProfile'])->name('users.updateProfile');

    // Listar todos os usuários (se necessário)
    Route::get('/', [UserController::class, 'index'])->name('users.index');

    // Mostrar um usuário específico (se necessário)
    Route::get('{id}', [UserController::class, 'show'])->name('users.show');
});


Route::middleware('auth:sanctum')->prefix('favorites')->group(function () {
    // Adicionar um favorito
    Route::post('/', [FavouriteController::class, 'store'])->name('favourites.store');

    // Listar todos os favoritos de um usuário autenticado
    Route::get('user/{userId}', [FavouriteController::class, 'index'])->name('favourites.index');

    // Deletar um favorito específico
    Route::delete('{id}', [FavouriteController::class, 'destroy'])->name('favourites.destroy');
});
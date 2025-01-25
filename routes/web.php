<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AuthController;
use App\Http\Livewire\Login;

// Página inicial (por exemplo, uma página de boas-vindas)
Route::get('/', function () {
    return view('welcome');
});

// Rota de Login com Livewire
Route::get('/login', Login::class)->name('login');

// Rota de login POST para autenticação do usuário com Livewire (ou controller)
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Rotas para usuários logados
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // Página de dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rotas para o MessageController com autenticação via Sanctum
    Route::prefix('messages')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('messages.index');
        Route::get('{id}', [MessageController::class, 'show'])->name('messages.show');
        Route::post('/', [MessageController::class, 'store'])->name('messages.store');
        Route::put('{id}', [MessageController::class, 'update'])->name('messages.update');
        Route::delete('{id}', [MessageController::class, 'destroy'])->name('messages.destroy');
    });

    // Rotas para o UserController com autenticação via Sanctum
    Route::prefix('users')->group(function () {
        Route::get('profile', [UserController::class, 'showProfile'])->name('users.profile');
        Route::put('profile', [UserController::class, 'updateProfile'])->name('users.updateProfile');
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('{id}', [UserController::class, 'show'])->name('users.show');
    });

    // Rotas para o FavoriteController com autenticação via Sanctum
    Route::prefix('favorites')->group(function () {
        Route::post('/', [FavoriteController::class, 'store'])->name('favorites.store');
        Route::get('user/{userId}', [FavoriteController::class, 'index'])->name('favorites.index');
        Route::delete('{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    });
});

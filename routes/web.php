<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    $games = \App\Models\Game::where('is_blocked', false)->latest()->limit(12)->get();
    return view('dashboard', compact('games'));
})->name('home');

// Custom Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('dashboard', function () {
    $games = \App\Models\Game::where('is_blocked', false)->latest()->limit(12)->get();
    return view('dashboard', compact('games'));
})->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');

    Volt::route('settings/profile', 'settings.profile', ['layout' => 'layouts.blank'])->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Route::resource('games', GameController::class);
    Route::resource('trades', TradeController::class);
    Route::post('/trades/{trade}/accept', [TradeController::class, 'accept'])->name('trades.accept');
    Route::post('/trades/{trade}/decline', [TradeController::class, 'decline'])->name('trades.decline');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
});

Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');

// Legal pages
Route::view('/privacy', 'legal.privacy')->name('privacy.show');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Users management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::post('/users/{user}/toggle-block', [AdminController::class, 'toggleUserBlock'])->name('users.toggle-block');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    // Games management
    Route::get('/games', [AdminController::class, 'games'])->name('games');
    Route::get('/games/{game}', [AdminController::class, 'showGame'])->name('games.show');
    Route::post('/games/{game}/toggle-block', [AdminController::class, 'toggleGameBlock'])->name('games.toggle-block');
    Route::delete('/games/{game}', [AdminController::class, 'destroyGame'])->name('games.destroy');
});



<?php

use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PertandinganController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Default route to show the login page
Route::get('/', function () {
    return view('login');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

// Routes for 'Pelatih' (Coach)
Route::middleware(['auth', 'user-access:user'])->prefix('user')->group(function () {
    Route::get('/home', [HomeController::class, 'Homepage']);
    Route::get('/player', [PlayerController::class, 'ViewPlayer']);
    Route::get('/player/edit/{id}', [PlayerController::class, 'ViewEditPlayer']);
    Route::put('/player/edit/{id}', [PlayerController::class, 'UpdatePlayer']);
    Route::get('/pertandingan', [PertandinganController::class, 'ViewPertandingan']);
    Route::get('/pertandingan/edit/{id}', [PertandinganController::class, 'ViewEditPertandingan']);
    Route::put('/pertandingan/edit/{id}', [PertandinganController::class, 'UpdatePertandingan']);
    Route::get('/laporan', [PertandinganController::class, 'ViewLaporan']);
    Route::get('/report', [PertandinganController::class, 'print']);
    Route::get('/export', [PertandinganController::class, 'download']);
});

// Routes for 'Admin'
Route::middleware(['auth', 'user-access:admin'])->prefix('admin')->group(function () {
    Route::get('/home', [HomeController::class, 'Homepage']);
    Route::get('/player', [PlayerController::class, 'ViewPlayer']);
    Route::get('/player/add', [PlayerController::class, 'ViewAddPlayer']);
    Route::post('/player/add', [PlayerController::class, 'CreatePlayer']);
    Route::get('/player/edit/{id}', [PlayerController::class, 'ViewEditPlayer']);
    Route::put('/player/edit/{id}', [PlayerController::class, 'UpdatePlayer']);
    Route::delete('/player/delete/{id}', [PlayerController::class, 'DeletePlayer']);
    Route::get('/pertandingan', [PertandinganController::class, 'ViewPertandingan']);
    Route::get('/pertandingan/add', [PertandinganController::class, 'ViewAddPertandingan']);
    Route::post('/pertandingan/add', [PertandinganController::class, 'CreatePertandingan']);
    Route::get('/pertandingan/edit/{id}', [PertandinganController::class, 'ViewEditPertandingan']);
    Route::put('/pertandingan/edit/{id}', [PertandinganController::class, 'UpdatePertandingan']);
    Route::delete('/pertandingan/delete/{id}', [PertandinganController::class, 'DeletePertandingan']);
    Route::get('/laporan', [PertandinganController::class, 'ViewLaporan']);
    Route::get('/report', [PertandinganController::class, 'print']);
    Route::get('/export', [PertandinganController::class, 'download']);
});

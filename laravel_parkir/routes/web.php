<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

// Dasboard
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;

// Controller Parkir
use App\Http\Controllers\MasukController;
use App\Http\Controllers\DetailParkirController;

// Users
use App\Http\Controllers\UserController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/', [LoginController::class, 'login']);
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/parkir', [MasukController::class, 'index'])->name('parkir.index');
    Route::get('/riwayat-parkir', [DetailParkirController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat-parkir/export-excel', [DetailParkirController::class, 'exportExcel'])->name('riwayat.export.excel');

   Route::middleware('can:access-admin-features')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');

        //Hak Akses Super Admin
        Route::middleware('can:create-user')->group(function () {
            
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            
            Route::post('/users', [UserController::class, 'store'])->name('users.store');

            Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
          
            Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
           
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
            });
    });
});


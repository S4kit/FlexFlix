<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;




//This file for login/register/logout functions


Route::post('/register', [UserController::class, 'register']);

Route::get('/login', function () {
    return 'You need to login first!';
})->name('login');

Route::post('/login', [UserController::class, 'login']);
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
});
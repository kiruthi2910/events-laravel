<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\ClubController;

Route::resource('clubs', ClubController::class);
Route::get('/clubs/{id}/profile', [ClubController::class, 'profile'])->name('clubs.profile');

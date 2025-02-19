<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministradorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', [AdministradorController::class, 'index']);
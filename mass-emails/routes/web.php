<?php

use Illuminate\Support\Facades\Route;
use Koisystems\MassEmails\Http\Controllers\MassEmailController;

Route::get('/',       [MassEmailController::class, "index"])->name( 'massmails.index');
Route::get('/create', [MassEmailController::class, "create"])->name('massmails.create');
Route::get('/{id}',   [MassEmailController::class, "show"])->name(  'massmails.show');


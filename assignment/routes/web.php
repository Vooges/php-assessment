<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::get('/', [MessageController::class, 'create']);
Route::post('/send', [MessageController::class, 'store']);
Route::get('/{message}', [MessageController::class, 'protectedShow']);
Route::post('/{message}/decrypted', [MessageController::class, 'show']);

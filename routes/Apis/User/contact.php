<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\ContactUserController;



Route::controller(ContactUserController::class)->group(
    function () {
        Route::post('/create/contact', 'create');
    });

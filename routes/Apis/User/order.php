<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\OrderUserController;


Route::controller(OrderUserController::class)->group(
    function () {
        Route::post('/create/order', 'create');
    });

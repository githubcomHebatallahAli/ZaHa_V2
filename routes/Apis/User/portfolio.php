<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\PortfolioUserController;


Route::controller(PortfolioUserController::class)->group(
    function () {
        Route::get('/showAll/portfolio', 'showAll');
        Route::get('/edit/portfolio/{id}', 'edit');

    });

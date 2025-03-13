<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PortfolioController;


Route::controller(PortfolioController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/portfolio','showAll');
   Route::post('/create/portfolio', 'create');
   Route::get('/edit/portfolio/{id}','edit');
   Route::post('/update/portfolio/{id}', 'update');
   Route::delete('/delete/portfolio/{id}', 'destroy');
   Route::get('/showDeleted/portfolio', 'showDeleted');
Route::get('/restore/portfolio/{id}','restore');
Route::delete('/forceDelete/portfolio/{id}','forceDelete');
Route::patch('/active/portfolio/{id}','active');
Route::patch('/notActive/portfolio/{id}','notActive');

   });

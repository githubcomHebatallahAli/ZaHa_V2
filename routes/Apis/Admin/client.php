<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ClientController;


Route::controller(ClientController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/client','showAll');
   Route::post('/create/client', 'create');
   Route::get('/edit/client/{id}','edit');
   Route::post('/update/client/{id}', 'update');
   Route::delete('/delete/client/{id}', 'destroy');
   Route::get('/showDeleted/client', 'showDeleted');
Route::get('/restore/client/{id}','restore');
Route::delete('/forceDelete/client/{id}','forceDelete');
   });

<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrderController;


Route::controller(OrderController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/order','showAll');
   Route::get('/edit/order/{id}','edit');
   Route::delete('/delete/order/{id}', 'destroy');
   Route::get('/showDeleted/order', 'showDeleted');
Route::get('/restore/order/{id}','restore');
Route::delete('/forceDelete/order/{id}','forceDelete');

   });

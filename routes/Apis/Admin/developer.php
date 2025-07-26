<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DeveloperController;


Route::controller(DeveloperController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/developer','showAll');
   Route::post('/create/developer', 'create');
   Route::get('/edit/developer/{id}','edit');
   Route::post('/update/developer/{id}', 'update');
   Route::delete('/delete/developer/{id}', 'destroy');
   Route::get('/showDeleted/developer', 'showDeleted');
Route::get('/restore/developer/{id}','restore');
Route::delete('/forceDelete/developer/{id}','forceDelete');
   });

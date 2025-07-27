<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProjectController;


Route::controller(ProjectController::class)->prefix('/admin')->middleware('admin')->group(
    function () {

   Route::get('/showAll/project','showAll');
   Route::post('/create/project', 'create');
   Route::get('/edit/project/{id}','edit');
   Route::post('/update/project/{id}', 'update');
   Route::delete('/delete/project/{id}', 'destroy');
   Route::get('/showDeleted/project', 'showDeleted');
Route::get('/restore/project/{id}','restore');
Route::delete('/forceDelete/project/{id}','forceDelete');
Route::patch('/pending/project/{id}', 'pending');
Route::patch('/rejected/project/{id}', 'rejected');
   Route::patch('/completed/project/{id}', 'completed');
   Route::patch('/canceled/project/{id}', 'canceled');
   Route::patch('/inProgress/project/{id}', 'inProgress');

   });

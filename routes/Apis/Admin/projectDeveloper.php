<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProjectDeveloperController;


Route::controller(ProjectDeveloperController::class)->prefix('/admin')->middleware('admin')->group(
    function () {


   Route::post('/add/developer/to/project/{projectId}', 'attachDevelopers');
   Route::get('/edit/project/{id}/with/developers','edit');
   Route::delete('/delete/developer/from/project/{projectId}', 'detachDevelopers');

   });

<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;


Route::controller(AdminAuthController::class)->prefix('/admin')->group(
    function () {
Route::post('/login', 'login');
Route::post('/register',  'register');
Route::post('/logout',  'logout');
Route::post('/refresh', 'refresh');
Route::get('/user-profile', 'userProfile');

});





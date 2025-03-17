<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\NotificationController;



Route::controller(NotificationController::class)->prefix('/admin')->middleware('admin')->group(
    function () {
        Route::get('showAll/notifications',  'showAll');
    Route::get('unread/notifications', 'unread');
    Route::post('markReadAll/notifications', 'markReadAll');
    Route::delete('deleteAll/notifications', 'deleteAll');
    Route::delete('delete/notification/{id}', 'delete');
    });


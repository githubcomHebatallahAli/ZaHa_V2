<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Part\TextPart;


Route::get('/test-email', function () {
    Mail::send([], [], function($message) {
        $message->to('ziad07138@gmail.com')
                ->subject('Test Email')
                ->setBody(new TextPart('This is a test email', 'text/html'));
    });

    return 'Test email sent!';
});




require __DIR__ . '/Apis/Auth/auth.php';
require __DIR__ . '/Apis/Admin/role.php';
require __DIR__ . '/Apis/Admin/contact.php';
require __DIR__ . '/Apis/Admin/order.php';
require __DIR__ . '/Apis/Admin/portfolio.php';
require __DIR__ . '/Apis/Admin/user.php';
require __DIR__ . '/Apis/Admin/notification.php';
require __DIR__ . '/Apis/Admin/client.php';
require __DIR__ . '/Apis/Admin/project.php';
require __DIR__ . '/Apis/Admin/developer.php';
require __DIR__ . '/Apis/Admin/projectDeveloper.php';
require __DIR__ . '/Apis/User/contact.php';
require __DIR__ . '/Apis/User/order.php';
require __DIR__ . '/Apis/User/portfolio.php';


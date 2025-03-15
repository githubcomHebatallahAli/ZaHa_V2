<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Admin;
use App\Models\Contact;
use App\Mail\NewContactMail;
use App\Mail\ContactWelcomeMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Mix\ContactRequest;
use App\Http\Resources\Mix\ContactResource;
use App\Notifications\NewContactNotification;

class ContactUserController extends Controller
{

    public function create(ContactRequest $request)
    {
           $contact =Contact::create ([
            'name'=> $request->name,
            'phoneNumber' => $request->phoneNumber,
            'message' => $request->message,
            ]);

            // $admin = Admin::where('role_id', 1)->first();

            // if ($admin) {
            //     $admin->notify(new NewContactNotification($contact));
            // }

            Mail::send([], [], function($message) use ($contact) {
                $message->to('ziad07138@gmail.com')
                        ->subject('رسالة جديدة من المستخدم')
                        ->setBody('<p>تم إرسال رسالة جديدة من ' . $contact->name . '</p>', 'text/html'); // رسالة HTML
            });

           $contact->save();
           return response()->json([
            'data' =>new ContactResource($contact),
            'message' => "Contact Created Successfully."
        ]);
        }


}

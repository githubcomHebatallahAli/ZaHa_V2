<?php

namespace App\Http\Controllers\User;

use App\Models\User;
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

            // $admins = User::where('isAdmin', 1)->get();
            // foreach ($admins as $admin) {
            //     $admin->notify(new NewContactNotification($contact));
            //     Mail::to($admin->email)->send(new NewContactMail($contact));
            // }
            // Mail::to($contact->user->email)->send(new ContactWelcomeMail($contact));

           $contact->save();
           return response()->json([
            'data' =>new ContactResource($contact),
            'message' => "Contact Created Successfully."
        ]);
        }


}

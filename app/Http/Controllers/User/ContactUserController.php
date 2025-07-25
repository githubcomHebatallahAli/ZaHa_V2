<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Admin;
use App\Models\Contact;
use App\Mail\NewContactMail;

use App\Http\Controllers\Controller;

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
            'creationDate' => $request->creationDate,
            ]);

           $contact->save();
           $superAdmin = Admin::where('role_id', 1)->where('status', 'active')->first();
           if ($superAdmin) {
               $superAdmin->notify(new NewContactNotification($contact));

           return response()->json([
            'data' =>new ContactResource($contact),
            'message' => "Contact Created Successfully."
        ]);
        }
}
}

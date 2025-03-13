<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\Mix\ContactResource;


class ContactController extends Controller
{
    use ManagesModelsTrait;

    public function showAll()
    {
        $this->authorize('manage_users');

        $Contacts = Contact::get();
        return response()->json([
            'data' => ContactResource::collection($Contacts),
            'message' => "Show All Users With Messages Of Contact Us Successfully."
        ]);
    }

    public function edit(string $id)
    {
        $this->authorize('manage_users');
        $Contact = Contact::find($id);
        if (!$Contact) {
            return response()->json([
                'message' => "Contact not found."
            ], 404);
        }
        return response()->json([
            'data' =>new ContactResource($Contact),
            'message' => "Edit Contact for User Successfully."
        ]);

    }

    public function destroy(string $id)
    {
        return $this->destroyModel(Contact::class, ContactResource::class, $id);
    }

    public function showDeleted()
    {
      $this->authorize('manage_users');
  $Contacts=Contact::onlyTrashed()->get();
  return response()->json([
      'data' =>ContactResource::collection($Contacts),
      'message' => "Show Deleted Contacts Successfully."
  ]);

  }

  public function restore(string $id)
  {
     $this->authorize('manage_users');
  $Contact = Contact::withTrashed()->where('id', $id)->first();
  if (!$Contact) {
      return response()->json([
          'message' => "Contact not found."
      ], 404);
  }
  $Contact->restore();
  return response()->json([
      'data' =>new ContactResource($Contact),
      'message' => "Restore Contact By Id Successfully."
  ]);
  }

    public function forceDelete(string $id)
    {
        return $this->forceDeleteModel(Contact::class, $id);
    }
}

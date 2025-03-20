<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\Admin\UserResource;


class UserController extends Controller
{
    use ManagesModelsTrait;
    public function showAll()
    {
        $this->authorize('manage_users');

        $Users = User::get();
        return response()->json([
            'data' => UserResource::collection($Users),
            'message' => "Show All Users Successfully."
        ]);
    }


    public function create(UserRequest $request)
    {
        $this->authorize('manage_users');

           $User =User::create ([
                "name" => $request->name,
                "email" => $request->email,
                "state" => $request->state,
                "governorate" => $request->governorate,
                "address" => $request->address,
                "userJob" => $request->userJob,
                "information" => $request->information,
                "projPrice" => $request->projPrice,
            ]);

           return response()->json([
            'data' =>new UserResource($User),
            'message' => "User Created Successfully."
        ]);
        }


    public function edit(string $id)
    {
        $this->authorize('manage_users');
        $User = User::find($id);

        if (!$User) {
            return response()->json([
                'message' => "User not found."
            ], 404);
        }

        return response()->json([
            'data' =>new UserResource($User),
            'message' => "Edit User By ID Successfully."
        ]);
    }



    public function update(UserRequest $request, string $id)
    {
        $this->authorize('manage_users');
       $User =User::findOrFail($id);

       if (!$User) {
        return response()->json([
            'message' => "User not found."
        ], 404);
    }
       $User->update([
                "name" => $request->name,
                "email" => $request->email,
                "state" => $request->state,
                "governorate" => $request->governorate,
                "address" => $request->address,
                "userJob" => $request->userJob,
                "information" => $request->information,
                "projPrice" => $request->projPrice,
        ]);
       return response()->json([
        'data' =>new UserResource($User),
        'message' => " Update User By Id Successfully."
    ]);

  }

  public function destroy(string $id)
  {
      return $this->destroyModel(User::class, UserResource::class, $id);
  }

  public function showDeleted()
  {
    $this->authorize('manage_users');
$Users=User::onlyTrashed()->get();
return response()->json([
    'data' =>UserResource::collection($Users),
    'message' => "Show Deleted Users Successfully."
]);

}

public function restore(string $id)
{
   $this->authorize('manage_users');
$User = User::withTrashed()->where('id', $id)->first();
if (!$User) {
    return response()->json([
        'message' => "User not found."
    ], 404);
}
$User->restore();
return response()->json([
    'data' =>new UserResource($User),
    'message' => "Restore User By Id Successfully."
]);
}

  public function forceDelete(string $id)
  {
      return $this->forceDeleteModel(User::class, $id);
  }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeveloperRequest;
use App\Http\Resources\Admin\DeveloperResource;
use App\Models\Developer;
use App\Traits\ManagesModelsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeveloperController extends Controller
{
    use ManagesModelsTrait;

    public function showAll()
    {
        $this->authorize('manage_users');
        $Developers = Developer::get();
        return response()->json([
            'data' => $Developers->map(function ($Developer) {
                return [
                    'id' => $Developer->id,
                    'name' => $Developer->name,
                    'address' => $Developer->address,
                ];
            }),
            'message' => "Show All Developers Successfully."
        ]);
    }

    public function create(DeveloperRequest $request)
    {
        $this->authorize('manage_users');
        $Developer = Developer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'DeveloperOpinion' => $request->DeveloperOpinion,
            'zahaOpinion' => $request->zahaOpinion,
            'notes' => $request->notes,
            'creationDate' => now()->timezone('Africa/Cairo')->format('Y-m-d H:i:s'),
        ]);
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('Developer', 'public');
            $Developer->photo = $photoPath;
        }
        $Developer->save();
        return response()->json([
            'data' => new DeveloperResource($Developer),
            'message' => "Developer Created Successfully."
        ]);
    }

    public function edit(string $id)
    {
        $this->authorize('manage_users');
        $Developer = Developer::find($id);
        if (!$Developer) {
            return response()->json([
                'message' => "Developer not found."
            ], 404);
        }
        return response()->json([
            'data' => new DeveloperResource($Developer),
            'message' => "Edit Developer By ID Successfully."
        ]);
    }

    public function update(DeveloperRequest $request, string $id)
    {
        $this->authorize('manage_users');
        $Developer = Developer::findOrFail($id);
        if (!$Developer) {
            return response()->json([
                'message' => "Developer not found."
            ], 404);
        }
        if ($request->filled('name')) {
            $Developer->name = $request->name;
        }
        if ($request->filled('phone')) {
            $Developer->phone = $request->phone;
        }
        if ($request->filled('address')) {
            $Developer->address = $request->address;
        }
        if ($request->filled('DeveloperOpinion')) {
            $Developer->DeveloperOpinion = $request->DeveloperOpinion;
        }
        if ($request->filled('zahaOpinion')) {
            $Developer->zahaOpinion = $request->zahaOpinion;
        }
        if ($request->filled('notes')) {
            $Developer->notes = $request->notes;
        }
        if ($request->filled('creationDate')) {
            $Developer->creationDate = $request->creationDate;
        }
        if ($request->hasFile('photo')) {
            if ($Developer->photo) {
                Storage::disk('public')->delete($Developer->photo);
            }
            $photoPath = $request->file('photo')->store('Developer', 'public');
            $Developer->photo = $photoPath;
        }
        $Developer->save();
        return response()->json([
            'data' => new DeveloperResource($Developer),
            'message' => "Update Developer By Id Successfully."
        ]);
    }

    public function destroy(string $id)
    {
        return $this->destroyModel(Developer::class, DeveloperResource::class, $id);
    }

    public function showDeleted()
    {
        $this->authorize('manage_users');
        $Developers = Developer::onlyTrashed()->get();
        return response()->json([
            'data' => DeveloperResource::collection($Developers),
            'message' => "Show Deleted Developers Successfully."
        ]);
    }

    public function restore(string $id)
    {
        $this->authorize('manage_users');
        $Developer = Developer::withTrashed()->where('id', $id)->first();
        if (!$Developer) {
            return response()->json([
                'message' => "Developer not found."
            ], 404);
        }
        $Developer->restore();
        return response()->json([
            'data' => new DeveloperResource($Developer),
            'message' => "Restore Developer By Id Successfully."
        ]);
    }

    public function forceDelete(string $id)
    {
        return $this->forceDeleteModel(Developer::class, $id);
    }



}

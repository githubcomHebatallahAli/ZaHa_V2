<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FundRequest;
use App\Http\Resources\Admin\FundResource;
use App\Models\Fund;
use App\Traits\ManagesModelsTrait;

class FundController extends Controller
{
        use ManagesModelsTrait;

    public function showAll()
    {
        $this->authorize('manage_users');
        $Funds = Fund::get();
        return response()->json([
            'data' => $Funds->map(function ($Fund) {
                return [
                    'id' => $Fund->id,
                    'name' => $Fund->name,
                    'address' => $Fund->address,
                ];
            }),
            'message' => "Show All Funds Successfully."
        ]);
    }

    public function create(FundRequest $request)
    {
        $this->authorize('manage_users');
        $Fund = Fund::create([
            'funder' => $request->funder,
            'amount' => $request->amount,
            'notes' => $request->notes,
            'creationDate' => now()->timezone('Africa/Cairo')->format('Y-m-d H:i:s'),
        ]);
      
        $Fund->save();
        return response()->json([
            'data' => new FundResource($Fund),
            'message' => "Fund Created Successfully."
        ]);
    }

    public function edit(string $id)
    {
        $this->authorize('manage_users');
        $Fund = Fund::find($id);
        if (!$Fund) {
            return response()->json([
                'message' => "Fund not found."
            ], 404);
        }
        return response()->json([
            'data' => new FundResource($Fund),
            'message' => "Edit Fund By ID Successfully."
        ]);
    }

    public function update(FundRequest $request, string $id)
    {
        $this->authorize('manage_users');
        $Fund = Fund::findOrFail($id);
        if (!$Fund) {
            return response()->json([
                'message' => "Fund not found."
            ], 404);
        }
        if ($request->filled('funder')) {
            $Fund->funder = $request->funder;
        }
        if ($request->filled('amount')) {
            $Fund->amount = $request->amount;
        }

        if ($request->filled('notes')) {
            $Fund->notes = $request->notes;
        }
        if ($request->filled('creationDate')) {
            $Fund->creationDate = $request->creationDate;
        }
     
        $Fund->save();
        return response()->json([
            'data' => new FundResource($Fund),
            'message' => "Update Fund By Id Successfully."
        ]);
    }

    public function destroy(string $id)
    {
        return $this->destroyModel(Fund::class, FundResource::class, $id);
    }

    public function showDeleted()
    {
        $this->authorize('manage_users');
        $Funds = Fund::onlyTrashed()->get();
        return response()->json([
            'data' => FundResource::collection($Funds),
            'message' => "Show Deleted Funds Successfully."
        ]);
    }

    public function restore(string $id)
    {
        $this->authorize('manage_users');
        $Fund = Fund::withTrashed()->where('id', $id)->first();
        if (!$Fund) {
            return response()->json([
                'message' => "Fund not found."
            ], 404);
        }
        $Fund->restore();
        return response()->json([
            'data' => new FundResource($Fund),
            'message' => "Restore Fund By Id Successfully."
        ]);
    }

    public function forceDelete(string $id)
    {
        return $this->forceDeleteModel(Fund::class, $id);
    }
}

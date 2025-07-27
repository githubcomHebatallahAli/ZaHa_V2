<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Traits\ManagesModelsTrait;
use App\Http\Requests\Admin\ClientRequest;
use App\Http\Resources\Admin\ClientResource;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    use ManagesModelsTrait;

    public function showAll()
    {
        $this->authorize('manage_users');
        $clients = Client::get();
        return response()->json([
            'data' => $clients->map(function ($client) {
                return [
                    'id' => $client->id,
                    'name' => $client->name,
                    'address' => $client->address,
                ];
            }),
            'message' => "Show All Clients Successfully."
        ]);
    }

public function showAllWithPaginate(Request $request)
{
    $this->authorize('manage_users');

    $searchTerm = $request->input('search', '');

    $clients = Client::where('name', 'like', '%' . $searchTerm . '%')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return response()->json([
        'data' => $clients->map(function ($client) {
            return [
                'id' => $client->id,
                'name' => $client->name,
                'address' => $client->address,
            ];
        }),
        'pagination' => [
            'total' => $clients->total(),
            'count' => $clients->count(),
            'per_page' => $clients->perPage(),
            'current_page' => $clients->currentPage(),
            'total_pages' => $clients->lastPage(),
            'next_page_url' => $clients->nextPageUrl(),
            'prev_page_url' => $clients->previousPageUrl(),
        ],
        'message' => "Show All Clients."
    ]);
}


    public function create(ClientRequest $request)
    {
        $this->authorize('manage_users');
        $client = Client::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'clientOpinion' => $request->clientOpinion,
            'zahaOpinion' => $request->zahaOpinion,
            'notes' => $request->notes,
            'creationDate' => now()->timezone('Africa/Cairo')->format('Y-m-d H:i:s'),
        ]);
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('Client', 'public');
            $client->photo = $photoPath;
        }
        $client->save();
        return response()->json([
            'data' => new ClientResource($client),
            'message' => "Client Created Successfully."
        ]);
    }

    public function edit(string $id)
    {
        $this->authorize('manage_users');
        $client = Client::find($id);
        if (!$client) {
            return response()->json([
                'message' => "Client not found."
            ], 404);
        }
        return response()->json([
            'data' => new ClientResource($client),
            'message' => "Edit Client By ID Successfully."
        ]);
    }

    public function update(ClientRequest $request, string $id)
    {
        $this->authorize('manage_users');
        $client = Client::findOrFail($id);
        if (!$client) {
            return response()->json([
                'message' => "Client not found."
            ], 404);
        }
        if ($request->filled('name')) {
            $client->name = $request->name;
        }
        if ($request->filled('phone')) {
            $client->phone = $request->phone;
        }
        if ($request->filled('address')) {
            $client->address = $request->address;
        }
        if ($request->filled('clientOpinion')) {
            $client->clientOpinion = $request->clientOpinion;
        }
        if ($request->filled('zahaOpinion')) {
            $client->zahaOpinion = $request->zahaOpinion;
        }
        if ($request->filled('notes')) {
            $client->notes = $request->notes;
        }
        if ($request->filled('creationDate')) {
            $client->creationDate = $request->creationDate;
        }
        if ($request->hasFile('photo')) {
            if ($client->photo) {
                Storage::disk('public')->delete($client->photo);
            }
            $photoPath = $request->file('photo')->store('Client', 'public');
            $client->photo = $photoPath;
        }
        $client->save();
        return response()->json([
            'data' => new ClientResource($client),
            'message' => "Update Client By Id Successfully."
        ]);
    }

    public function destroy(string $id)
    {
        return $this->destroyModel(Client::class, ClientResource::class, $id);
    }

    public function showDeleted()
    {
        $this->authorize('manage_users');
        $clients = Client::onlyTrashed()->get();
        return response()->json([
            'data' => ClientResource::collection($clients),
            'message' => "Show Deleted Clients Successfully."
        ]);
    }

    public function restore(string $id)
    {
        $this->authorize('manage_users');
        $client = Client::withTrashed()->where('id', $id)->first();
        if (!$client) {
            return response()->json([
                'message' => "Client not found."
            ], 404);
        }
        $client->restore();
        return response()->json([
            'data' => new ClientResource($client),
            'message' => "Restore Client By Id Successfully."
        ]);
    }

    public function forceDelete(string $id)
    {
        return $this->forceDeleteModel(Client::class, $id);
    }

    public function active(string $id)
    {
        $this->authorize('manage_users');
        $client = Client::findOrFail($id);
        if (!$client) {
            return response()->json([
                'message' => "Client not found."
            ], 404);
        }
        $client->update(['status' => 'active']);
        return response()->json([
            'data' => new ClientResource($client),
            'message' => 'Client has been active.'
        ]);
    }

    public function notActive(string $id)
    {
        $this->authorize('manage_users');
        $client = Client::findOrFail($id);
        if (!$client) {
            return response()->json([
                'message' => "Client not found."
            ], 404);
        }
        $client->update(['status' => 'notActive']);
        return response()->json([
            'data' => new ClientResource($client),
            'message' => 'Client has been notActive.'
        ]);
    }
}

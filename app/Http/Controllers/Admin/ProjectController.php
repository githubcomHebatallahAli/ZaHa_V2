<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\Admin\ProjectRequest;
use App\Http\Resources\Admin\ProjectResource;

class ProjectController extends Controller
{
    public function showAll()
    {
        $this->authorize('manage_users');
        $projects = Project::with('client')->get();
        return response()->json([
            'data' => ProjectResource::collection($projects),
            'message' => "Show All Projects Successfully."
        ]);
    }

    public function create(ProjectRequest $request)
    {
        $this->authorize('manage_users');
        $project = Project::create([
            'name' => $request->name,
            'client_id' => $request->client_id,
            'cost' => $request->cost,
            'projectType' => $request->projectType,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'hostName' => $request->hostName,
            'hostCost' => $request->hostCost,
            'buyHostDate' => $request->buyHostDate,
            'renewalHostDate' => $request->renewalHostDate,
            'domainName' => $request->domainName,
            'domainCost' => $request->domainCost,
            'buyDomainDate' => $request->buyDomainDate,
            'renewalDomainDate' => $request->renewalDomainDate,
            'reason' => $request->reason,
            'amount' => $request->amount,
            'creationDate' =>now()->timezone('Africa/Cairo')->format('Y-m-d H:i:s'),
        ]);
        $project->load('client');
        return response()->json([
            'data' => new ProjectResource($project),
            'message' => "Project Created Successfully."
        ]);
    }

    public function edit(string $id)
    {
        $this->authorize('manage_users');
        $project = Project::with('client')->find($id);
        if (!$project) {
            return response()->json([
                'message' => "Project not found."
            ], 404);
        }
        return response()->json([
            'data' => new ProjectResource($project),
            'message' => "Edit Project By ID Successfully."
        ]);
    }

    public function update(ProjectRequest $request, string $id)
    {
        $this->authorize('manage_users');
        $project = Project::findOrFail($id);
        if (!$project) {
            return response()->json([
                'message' => "Project not found."
            ], 404);
        }
        if ($request->filled('name')) {
            $project->name = $request->name;
        }
        if ($request->filled('client_id')) {
            $project->client_id = $request->client_id;
        }
        if ($request->filled('cost')) {
            $project->cost = $request->cost;
        }
        if ($request->filled('projectType')) {
            $project->projectType = $request->projectType;
        }
        if ($request->filled('startDate')) {
            $project->startDate = $request->startDate;
        }
        if ($request->filled('endDate')) {
            $project->endDate = $request->endDate;
        }
        if ($request->filled('hostName')) {
            $project->hostName = $request->hostName;
        }
        if ($request->filled('hostCost')) {
            $project->hostCost = $request->hostCost;
        }
        if ($request->filled('buyHostDate')) {
            $project->buyHostDate = $request->buyHostDate;
        }
        if ($request->filled('renewalHostDate')) {
            $project->renewalHostDate = $request->renewalHostDate;
        }
        if ($request->filled('domainName')) {
            $project->domainName = $request->domainName;
        }
        if ($request->filled('domainCost')) {
            $project->domainCost = $request->domainCost;
        }
        if ($request->filled('buyDomainDate')) {
            $project->buyDomainDate = $request->buyDomainDate;
        }
        if ($request->filled('renewalDomainDate')) {
            $project->renewalDomainDate = $request->renewalDomainDate;
        }
        if ($request->filled('reason')) {
            $project->reason = $request->reason;
        }
        if ($request->filled('amount')) {
            $project->amount = $request->amount;
        }
        if ($request->filled('creationDate')) {
            $project->creationDate = $request->creationDate;
        }
        $project->save();
        $project->load('client');
        return response()->json([
            'data' => new ProjectResource($project),
            'message' => "Update Project By Id Successfully."
        ]);
    }

    public function destroy(string $id)
    {
        return $this->destroyModel(Project::class, ProjectResource::class, $id);
    }

    public function showDeleted()
    {
        $this->authorize('manage_users');
        $projects = Project::onlyTrashed()->with('client')->get();
        return response()->json([
            'data' => ProjectResource::collection($projects),
            'message' => "Show Deleted Projects Successfully."
        ]);
    }

    public function restore(string $id)
    {
        $this->authorize('manage_users');
        $project = Project::withTrashed()->where('id', $id)->first();
        if (!$project) {
            return response()->json([
                'message' => "Project not found."
            ], 404);
        }
        $project->restore();
        $project->load('client');
        return response()->json([
            'data' => new ProjectResource($project),
            'message' => "Restore Project By Id Successfully."
        ]);
    }

    public function forceDelete(string $id)
    {
        return $this->forceDeleteModel(Project::class, $id);
    }
}

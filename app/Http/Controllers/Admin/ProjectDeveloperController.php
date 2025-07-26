<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Http\Resources\Admin\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectDeveloperController extends Controller
{

    public function attachDevelopers(Request $request, $projectId): JsonResponse
    {
        $request->validate([
            'developers' => 'required|array',
            'developers.*.id' => 'required|exists:developers,id',
            'developers.*.profit' => 'required|numeric',
        ]);

        $project = Project::findOrFail($projectId);

        $syncData = [];
        foreach ($request->developers as $developer) {
            $syncData[$developer['id']] = ['profit' => $developer['profit']];
        }

        $project->developers()->syncWithoutDetaching($syncData);

        $project->load('developers');

        return response()->json([

            'message' => 'Developers attached successfully.',
            'data' => new ProjectResource($project)
        ]);
    }

    /**
     * Detach one or many developers from a project.
     */
    public function detachDevelopers(Request $request, $projectId): JsonResponse
    {
        $request->validate([
            'developers' => 'required|array',
            'developers.*' => 'required|exists:developers,id',
        ]);

        $project = Project::findOrFail($projectId);

        $developerIds = $request->developers;

        $project->developers()->detach($developerIds);

        $project->load('developers');

        return response()->json([
            'message' => 'Developers detached successfully.',
            'data' => new ProjectResource($project)
        ]);
    }
    /**
     * Display the specified project with its developers.
     */
    public function show($id): JsonResponse
    {
        $project = Project::with('developers')->findOrFail($id);

        return response()->json([
            'message' => 'Project retrieved successfully.',
            'data' => new ProjectResource($project)
        ]);
    }




}

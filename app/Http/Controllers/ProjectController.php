<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(): AnonymousResourceCollection|JsonResponse
    {
        try {
            $projects = Project::with([
                'tasks' => function ($q) {
                    return $q->with(['subtasks']);
                }
            ])->where('user_id', Auth::id())->paginate(15);

            return ProjectResource::collection($projects);
        } catch (\Throwable $e) {
            return response()->json([
                'error'   => 'Could not fetch projects',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(ProjectRequest $request): ProjectResource|JsonResponse
    {
        $data = $request->validated();
        try {
            $project = $this->projectService->createProject(Auth::user(), $data);

            return new ProjectResource($project);
        } catch (\Throwable $e) {
            return response()->json([
                'error'   => 'Could not create project',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(ProjectRequest $request, Project $project): ProjectResource|JsonResponse
    {
        $data = $request->validated();
        if ($project->user_id !== Auth::id()) {
            return response()->json([
                'error' => 'Not Permitted!'
            ], 403);
        }

        try {
            $project = $this->projectService->updateProject($project, $data);

            return new ProjectResource($project);
        } catch (\Throwable $e) {
            return response()->json([
                'error'   => 'Could not update project',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Project $project): JsonResponse
    {
        if ($project->user_id !== Auth::id()) {
            return response()->json([
                'error' => 'Not Permitted!'
            ], 403);
        }

        try {
            $this->projectService->deleteProject($project);

            return response()->json([
                'message' => 'Project deleted successfully'
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'error'   => 'Could not delete project',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function report($projectId): JsonResponse
    {
        try {
            $project = Project::with([
                'tasks' => function ($q) {
                    return $q->with(['subtasks']);
                }
            ])->findOrFail($projectId);

            if ($project->user_id !== auth()->id()) {
                return response()->json([
                    'message' => 'Not Permitted!'
                ], 401);
            }

            $report = $this->projectService->generateReport($project);

            return response()->json($report);
        } catch (\Throwable $e) {
            return response()->json([
                'error'   => 'Could not generate report',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}


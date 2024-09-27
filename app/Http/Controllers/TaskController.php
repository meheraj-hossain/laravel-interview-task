<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Requests\UploadTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Project $project): AnonymousResourceCollection|JsonResponse
    {
        if ($project->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Not Permitted!'
            ], 401);
        }

        try {
            return TaskResource::collection($project->tasks);
        } catch (\Throwable $e) {
            return response()->json([
                'error'   => 'Could not fetch tasks',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Project $project, TaskRequest $request): TaskResource|JsonResponse
    {
        if ($project->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Not Permitted!'
            ], 401);
        }

        try {
            $task = $this->taskService->createTask($project, $request->validated());

            return new TaskResource($task);
        } catch (\Throwable $e) {
            return response()->json([
                'error'   => 'Could not create task',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(TaskRequest $request, Project $project, Task $task): TaskResource|JsonResponse
    {
        if ($project->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Not Permitted!'
            ], 401);
        }

        if ($task->project_id !== $project->id) {
            return response()->json([
                'error' => 'Task does not belong to this project'
            ], 403);
        }

        try {
            $task = $this->taskService->updateTask($task, $request->validated());

            return new TaskResource($task);
        } catch (\Throwable $e) {
            return response()->json([
                'error'   => 'Could not update task',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Project $project, Task $task): JsonResponse
    {
        if ($project->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Not Permitted!'
            ], 401);
        }

        if ($task->project_id !== $project->id) {
            return response()->json([
                'error' => 'Task does not belong to this project'
            ], 403);
        }

        try {
            $this->taskService->deleteTask($task);

            return response()->json([
                'message' => 'Task deleted successfully'
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Could not delete task', 'message' => $e->getMessage()
            ], 500);
        }
    }

    public function uploadTasks(UploadTaskRequest $request, Project $project): JsonResponse
    {
        if ($project->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Not Permitted!'
            ], 401);
        }

        try {
            $result = $this->taskService->uploadTasks($project, $request->file('tasks_file'));

            if (!empty($result['errors'])) {
                return response()->json([
                    'message' => 'File processed with errors.',
                    'errors'  => $result['errors'],
                ], 422);
            }

            return response()->json([
                'message' => 'Tasks and subtasks successfully uploaded and created.',
                'data'    => $result['tasks'],
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'error'   => 'Could not upload tasks',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}


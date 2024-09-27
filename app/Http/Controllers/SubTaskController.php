<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubTaskRequest;
use App\Http\Resources\SubTaskResource;
use App\Models\Project;
use App\Models\SubTask;
use App\Models\Task;
use App\Services\SubTaskService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;
use Throwable;

class SubTaskController extends Controller
{
    protected $subtaskService;

    public function __construct(SubTaskService $subtaskService)
    {
        $this->subtaskService = $subtaskService;
    }

    public function index(Task $task): AnonymousResourceCollection|JsonResponse
    {
        if ($task->project->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Not Permitted!'
            ], 401);
        }

        try {
            return SubTaskResource::collection($task->subtasks);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Could not fetch subtasks',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function store(SubTaskRequest $request, Task $task): SubTaskResource|JsonResponse
    {
        if ($task->project->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Not Permitted!'
            ], 401);
        }

        try {
            $subtask = $this->subtaskService->createSubTask($task, $request->validated());

            return new SubTaskResource($subtask);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Could not create subtask',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        // Show logic can be added here
    }

    public function update(SubTaskRequest $request, Task $task, SubTask $subtask): SubTaskResource|JsonResponse
    {
        if ($task->project->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Not Permitted!'
            ], 401);
        }

        if ($subtask->task_id !== $task->id) {
            return response()->json([
                'error' => 'SubTask does not belong to this task'
            ], 403);
        }

        try {
            $subtask = $this->subtaskService->updateSubTask($subtask, $request->validated());

            return new SubTaskResource($subtask);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Could not update subtask',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Task $task, SubTask $subtask): JsonResponse
    {
        if ($task->project->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Not Permitted!'
            ], 401);
        }

        if ($subtask->task_id !== $task->id) {
            return response()->json([
                'error' => 'SubTask does not belong to this task'
            ], 403);
        }
        try {
            $this->subtaskService->deleteSubTask($subtask);

            return response()->json([
                'message' => 'Subtask deleted successfully'
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Could not delete subtask',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}

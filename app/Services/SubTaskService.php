<?php

namespace App\Services;

use App\Models\SubTask;

class SubTaskService
{
    public function createSubTask($task, array $data): SubTask
    {
        try {
            return $task->subtasks()->create($data);
        } catch (\Throwable $e) {
            throw new \Exception('Could not create subtask: ' . $e->getMessage());
        }
    }

    public function updateSubTask(SubTask $subtask, array $data): SubTask
    {
        try {
            $subtask->update($data);

            return $subtask;
        } catch (\Throwable $e) {
            throw new \Exception('Could not update subtask: ' . $e->getMessage());
        }
    }

    public function deleteSubTask(SubTask $subtask): void
    {
        try {
            $subtask->delete();
        } catch (\Throwable $e) {
            throw new \Exception('Could not delete subtask: ' . $e->getMessage());
        }
    }
}


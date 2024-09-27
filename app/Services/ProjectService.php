<?php

namespace App\Services;

use App\Models\Project;

class ProjectService
{
    public function createProject($user, array $data): Project
    {
        try {
            return $user->projects()->create($data);
        } catch (\Throwable $e) {
            throw new \Exception('Could not create project: ' . $e->getMessage());
        }
    }

    public function updateProject(Project $project, array $data): Project
    {
        try {
            $project->update($data);

            return $project;
        } catch (\Throwable $e) {
            throw new \Exception('Could not update project: ' . $e->getMessage());
        }
    }

    public function deleteProject(Project $project): void
    {
        try {
            $project->delete();
        } catch (\Throwable $e) {
            throw new \Exception('Could not delete project: ' . $e->getMessage());
        }
    }

    public function generateReport($project): array
    {
        try {
            return [
                'project_name' => $project->name,
                'tasks'        => $project->tasks->map(function ($task) {
                    return [
                        'task_name' => $task->name,
                        'subtasks'  => $task->subtasks->map(function ($subtask) {
                            return [
                                'subtask_name' => $subtask->name,
                            ];
                        })
                    ];
                })
            ];
        } catch (\Throwable $e) {
            throw new \Exception('Could not generate report: ' . $e->getMessage());
        }
    }
}


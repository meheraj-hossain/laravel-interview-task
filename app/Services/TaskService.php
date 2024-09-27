<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Task;
use League\Csv\Reader;
use Illuminate\Support\Facades\Validator;

class TaskService
{
    public function createTask($project, array $data): Task
    {
        try {
            return $project->tasks()->create($data);
        } catch (\Exception $e) {
            throw new \Exception('Could not create task: ' . $e->getMessage());
        }
    }

    public function updateTask(Task $task, array $data): Task
    {
        try {
            $task->update($data);

            return $task;
        } catch (\Exception $e) {
            throw new \Exception('Could not update task: ' . $e->getMessage());
        }
    }

    public function deleteTask(Task $task): void
    {
        try {
            $task->delete();
        } catch (\Exception $e) {
            throw new \Exception('Could not delete task: ' . $e->getMessage());
        }
    }

    public function uploadTasks(Project $project, $file): array
    {
        $errors  = [];
        $taskMap = [];

        try {
            $csv = Reader::createFromPath($file->getPathname(), 'r');
            $csv->setHeaderOffset(0);
            $records = $csv->getRecords();

            foreach ($records as $index => $record) {
                $validator = Validator::make($record, [
                    'task_name'    => 'required|string|max:255',
                        'subtask_name' => 'nullable|string|max:255',
                ]);

                if ($validator->fails()) {
                    $errors[$index] = $validator->errors()->all();
                    continue;
                }

                if (!array_key_exists($record['task_name'], $taskMap)) {
                    $task                          = $project->tasks()->firstOrCreate(['name' => $record['task_name']]);
                    $taskMap[$record['task_name']] = ['task' => $task, 'subtasks' => []];
                }

                $taskData = $taskMap[$record['task_name']];

                if (!empty($record['subtask_name'])) {
                    $subtask                                     = $taskData['task']->subtasks()->firstOrCreate(['name' => $record['subtask_name']]);
                    $taskMap[$record['task_name']]['subtasks'][] = $subtask;
                }
            }
        } catch (\Exception $e) {
            throw new \Exception('Could not upload tasks: ' . $e->getMessage());
        }

        return ['tasks' => array_values($taskMap), 'Errors' => $errors];
    }
}


<?php

namespace App\Repositories;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Project;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\CursorPaginator;

class EloquentTaskRepository implements TaskRepositoryInterface
{
    public function listForProject(Project $project, array $filters): CursorPaginator
    {
        return $project->tasks()
            ->select(['id', 'project_id', 'title', 'description', 'status', 'priority', 'due_date', 'created_at', 'updated_at'])
            ->when(
                isset($filters['status']),
                fn ($q) => $q->byStatus(TaskStatus::from($filters['status']))
            )
            ->when(
                isset($filters['priority']),
                fn ($q) => $q->byPriority(TaskPriority::from($filters['priority']))
            )
            ->when(
                !empty($filters['overdue']),
                fn ($q) => $q->overdue()
            )
            ->when(
                isset($filters['due_date']),
                fn ($q) => $q->whereDate('due_date', $filters['due_date'])
            )
            ->cursorPaginate(20);
    }

    public function create(Project $project, array $data): Task
    {
        return $project->tasks()->create($data);
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);

        return $task;
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }
}

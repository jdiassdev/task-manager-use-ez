<?php

namespace App\Repositories;

use App\Data\Tasks\CreateTaskData;
use App\Data\Tasks\TaskFiltersData;
use App\Data\Tasks\UpdateTaskData;
use App\Models\Project;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\CursorPaginator;

class EloquentTaskRepository implements TaskRepositoryInterface
{
    public function listForProject(Project $project, TaskFiltersData $filters): CursorPaginator
    {
        return $project->tasks()
            ->select(['id', 'project_id', 'title', 'description', 'status', 'priority', 'due_date', 'created_at', 'updated_at'])
            ->when($filters->status,   fn ($q) => $q->byStatus($filters->status))
            ->when($filters->priority, fn ($q) => $q->byPriority($filters->priority))
            ->when($filters->overdue,  fn ($q) => $q->overdue())
            ->when($filters->due_date, fn ($q) => $q->whereDate('due_date', $filters->due_date))
            ->cursorPaginate(20);
    }

    public function create(Project $project, CreateTaskData $data): Task
    {
        return $project->tasks()->create($data->toArray());
    }

    public function update(Task $task, UpdateTaskData $data): Task
    {
        $task->update($data->toArray());

        return $task;
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }
}

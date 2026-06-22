<?php

namespace App\Repositories\Contracts;

use App\Data\Tasks\CreateTaskData;
use App\Data\Tasks\TaskFiltersData;
use App\Data\Tasks\UpdateTaskData;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface TaskRepositoryInterface
{
    public function listForProject(Project $project, TaskFiltersData $filters): CursorPaginator;
    public function create(Project $project, CreateTaskData $data): Task;
    public function update(Task $task, UpdateTaskData $data): Task;
    public function delete(Task $task): void;
}

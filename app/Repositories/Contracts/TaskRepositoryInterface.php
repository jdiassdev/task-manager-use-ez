<?php

namespace App\Repositories\Contracts;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface TaskRepositoryInterface
{
    public function listForProject(Project $project, array $filters): CursorPaginator;
    public function create(Project $project, array $data): Task;
    public function update(Task $task, array $data): Task;
    public function delete(Task $task): void;
}

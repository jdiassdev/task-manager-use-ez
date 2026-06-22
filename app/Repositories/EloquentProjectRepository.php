<?php

namespace App\Repositories;

use App\Data\Projects\CreateProjectData;
use App\Data\Projects\UpdateProjectData;
use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentProjectRepository implements ProjectRepositoryInterface
{
    public function all(): Collection
    {
        return Project::query()
            ->select(['id', 'name', 'description', 'status'])
            ->withCount('tasks')
            ->get();
    }

    public function create(CreateProjectData $data): Project
    {
        return Project::create($data->toArray());
    }

    public function update(Project $project, UpdateProjectData $data): Project
    {
        $project->update($data->toArray());

        return $project;
    }
}

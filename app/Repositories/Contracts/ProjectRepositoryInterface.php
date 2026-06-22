<?php

namespace App\Repositories\Contracts;

use App\Data\Projects\CreateProjectData;
use App\Data\Projects\UpdateProjectData;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
    public function all(): Collection;
    public function create(CreateProjectData $data): Project;
    public function update(Project $project, UpdateProjectData $data): Project;
}

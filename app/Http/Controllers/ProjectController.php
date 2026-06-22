<?php

namespace App\Http\Controllers;

use App\Data\Projects\CreateProjectData;
use App\Data\Projects\UpdateProjectData;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function __construct(private ProjectRepositoryInterface $repository) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Projetos listados com sucesso.',
            'code'    => 200,
            'data'    => ProjectResource::collection($this->repository->all()),
        ], 200);
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = $this->repository->create(CreateProjectData::fromRequest($request));

        return response()->json([
            'message' => 'Projeto criado com sucesso.',
            'code'    => 201,
            'data'    => (new ProjectResource($project->loadCount('tasks')))->only(['id', 'name', 'description', 'status', 'tasks_count']),
        ], 201);
    }

    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $project = $this->repository->update($project, UpdateProjectData::fromRequest($request));

        return response()->json([
            'message' => 'Projeto atualizado com sucesso.',
            'code'    => 200,
            'data'    => (new ProjectResource($project->loadCount('tasks')))->only(['id', 'name', 'description', 'status', 'tasks_count']),
        ], 200);
    }
}

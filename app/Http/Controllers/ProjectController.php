<?php

namespace App\Http\Controllers;

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
        $projects = $this->repository->all();

        return response()->json([
            'message' => 'Projetos listados com sucesso.',
            'code'    => 200,
            'data'    => ProjectResource::collection($projects),
        ], 200);
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = $this->repository->create($request->validated());

        return response()->json([
            'message' => 'Projeto criado com sucesso.',
            'code'    => 201,
            'data'    => (new ProjectResource($project->loadCount('tasks')))->only(['id', 'name', 'description', 'status', 'tasks_count']),
        ], 201);
    }

    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $project = $this->repository->update($project, $request->validated());

        return response()->json([
            'message' => 'Projeto atualizado com sucesso.',
            'code'    => 200,
            'data'    => (new ProjectResource($project->loadCount('tasks')))->only(['id', 'name', 'description', 'status', 'tasks_count']),
        ], 200);
    }
}

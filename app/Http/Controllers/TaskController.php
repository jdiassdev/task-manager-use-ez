<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct(private TaskRepositoryInterface $repository) {}

    public function index(FilterTaskRequest $request, Project $project): JsonResponse
    {
        $tasks = $this->repository->listForProject($project, $request->validated());

        $paginated = TaskResource::collection($tasks)->response()->getData(true);

        return response()->json([
            'message' => 'Tarefas listadas com sucesso.',
            'code'    => 200,
            'data'    => $paginated['data'],
            'meta'    => $paginated['meta'] ?? null,
            'links'   => $paginated['links'] ?? null,
        ], 200);
    }

    public function store(StoreTaskRequest $request, Project $project): JsonResponse
    {
        $task = $this->repository->create($project, $request->validated());

        return response()->json([
            'message' => 'Tarefa criada com sucesso.',
            'code'    => 201,
            'data'    => (new TaskResource($task))->only(['id', 'project_id', 'title', 'description', 'status', 'priority', 'due_date', 'is_overdue']),
        ], 201);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $task = $this->repository->update($task, $request->validated());

        return response()->json([
            'message' => 'Tarefa atualizada com sucesso.',
            'code'    => 200,
            'data'    => (new TaskResource($task))->only(['id', 'project_id', 'title', 'description', 'status', 'priority', 'due_date', 'is_overdue']),
        ], 200);
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->repository->delete($task);

        return response()->json(null, 204);
    }
}

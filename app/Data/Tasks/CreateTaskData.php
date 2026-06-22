<?php

namespace App\Data\Tasks;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Http\Requests\StoreTaskRequest;

final readonly class CreateTaskData
{
    public function __construct(
        public string $title,
        public ?string $description,
        public TaskStatus $status,
        public TaskPriority $priority,
        public ?string $due_date,
    ) {}

    public static function fromRequest(StoreTaskRequest $request): self
    {
        return new self(
            title: $request->validated('title'),
            description: $request->validated('description'),
            status: TaskStatus::from($request->validated('status') ?? TaskStatus::Todo->value),
            priority: TaskPriority::from($request->validated('priority') ?? TaskPriority::Medium->value),
            due_date: $request->validated('due_date'),
        );
    }

    public function toArray(): array
    {
        return [
            'title'       => $this->title,
            'description' => $this->description,
            'status'      => $this->status->value,
            'priority'    => $this->priority->value,
            'due_date'    => $this->due_date,
        ];
    }
}

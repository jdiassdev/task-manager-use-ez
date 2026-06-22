<?php

namespace App\Data\Tasks;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Http\Requests\UpdateTaskRequest;

final readonly class UpdateTaskData
{
    public function __construct(
        public ?TaskStatus $status,
        public ?TaskPriority $priority,
    ) {}

    public static function fromRequest(UpdateTaskRequest $request): self
    {
        return new self(
            status: $request->has('status') ? TaskStatus::from($request->validated('status')) : null,
            priority: $request->has('priority') ? TaskPriority::from($request->validated('priority')) : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'status'   => $this->status?->value,
            'priority' => $this->priority?->value,
        ], fn ($v) => $v !== null);
    }
}

<?php

namespace App\Data\Tasks;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Http\Requests\FilterTaskRequest;

final readonly class TaskFiltersData
{
    public function __construct(
        public ?TaskStatus $status = null,
        public ?TaskPriority $priority = null,
        public bool $overdue = false,
        public ?string $due_date = null,
    ) {}

    public static function fromRequest(FilterTaskRequest $request): self
    {
        return new self(
            status: $request->has('status') ? TaskStatus::from($request->validated('status')) : null,
            priority: $request->has('priority') ? TaskPriority::from($request->validated('priority')) : null,
            overdue: $request->boolean('overdue'),
            due_date: $request->validated('due_date'),
        );
    }
}

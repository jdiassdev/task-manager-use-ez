<?php

namespace App\Data\Projects;

use App\Enums\ProjectStatus;
use App\Http\Requests\UpdateProjectRequest;

final readonly class UpdateProjectData
{
    public function __construct(
        public ProjectStatus $status,
    ) {}

    public static function fromRequest(UpdateProjectRequest $request): self
    {
        return new self(
            status: ProjectStatus::from($request->validated('status')),
        );
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status->value,
        ];
    }
}

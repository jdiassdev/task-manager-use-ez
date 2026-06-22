<?php

namespace App\Data\Projects;

use App\Enums\ProjectStatus;
use App\Http\Requests\StoreProjectRequest;

final readonly class CreateProjectData
{
    public function __construct(
        public string $name,
        public ?string $description,
        public ProjectStatus $status,
    ) {}

    public static function fromRequest(StoreProjectRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            description: $request->validated('description'),
            status: ProjectStatus::from($request->validated('status') ?? ProjectStatus::Active->value),
        );
    }

    public function toArray(): array
    {
        return [
            'name'        => $this->name,
            'description' => $this->description,
            'status'      => $this->status->value,
        ];
    }
}

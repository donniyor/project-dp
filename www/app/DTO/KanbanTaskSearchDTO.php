<?php

declare(strict_types=1);

namespace app\DTO;

final class KanbanTaskSearchDTO implements Arrayable
{
    public function __construct(
        public ?array $projectIds,
        public ?array $assignedToIds,
    ) {
    }

    public static function fromArray(array $params): self
    {
        return new self(
            !empty($params['project_id'])
                ? array_map('intval', $params['project_id'])
                : null,
            !empty($params['assigned_to'])
                ? array_map('intval', $params['assigned_to'])
                : null,
        );
    }

    public function toArray(): array
    {
        return [
            'project_id' => $this->projectIds,
            'assigned_to' => $this->assignedToIds,
        ];
    }
}
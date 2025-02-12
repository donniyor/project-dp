<?php

declare(strict_types=1);

namespace app\DTO;

class TaskSearchDTO implements Arrayable
{
    private ?array $authorIds = null;
    private ?int $status = null;
    private ?array $assignedToIds = null;
    private ?int $projectIds = null;

    public function __construct(
        ?array $authorIds = null,
        ?int $status = null,
        ?array $assignedToIds = null,
        ?int $projectIds = null,
    ) {
        $this->authorIds = $authorIds;
        $this->status = $status;
        $this->assignedToIds = $assignedToIds;
        $this->projectIds = $projectIds;
    }

    public static function fromArray(array $params): static
    {
        return new static(
            !empty($params['author_id'])
                ? array_map('intval', $params['author_id'])
                : null,
            !empty($params['status'])
                ? (int)$params['status']
                : null,
            !empty($params['assigned_to'])
                ? array_map('intval', $params['assigned_to'])
                : null,
            !empty($params['project_id'])
                ? (int)$params['project_id']
                : null,
        );
    }

    public function toArray(): array
    {
        return [
            'author_id' => $this->getAuthorIds(),
            'status' => $this->getStatus(),
            'assigned_to' => $this->getAssignedToIds(),
            'project_id' => $this->getProjectIds(),
        ];
    }

    public function getAuthorIds(): ?array
    {
        return $this->authorIds;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function getAssignedToIds(): ?array
    {
        return $this->assignedToIds;
    }

    public function getProjectIds(): ?int
    {
        return $this->projectIds;
    }
}
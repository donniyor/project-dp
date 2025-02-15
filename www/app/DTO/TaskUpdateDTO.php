<?php

declare(strict_types=1);

namespace app\DTO;

final class TaskUpdateDTO implements Arrayable
{
    private ?string $title = null;
    private ?string $description = null;
    private ?int $projectId = null;
    private ?int $status = null;
    private ?int $assignedTo = null;

    public function __construct(
        ?string $title = null,
        ?string $description = null,
        ?int $projectId = null,
        ?int $status = null,
        ?int $assignedTo = null,
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->projectId = $projectId;
        $this->status = $status;
        $this->assignedTo = $assignedTo;
    }

    public static function fromArray(array $params): self
    {
        return new self(
            empty($params['title']) ? null : $params['title'],
            empty($params['description']) ? null : $params['description'],
            empty($params['project_id']) ? null : (int)$params['project_id'],
            empty($params['status']) ? null : (int)$params['status'],
            empty($params['assigned_to']) ? null : (int)$params['assigned_to'],
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'assigned_to' => $this->getAssignedTo(),
            'project_id' => $this->getProjectId(),
            'status' => $this->getStatus(),
        ];
    }

    public function setTitle(?string $title = null): void
    {
        $this->title = $title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setDescription(?string $description = null): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setProjectId(?int $projectId = null): void
    {
        $this->projectId = $projectId;
    }

    public function getProjectId(): ?int
    {
        return $this->projectId;
    }

    public function setStatus(?int $status = null): void
    {
        $this->status = $status;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setAssignedTo(?int $assignedTo = null): void
    {
        $this->assignedTo = $assignedTo;
    }

    public function getAssignedTo(): ?int
    {
        return $this->assignedTo;
    }
}
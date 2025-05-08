<?php

declare(strict_types=1);

namespace app\DTO;

use app\components\Priority\PriorityEnum;
use app\components\Statuses\StatusesInterface;

class TaskCreateDTO implements Arrayable
{
    private string $title;
    private string $description;
    private int $projectId;
    private int $status;
    private ?int $assignedTo = null;
    private ?int $priority = null;

    public static function fromArray(array $params): static
    {
        $static = (new static())
            ->setTitle((string)($params['title'] ?? null))
            ->setDescription((string)($params['description'] ?? null))
            ->setStatus((int)($params['status'] ?? StatusesInterface::STATUS_TO_DO))
            ->setProjectId((int)($params['project_id'] ?? null))
            ->setPriority((int)($params['priority'] ?? PriorityEnum::LOWEST));

        if (!empty($params['assigned_to'])) {
            $static->setAssignedTo((int)$params['assigned_to']);
        }

        return $static;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'project_id' => $this->getProjectId(),
            'status' => $this->getStatus(),
            'assigned_to' => $this->getAssignedTo(),
            'priority' => $this->getPriority(),
        ];
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setProjectId(int $projectId): self
    {
        $this->projectId = $projectId;
        return $this;
    }

    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setAssignedTo(?int $assignedTo): self
    {
        $this->assignedTo = $assignedTo;
        return $this;
    }

    public function getAssignedTo(): ?int
    {
        return $this->assignedTo;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }
}

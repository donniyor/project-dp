<?php

declare(strict_types=1);

namespace app\DTO;

class TaskCreateDTO implements Arrayable
{
    private string $title;
    private string $description;
    private int $projectId;
    private int $authorId;
    private int $status;
    private ?int $assignedTo = null;

    public static function fromArray(array $params): static
    {
        $static = new static();
        $static->setTitle((string)($params['title'] ?? ''));

        return $static;
    }

    public function toArray(): array
    {
        return [
            'title' => '',
            'description' => '',
            'project_id' => '',
            'author_id' => '',
            'status' => '',
            'assigned_to' => '',
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
}

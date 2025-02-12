<?php

declare(strict_types=1);

namespace app\DTO;

use app\components\Statuses\StatusesInterface;

class ProjectCreateDTO implements Arrayable
{
    private string $title;
    private string $description;
    private int $status;

    public function __construct(
        string $title,
        string $description,
        int $status,
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
    }

    public static function fromArray(array $params): static
    {
        return new static(
            (string)($params['title'] ?? ''),
            (string)($params['description'] ?? ''),
            (int)($params['status'] ?? StatusesInterface::STATUS_TO_DO),
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'status' => $this->getStatus(),
        ];
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}
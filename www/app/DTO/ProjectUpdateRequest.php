<?php

declare(strict_types=1);

namespace app\DTO;

use app\components\Statuses\StatusesInterface;

final class ProjectUpdateRequest implements Arrayable
{
    public function __construct(
        readonly public string $title,
        readonly public string $description,
        readonly public int $status,
    ) {
    }

    public static function fromArray(array $params): self
    {
        return new self(
            (string)($params['title'] ?? ''),
            (string)($params['description'] ?? ''),
            (int)($params['status'] ?? StatusesInterface::STATUS_TO_DO),
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }
}
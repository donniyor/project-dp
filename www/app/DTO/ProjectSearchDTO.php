<?php

declare(strict_types=1);

namespace app\DTO;

class ProjectSearchDTO implements Arrayable
{
    private ?array $authorIds = null;
    private ?int $status = null;

    public function __construct(
        ?array $authorIds,
        ?int $status,
    ) {
        $this->authorIds = $authorIds;
        $this->status = $status;
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
        );
    }

    public function toArray(): array
    {
        return [
            'author_id' => $this->getAuthorIds(),
            'status' => $this->getStatus(),
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
}
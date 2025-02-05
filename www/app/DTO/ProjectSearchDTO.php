<?php

declare(strict_types=1);

namespace app\DTO;

class ProjectSearchDTO implements Arrayable
{
    private ?string $title = null;
    private ?array $authorIds = null;
    private ?int $status = null;

    public function __construct(
        ?string $title,
        ?array $authorIds,
        ?int $status,
    ) {
        $this->title = $title;
        $this->authorIds = $authorIds;
        $this->status = $status;
    }

    public static function fromArray(array $params): self
    {
        return new static(
            !empty($params['title'])
                ? (string)$params['title']
                : null,
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
            'title' => $this->getTitle(),
            'author_id' => $this->getAuthorIds(),
            'status' => $this->getStatus(),
        ];
    }

    public function getTitle(): ?string
    {
        return $this->title;
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
<?php

declare(strict_types=1);

namespace app\DTO;

class ProjectSearchDTO implements Arrayable
{
    private ?string $title = null;
    private ?string $authorSearch = null;
    private ?int $status = null;

    public function __construct(
        ?string $title,
        ?string $authorSearch,
        ?int $status,
    ) {
        $this->title = $title;
        $this->authorSearch = $authorSearch;
        $this->status = $status;
    }

    public static function fromArray(array $params): self
    {
        return new static(
            !empty($params['title'])
                ? (string)$params['title']
                : null,
            !empty($params['author_search'])
                ? (string)$params['author_search']
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
            'author_search' => $this->getAuthorSearch(),
            'status' => $this->getStatus(),
        ];
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getAuthorSearch(): ?string
    {
        return $this->authorSearch;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }
}
<?php

declare(strict_types=1);

namespace app\DTO;

final class UserDTO implements Arrayable
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $position,
        public string $department,
    ) {
    }

    public static function fromArray(array $params): self
    {
        return new self(
            $params['first_name'] ?? '',
            $params['last_name'] ?? '',
            $params['position'] ?? '',
            $params['department'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'position' => $this->position,
            'department' => $this->department,
        ];
    }
}
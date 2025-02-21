<?php

declare(strict_types=1);

namespace app\DTO;

final class RegistrationRequest implements Arrayable
{
    public function __construct(
        readonly public string $username,
        readonly public string $password,
    ) {
    }

    public static function fromArray(array $params): self
    {
        return new self(
            $params['username'] ?? '',
            $params['password'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
        ];
    }
}
<?php

declare(strict_types=1);

namespace app\DTO;

interface Arrayable
{
    public static function fromArray(array $params): static;

    public function toArray(): array;
}
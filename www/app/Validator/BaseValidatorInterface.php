<?php

declare(strict_types=1);

namespace app\Validator;

interface BaseValidatorInterface
{
    public const STRING_LENGTH = 255;

    public function validate(array $data): ?array;
}
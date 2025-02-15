<?php

declare(strict_types=1);

namespace app\Validator;

interface BaseValidatorInterface
{
    public function validate(array $data): ?array;
}
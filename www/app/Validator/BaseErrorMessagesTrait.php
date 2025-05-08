<?php

declare(strict_types=1);

namespace app\Validator;

trait BaseErrorMessagesTrait
{
    protected function getMessageForInt(string $title): string
    {
        return sprintf('Поле "%s" должно быть числом', $title);
    }

    protected function getMessageForRequired(string $title): string
    {
        return sprintf('Поле "%s" обязательно для заполнения', $title);
    }

    protected function getMessagesForString(string $title, int $num): string
    {
        return sprintf('Поле "%s" не должно превышать %s символов', $title, $num);
    }
}
<?php

declare(strict_types=1);

namespace app\Validator;

use yii\base\DynamicModel;
use yii\base\InvalidConfigException;

final class TaskCreateValidator implements BaseValidatorInterface
{
    /**
     * @throws InvalidConfigException
     */
    public function validate(array $data): ?array
    {
        $model = DynamicModel::validateData($data, [
            [['title'], 'required', 'message' => 'Поле "Название" обязательно для заполнения'],
            [['project_id'], 'required', 'message' => 'Поле "Проект" обязательно для заполнения'],
            [['description'], 'required', 'message' => 'Поле "Описание" обязательно для заполнения'],
            [['assigned_to'], 'required', 'message' => 'Поле "Ответственный" обязательно для заполнения'],
            [['status'], 'required', 'message' => 'Поле "Статус" обязательно для заполнения'],
            [['author_id'], 'required', 'message' => 'Поле "Автор" обязательно для заполнения'],

            [['title'], 'string', 'max' => 255, 'message' => 'Поле "Название" не должно превышать 255 символов'],
            [['author_id'], 'integer', 'message' => 'Поле "Автор" должно быть числом'],
            [['assigned_to'], 'integer', 'message' => 'Поле "Ответственный" должно быть числом'],
            [['project_id'], 'integer', 'message' => 'Поле "Проект" должно быть числом'],
            [['status'], 'integer', 'message' => 'Поле "Статус" должно быть числом'],
        ]);

        if ($model->hasErrors()) {
            return $model->errors;
        }

        return null;
    }
}
<?php

declare(strict_types=1);

namespace app\Validator;

use yii\base\DynamicModel;
use yii\base\InvalidConfigException;

final class TaskCreateValidator implements BaseValidatorInterface
{
    use BaseErrorMessagesTrait;

    /**
     * @throws InvalidConfigException
     */
    public function validate(array $data): ?array
    {
        $model = DynamicModel::validateData($data, [
            [['title'], 'required', 'message' => $this->getMessageForRequired('Название')],
            [['project_id'], 'required', 'message' => $this->getMessageForRequired('Проект')],
            [['description'], 'required', 'message' => $this->getMessageForRequired('Описание')],
            [['status'], 'required', 'message' => $this->getMessageForRequired('Статус')],
            [['priority'], 'required', 'message' => $this->getMessageForRequired('Приоритет')],
            [['deadline'], 'required', 'message' => $this->getMessageForRequired('Срок')],

            [
                ['title'],
                'string',
                'max' => self::STRING_LENGTH,
                'message' => $this->getMessagesForString('Название', self::STRING_LENGTH),
            ],
            [
                ['deadline'],
                'string',
                'max' => self::STRING_LENGTH,
                'message' => $this->getMessagesForString('Срок', self::STRING_LENGTH),
            ],

            [['assigned_to'], 'integer', 'message' => $this->getMessageForInt('Ответственный')],
            [['project_id'], 'integer', 'message' => $this->getMessageForInt('Проект')],
            [['status'], 'integer', 'message' => $this->getMessageForInt('Статус')],
            [['priority'], 'integer', 'message' => $this->getMessageForInt('Приоритет')],

            [['assigned_to'], 'safe'],
        ]);

        if ($model->hasErrors()) {
            return $model->errors;
        }

        return null;
    }
}
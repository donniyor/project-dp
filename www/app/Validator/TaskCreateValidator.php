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
            [['title'], 'required'],
            [['description'], 'safe'],
            [['project_id'], 'required'],
            [['assigned_to', 'project_id', 'status'], 'default', 'value' => null],
            [['author_id', 'assigned_to', 'project_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ]);

        if ($model->hasErrors()) {
            return $model->errors;
        }

        return null;
    }
}
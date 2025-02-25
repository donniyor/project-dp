<?php

declare(strict_types=1);

namespace app\Validator;

use yii\base\DynamicModel;
use yii\base\InvalidConfigException;

final class UserRegistrationValidator implements BaseValidatorInterface
{
    /**
     * @throws InvalidConfigException
     */
    public function validate(array $data): ?array
    {
        $model = DynamicModel::validateData($data, [
            [['username', 'email', 'password'], 'required'],
        ]);

        if ($model->hasErrors()) {
            return $model->errors;
        }

        return null;
    }
}
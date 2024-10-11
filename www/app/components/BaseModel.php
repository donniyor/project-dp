<?php

namespace app\components;

use yii\db\BaseActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

abstract class BaseModel extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = -1;

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                    'format' => ['date', 'php:d.m.Y H:i:s'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public static function getStatusList(): array
    {
        return [
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_DELETED => 'Удален'
        ];
    }
}
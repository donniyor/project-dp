<?php

namespace app\components;

use app\models\LogActions;
use Yii;
use yii\db\BaseActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Html;

abstract class BaseModel extends ActiveRecord
{
    abstract protected function logTitle(): string;

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

    protected function canRole(): bool
    {
        return Yii::$app->user->can('canSuperAdmin');
    }

    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            $this->setAttribute('status', self::STATUS_DELETED);
            $this->save(false);
            Yii::$app->session->setFlash('success', 'Запись успешно удалена.');

            return false;
        }
        Yii::$app->session->setFlash('error', 'Произошла ошибка у вас нет прав удалить эту запись.');

        return false;
    }

    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);

        $link = !Yii::$app->request->isConsoleRequest ? Html::a('Открыть', ['update', 'id' => $this->id]) : '';

        if ($insert) {
            LogActions::addLog(
                'add',
                "Пользователь добавил " . $this->logTitle(),
                $link
            );

            return;
        }

        if ($this->status === self::STATUS_DELETED) {
            LogActions::addLog(
                'delete',
                "Пользователь удалил " . $this->logTitle(),
                $link
            );
        } else {
            LogActions::addLog(
                'update',
                "Пользователь обновил " . $this->logTitle(),
                $link
            );
        }
    }

    public static function giveStatus(int $status): ?array
    {
        return $status === self::STATUS_ACTIVE ? null : ['class' => 'table-danger'];
    }

    public function validateJson($attribute, $params): void
    {
        foreach ($this->$attribute as $item) {
            if ($item == '' && isset($item)) {
                $this->addError($attribute, "Поле \"{$this->attributeLabels()[$attribute]}\" должно быть заполнено на всех языках.");
                return;
            }
        }
    }

    public static function getViewStatus(int $status): string
    {
        return match ($status) {
            -1 => 'Удален',
            1 => 'Активен',
            default => ''
        };
    }
}
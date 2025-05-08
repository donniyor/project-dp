<?php

declare(strict_types=1);

namespace app\components\Statuses;

use yii\helpers\Html;

class Statuses implements StatusesInterface
{
    // todo use only from repository
    public static function getStatusList(): array
    {
        return [
            self::STATUS_TO_DO => 'Запланировано',
            self::STATUS_DELETED => 'Удалено',
            self::STATUS_IN_PROCESS => 'В работе',
            self::STATUS_NOT_OK => 'Требует доработки',
            self::STATUS_OK => 'Готово',
            self::STATUS_DONE => 'Завершено',
        ];
    }

    public static function getStatuses(): array
    {
        return [
            self::STATUS_TO_DO,
            self::STATUS_DELETED,
        ];
    }

    public static function getStatusName(int $status): string
    {
        $statuses = self::getStatusList();
        if (isset($statuses[$status])) {
            return $statuses[$status];
        }

        return 'Не определен';
    }

    public static function getStatusTag(int $status): string
    {
        return Html::tag('span', Statuses::getStatusName($status), ['class' => 'status-tag']);
    }

    public static function getStatusButton(int $status): string
    {
        if (!isset(self::getStatuses()[$status])) {
            return Html::tag('span', Statuses::getStatusName($status), ['class' => 'badge bg-warning p-2']);
        }

        switch ($status) {
            case self::STATUS_TO_DO:
                $tag = 'btn-primary';
                break;
            case self::STATUS_DELETED:
                $tag = 'btn-danger';
                break;
            default:
                $tag = 'btn-warning';
        }

        return Html::tag('span', Statuses::getStatusName($status), ['class' => sprintf('btn %s pt-2', $tag)]);
    }
}
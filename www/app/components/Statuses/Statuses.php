<?php

declare(strict_types=1);

namespace app\components\Statuses;

use yii\helpers\Html;

class Statuses implements StatusesInterface
{
    public static function getStatusList(): array
    {
        return [
            self::STATUS_TO_DO => 'К выполнению',
            self::STATUS_IN_WORK => 'В работе',
            self::STATUS_PAUSED => 'Приостановлен',
            self::STATUS_DONE => 'Завершен',
            self::STATUS_ARCHIVED => 'Архивирован',
            self::STATUS_CANCELED => 'Отменен',
            self::STATUS_DELETED => 'Удален',
        ];
    }

    public static function getStatuses(): array
    {
        return [
            self::STATUS_IN_WORK,
            self::STATUS_PAUSED,
            self::STATUS_DONE,
            self::STATUS_CANCELED,
            self::STATUS_ARCHIVED,
            self::STATUS_DELETED,
        ];
    }

    public static function getMainStatuses(): array
    {
        return [
            self::STATUS_TO_DO,
            self::STATUS_IN_WORK,
            self::STATUS_DONE,
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
        if (!isset(self::getStatuses()[$status])) {
            return Html::tag('span', Statuses::getStatusName($status), ['class' => 'badge bg-warning p-2',]);
        }

        switch ($status) {
            case self::STATUS_DELETED:
                $tag = 'bg-danger';
                break;
            case self::STATUS_IN_WORK:
                $tag = 'bg-primary';
                break;
            default:
                $tag = 'bg-warning';
        }

        return Html::tag('span', Statuses::getStatusName($status), ['class' => sprintf('badge %s p-2', $tag)]);
    }

    public static function getStatusButton(int $status): string
    {
        if (!isset(self::getStatuses()[$status])) {
            return Html::tag('span', Statuses::getStatusName($status), ['class' => 'badge bg-warning p-2']);
        }

        switch ($status) {
            case self::STATUS_DELETED:
                $tag = 'btn-danger';
                break;
            case self::STATUS_IN_WORK:
                $tag = 'btn-primary';
                break;
            default:
                $tag = 'btn-warning';
        }

        return Html::tag('span', Statuses::getStatusName($status), ['class' => sprintf('btn %s pt-2', $tag)]);
    }
}
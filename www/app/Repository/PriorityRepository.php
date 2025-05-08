<?php

declare(strict_types=1);

namespace app\Repository;

use app\components\Priority\PriorityEnum;

class PriorityRepository
{
    public const NONE_PRIORITY = 'Приоритет не определен';

    public static function findAll(): array
    {
        return [
            [
                'id' => PriorityEnum::LOWEST,
                'title' => 'Lowest',
                'icon' => 'arrow_downward',
                'color' => '#9E9E9E',
            ],
            [
                'id' => PriorityEnum::LOW,
                'title' => 'Low',
                'icon' => 'expand_more',
                'color' => '#4CAF50',
            ],
            [
                'id' => PriorityEnum::MEDIUM,
                'title' => 'Medium',
                'icon' => 'remove',
                'color' => '#FFC107',
            ],
            [
                'id' => PriorityEnum::HIGH,
                'title' => 'High',
                'icon' => 'expand_less',
                'color' => '#FF5722',
            ],
            [
                'id' => PriorityEnum::HIGHEST,
                'title' => 'Highest',
                'icon' => 'arrow_upward',
                'color' => '#F44336',
            ],
        ];
    }

    public function findIcon(int $id): string
    {
        foreach ($this->findAll() as $priority) {
            if (isset($priority['id']) && $priority['id'] === $id) {
                return (string)($priority['icon'] ?? '');
            }
        }

        return '';
    }

    public function findColor(int $id): string
    {
        foreach ($this->findAll() as $priority) {
            if (isset($priority['id']) && $priority['id'] === $id) {
                return (string)($priority['color'] ?? '');
            }
        }

        return '';
    }

    public function findOne(int $id): ?array
    {
        foreach ($this->findAll() as $priority) {
            if (isset($priority['id']) && $priority['id'] === $id) {
                return $priority;
            }
        }

        return null;
    }
}

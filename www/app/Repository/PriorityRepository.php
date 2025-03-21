<?php

declare(strict_types=1);

namespace app\Repository;

use app\components\Priority\PriorityEnum;

class PriorityRepository
{
    public function findAll(): array
    {
        return [
            [
                'id' => PriorityEnum::LOWEST,
                'title' => 'Lowest',
                'icon' => 'expand_more',
                'color' => '#9E9E9E',
            ],
            [
                'id' => PriorityEnum::LOW,
                'title' => 'Low',
                'icon' => 'arrow_downward',
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
                'icon' => 'arrow_upward',
                'color' => '#FF5722',
            ],
            [
                'id' => PriorityEnum::HIGHEST,
                'title' => 'Highest',
                'icon' => 'expand_less',
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
}

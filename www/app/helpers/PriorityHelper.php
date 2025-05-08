<?php

declare(strict_types=1);

namespace app\helpers;

use app\Repository\PriorityRepository;
use yii\bootstrap5\Html;

class PriorityHelper
{
    public static function getPriorityById(int $id): string
    {
        foreach (PriorityRepository::findAll() as $priority) {
            if (isset($priority['id']) && $priority['id'] === $id) {
                return
                    Html::tag(
                        'div',
                        sprintf(
                            '%s %s',
                            $priority['title'] ?? PriorityRepository::NONE_PRIORITY,
                            Html::tag(
                                'div',
                                ($priority['icon'] ?? ''),
                                [
                                    'class' => 'material-icons task-icon',
                                    'style' => sprintf('color:%s', $priority['color'] ?? ''),
                                ],
                            ),
                        )
                    );
            }
        }

        return 'Приоритет не определен';
    }
}
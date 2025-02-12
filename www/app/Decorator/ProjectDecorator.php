<?php

declare(strict_types=1);

namespace app\Decorator;

use app\models\Projects;

class ProjectDecorator
{
    public function getFormattedData(Projects $projects): array
    {
        return [
            'id' => $projects->getId(),
            'title' => $projects->getTitle(),
        ];
    }
}
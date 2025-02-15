<?php

declare(strict_types=1);

use app\helpers\Avatars;
use app\models\Tasks;

/**
 * @var Tasks $model
 */

echo $model->getAssignedToUserId() === null
    ? Avatars::getAssignedToButton($model->getId(), 40)
    : Avatars::getAvatarRound($model->getAssignedToModel(), 40);

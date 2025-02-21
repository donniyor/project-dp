<?php

declare(strict_types=1);

namespace app\Repository;

use yii\db\ActiveRecord;

abstract class BaseEntityRepository
{
    abstract protected function getEntity(): ActiveRecord;
}
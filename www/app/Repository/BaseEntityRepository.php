<?php

declare(strict_types=1);

namespace app\Repository;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

abstract class BaseEntityRepository
{
    abstract public function getEntity(): ActiveRecord;
}
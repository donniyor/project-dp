<?php

declare(strict_types=1);

namespace app\Repository;

use app\models\Users;
use Yii;
use yii\web\User;

class UserRepository
{
    private Users $users;

    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    public function findByIds(array $userIds, int $limit = 10): array
    {
        return $this->users::find()
            ->where(['in', 'id', $userIds])
            ->limit($limit)
            ->all();
    }

    public function getCurrentUser(): User
    {
        return Yii::$app->getUser();
    }
}
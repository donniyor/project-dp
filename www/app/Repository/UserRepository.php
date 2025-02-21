<?php

declare(strict_types=1);

namespace app\Repository;

use app\models\Users;
use Yii;
use yii\web\User;

class UserRepository extends BaseEntityRepository
{
    protected function getEntity(): Users
    {
        return new Users();
    }

    public function findByIds(array $userIds, int $limit = 10): array
    {
        return $this->getEntity()
            ->find()
            ->where(['in', 'id', $userIds])
            ->limit($limit)
            ->all();
    }

    public function getCurrentUser(): User
    {
        return Yii::$app->getUser();
    }

    public function findByVerificationToken(string $token): ?Users
    {
        return $this->getEntity()->findOne(['verification_token' => $token]);
    }

    public function finByUsername(string $username): ?Users
    {
        return $this->getEntity()->findOne(['username' => $username, 'status' => Users::STATUS_ACTIVE]);
    }
}
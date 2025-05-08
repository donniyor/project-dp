<?php

declare(strict_types=1);

namespace app\Repository;

use app\DTO\UserDTO;
use app\models\Users;
use Yii;
use yii\db\Exception;
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

    /**
     * @return Users|null
     */
    public function findByUsernameOrEmail(string $username, string $email): ?Users
    {
        /** @var null|Users $users */
        $users = $this->getEntity()
            ->find()
            ->where(['username' => $username])
            ->orWhere(['email' => $email])
            ->one();

        return $users;
    }

    /**
     * @throws Exception
     */
    public function updateOne(Users $model, UserDTO $userDTO): bool
    {
        return $model
            ->setFirstName($userDTO->firstName)
            ->setLastName($userDTO->lastName)
            ->setPosition($userDTO->position)
            ->setDepartment($userDTO->department)
            ->save();
    }
}

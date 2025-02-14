<?php

declare(strict_types=1);

namespace app\Service;

use app\components\Avatars;
use app\models\Users;
use app\Repository\UserRepository;
use yii\web\User;

class UserService
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getUsersForView(array $users): array
    {
        $total = [];

        /** @var Users $user */
        foreach ($users as $user) {
            $avatarHtml = Avatars::getAvatarRound($user, 40, false);
            $total[] = [
                'id' => $user->getId(),
                'user' => sprintf('%s %s', $user->getLastName(), $user->getFirstName()),
                'email' => $user->getEmail(),
                'avatar' => $avatarHtml,
            ];
        }

        return $total;
    }

    public function findByIds(array $userIds, int $limit = 10): array
    {
        return $this->repository->findByIds($userIds, $limit);
    }

    public function getCurrentUser(): User
    {
        return $this->repository->getCurrentUser();
    }
}
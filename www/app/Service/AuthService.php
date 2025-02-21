<?php

declare(strict_types=1);

namespace app\Service;

use app\Exception\RegistrationException;

class AuthService
{
    private const AUTH_TIME = 3600 * 24 * 30;

    public function __construct(
        readonly private UserService $userService,
    ) {
    }

    /**
     * @throws RegistrationException
     */
    public function registration(
        string $username,
        string $password,
    ) {
        $user = $this->userService->finByUsername($username);

        if ($user !== null) {
            throw new RegistrationException('User with this username is already exists');
        }
    }

    public function login(string $username, string $password): bool
    {
        $user = $this->userService->finByUsername($username);

        if (
            $user === null
            || !$user->validatePassword($password)
        ) {
            return false;
        }

        return $this->userService
            ->getCurrentUser()
            ->login($user, self::AUTH_TIME);
    }
}
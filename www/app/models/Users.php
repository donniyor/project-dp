<?php

declare(strict_types=1);

namespace app\models;

use app\components\RolesInterface;
use Yii;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Users model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property string $password write-only password
 * @property string $created_at
 * @property string $updated_at
 * @property array $roles
 */
class Users extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public static function tableName(): string
    {
        return 'users';
    }

    public function attributeLabels(): array
    {
        return [
            'username' => 'Имя Пользователя',
            'email' => 'Почта',
            'password' => 'Пароль',
            'role' => 'Роль',
        ];
    }

    public static function letDelete(int $myUserRoles, int $usersToDelete): bool
    {
        $myUserRoles = Yii::$app->authManager->getRolesByUser($myUserRoles);
        $usersToDelete = Yii::$app->authManager->getRolesByUser($usersToDelete);
        foreach ($myUserRoles as $myUserRole) {
            foreach ($usersToDelete as $userToDelete) {
                if ($userToDelete->name !== RolesInterface::SUPER_ADMIN_ROLE && $myUserRole->name !== $userToDelete->name) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @throws \yii\db\Exception
     */
    public function beforeDelete(): bool
    {
        if (parent::beforeDelete() && $this->selfDelete($this->id)) {
            $this->status = self::STATUS_DELETED;
            $this->save(false);
            Yii::$app->session->setFlash('success', 'Вы удалили аккаунт.');

            return false;
        }
        Yii::$app->session->setFlash('error', 'Вы не можете удалить этот аккаунт.');

        return false;
    }

    private function selfDelete(int $id): bool
    {
        return (int)Yii::$app->user->id !== $id;
    }

    public function getRoles(): ActiveQuery
    {
        return $this->hasMany(AuthAssignment::class, ['user_id' => 'id']);
    }

    public function getStatus(): bool
    {
        return self::STATUS_ACTIVE === (int)$this->getStatus();
    }

    public function rules(): array
    {
        return [
            [['username'], 'required'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    public static function findIdentity($id): ?ActiveRecord
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null): void
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername(string $username): ?static
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByPasswordResetToken(string $token): ?static
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function findByVerificationToken(string $token): ?static
    {
        return static::findOne([
            'verification_token' => $token,
        ]);
    }

    public static function isPasswordResetTokenValid(string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function getId(): int
    {
        return (int)$this->getPrimaryKey();
    }

    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @throws Exception
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @throws Exception
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @throws Exception
     */
    public function generatePasswordResetToken(): void
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * @throws Exception
     */
    public function generateEmailVerificationToken(): void
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken(): void
    {
        $this->password_reset_token = null;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getImageUrl(): string
    {
        return '';
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}

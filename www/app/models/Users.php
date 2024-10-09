<?php

namespace app\models;

use app\components\RolesInterface;
use Yii;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Html;
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
 */
class Users extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    const ROLE_SUPER_ADMIN = RolesInterface::SUPER_ADMIN_ROLE;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%users}}';
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

    public function beforeDelete(): bool
    {
        if (parent::beforeDelete() && !$this->selfDelete($this->id) && Users::isSuperAdminStatic()) {
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
        return Yii::$app->user->id == $id;
    }

    public static function isSuperAdminStatic(): bool
    {
        return Yii::$app->user->identity->roles[0]->item_name === self::ROLE_SUPER_ADMIN;
    }

    public static function getRole(): string
    {
        return Yii::$app->user->identity->roles[0]->item_name ?? '';
    }

    public static function showCreate(int $count): bool
    {
        return Yii::$app->user->identity->roles[0]->item_name === self::ROLE_SUPER_ADMIN || $count <= 0;
    }

    public static function getStatus(int $status): array|null
    {
        return match ($status) {
            0 => ['class' => 'table-danger'],
            9 => ['class' => 'table-primary'],
            default => null
        };
    }

    public static function getStatusToDelete(int $status): bool|null
    {
        return match($status) {
            0 => false,
            default => true,
        };
    }

    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);

        if (Yii::$app->controller->id != 'my-rbac') {
            if ($insert) {
                LogActions::addLog(
                    'add',
                    "Пользователь добавил другого пользователя",
                    Html::a('Открыть', ['/admins/?UsersSearch[username]=' . $this->username]));
            } else {
                if ($this->status == self::STATUS_DELETED) {
                    LogActions::addLog(
                        'delete',
                        "Пользователь удалил другого пользователя",
                        Html::a('Открыть', ['/admins/?UsersSearch[username]=' . $this->username]));
                } else {
                    LogActions::addLog(
                        'update',
                        "Пользователь обновил другого пользователя",
                        Html::a('Открыть', ['/admins/?UsersSearch[username]=' . $this->username]));
                }
            }
        } else {
            if ($insert) LogActions::addInit();
        }
    }

    public function getRoles(): ActiveQuery
    {
        return $this->hasMany(AuthAssignment::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['username'], 'required'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE], // todo status inactive
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): null|ActiveRecord
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null): void
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername(string $username): null|static
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken(string $token): static|null
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken(string $token): static|null
    {
        return static::findOne([
            'verification_token' => $token,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid(string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): string
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws Exception
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws Exception
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     * @throws Exception
     */
    public function generatePasswordResetToken(): void
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     * @throws Exception
     */
    public function generateEmailVerificationToken(): void
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken(): void
    {
        $this->password_reset_token = null;
    }
}

<?php

declare(strict_types=1);

namespace app\models;

use Exception;
use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class CreateAdminForm extends Model
{
    public string $username = '';
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $password = '';

    /**
     * {@inheritdoc}
     */

    public function rules(): array
    {
        return [
            ['username', 'trim'],
            [['username', 'first_name', 'last_name'], 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\Users', 'message' => 'Это имя уже занято'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\Users', 'message' => 'Эта почта уже занята'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'username' => 'Логин',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'email' => 'Почта',
            'password' => 'Пароль',
        ];
    }

    /**
     * @throws Exception
     */
    public function createUser(): bool
    {
        if ($this->validate()) {
            $user = new Users();
            $user->setUsername($this->getUsername());
            $user->setFirstName($this->getFirstName());
            $user->setLastName($this->getLastName());
            $user->setEmail($this->getEmail());
            $user->setPassword($this->getPassword());
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            $authManager = Yii::$app->authManager;
            $role = $authManager->getRole('admin');

            return $user->save() && Yii::$app->authManager->assign($role, $user->id);
        }

        return false;
    }

    protected function sendEmail(Users $user): bool
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}

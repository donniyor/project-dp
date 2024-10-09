<?php

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
    public string $email = '';
    public string $password = '';

    /**
     * {@inheritdoc}
     */

    public function rules(): array
    {
        return [
            ['username', 'trim'],
            [['username'], 'required'],
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
            'username' => 'Имя Пользователя',
            'email' => 'Почта',
            'password' => 'Пароль',
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool|null whether the creating new account was successful and email was sent
     * @throws Exception
     */
    public function createUser(): ?bool
    {
        if ($this->validate()) {
            $user = new Users();
            $user->username = $this->username;
            $user->email = $this->email;

            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();

            /* Create role for user */
            $authManager = Yii::$app->authManager;
            $role = $authManager->getRole('admin');

            Yii::$app->session->setFlash('success', 'Аккаунт был создан. Проверте почту.');
            return $user->save() /*&& $this->sendEmail($user) */ && Yii::$app->authManager->assign($role, $user->id);
        }
        Yii::$app->session->setFlash('danger', 'Такой аккаунт не может быть создан.');
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
}

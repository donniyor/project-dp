<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Html;

/**
 * This is the model class for table "log_actions".
 *
 * @property int $id
 * @property string $admin_login
 * @property string $action_type
 * @property string $extra
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class LogActions extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = -1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_actions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['admin_login', 'action_type', 'extra'], 'required'],
            [['admin_login', 'action_type', 'extra'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_login' => 'Логин',
            'action_type' => 'Тип действия',
            'extra' => 'Данные',
            'status' => 'Статус',
            'created_at' => 'Дата запроса',
            'updated_at' => 'Обновлено',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    parent::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    parent::EVENT_BEFORE_UPDATE => ['updated_at'],
                    'format' => ['date', 'php:d.m.Y H:i:s'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public static function addLog($type, $message, $url){
        $log = new self;
        $log->admin_login = Yii::$app->user->isGuest ? 'verify email' : Yii::$app->user->identity->username;
        $log->action_type = $type;
        $log->extra = $message." ".$url;
        $log->save();
    }

    public static function addInit(){
        $log = new self;
        $log->admin_login = 'Пользователь';
        $log->action_type = 'Init';
        $log->extra = 'Был добавлен супер админ';
        $log->save();
    }
}

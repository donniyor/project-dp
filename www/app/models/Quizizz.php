<?php

namespace app\models;

use app\components\BaseModel;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "quizizz".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int|null $user_id
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Questions[] $questions
 * @property TestSolution[] $testSolutions
 * @property Users $user
 */
class Quizizz extends BaseModel
{
    const STATUS_INACTIVE = 0;

    public static function tableName(): string
    {
        return 'quizizz';
    }

    public function rules(): array
    {
        return [
            [['title', 'description', 'status'], 'required'],
            [['description'], 'string'],
            [['user_id', 'status'], 'default', 'value' => Yii::$app->user->id],
            [['user_id', 'status'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Описание',
            'user_id' => 'Автор',
            'status' => 'Статус',
            'created_at' => 'Дата добавления',
            'updated_at' => 'Дата редактирования',
        ];
    }

    public function getQuestions(): ActiveQuery
    {
        return $this->hasMany(Questions::class, ['quiz_id' => 'id'])->orderBy(['created_at' => SORT_ASC]);
    }

    public function getTestSolutions(): ActiveQuery
    {
        return $this->hasMany(TestSolution::class, ['quiz_id' => 'id'])->orderBy(['created_at' => SORT_ASC]);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    protected function logTitle(): string
    {
        return 'опрос';
    }

    public static function getStatusList(): array
    {
        return [
            self::STATUS_INACTIVE => 'Не активен',
            parent::STATUS_ACTIVE => 'Активен',
            parent::STATUS_DELETED => 'Удален'
        ];
    }

    public static function getStatusListForUser(): array
    {
        return [
            self::STATUS_INACTIVE => 'Не активен',
            parent::STATUS_ACTIVE => 'Активен'
        ];
    }

    public static function giveStatus(int $status): ?array
    {
        return match ($status) {
            self::STATUS_INACTIVE => ['class' => 'table-info'],
            parent::STATUS_DELETED => ['class' => 'table-danger'],
            default => null,
        };
    }
}

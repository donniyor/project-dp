<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "auth_item_child".
 *
 * @property string $parent
 * @property string $child
 *
 * @property AuthItem $child0
 * @property AuthItem $parent0
 */
class AuthItemChild extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'auth_item_child';
    }

    public function rules(): array
    {
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64],
            [['parent', 'child'], 'unique', 'targetAttribute' => ['parent', 'child']],
            [
                ['parent'],
                'exist',
                'skipOnError' => true,
                'targetClass' => AuthItem::class,
                'targetAttribute' => ['parent' => 'name']
            ],
            [
                ['child'],
                'exist',
                'skipOnError' => true,
                'targetClass' => AuthItem::class,
                'targetAttribute' => ['child' => 'name']
            ],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'parent' => 'Parent',
            'child' => 'Child',
        ];
    }

    public function getChild0(): ActiveQuery
    {
        return $this->hasOne(AuthItem::class, ['name' => 'child']);
    }

    public function getParent0(): ActiveQuery
    {
        return $this->hasOne(AuthItem::class, ['name' => 'parent']);
    }
}

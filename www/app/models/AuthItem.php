<?php

declare(strict_types=1);

namespace app\models;

use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property int $type
 * @property string|null $description
 * @property string|null $rule_name
 * @property resource|null $data
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 * @property AuthItem[] $children
 * @property AuthItem[] $parents
 * @property AuthRule $ruleName
 */
class AuthItem extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'auth_item';
    }

    public function rules(): array
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['name'], 'unique'],
            [
                ['rule_name'],
                'exist',
                'skipOnError' => true,
                'targetClass' => AuthRule::class,
                'targetAttribute' => ['rule_name' => 'name']
            ],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'rule_name' => 'Rule Name',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getAuthAssignments(): ActiveQuery
    {
        return $this->hasMany(AuthAssignment::class, ['item_name' => 'name']);
    }

    public function getAuthItemChildren(): ActiveQuery
    {
        return $this->hasMany(AuthItemChild::class, ['parent' => 'name']);
    }

    public function getAuthItemChildren0(): ActiveQuery
    {
        return $this->hasMany(AuthItemChild::class, ['child' => 'name']);
    }

    /**
     * @throws InvalidConfigException
     */
    public function getChildren(): ActiveQuery
    {
        return $this
            ->hasMany(AuthItem::class, ['name' => 'child'])
            ->viaTable('auth_item_child', ['parent' => 'name']);
    }

    /**
     * @throws InvalidConfigException
     */
    public function getParents(): ActiveQuery
    {
        return $this
            ->hasMany(AuthItem::class, ['name' => 'parent'])
            ->viaTable('auth_item_child', ['child' => 'name']);
    }

    public function getRuleName(): ActiveQuery
    {
        return $this->hasOne(AuthRule::class, ['name' => 'rule_name']);
    }
}

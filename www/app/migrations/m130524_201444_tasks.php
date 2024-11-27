<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Class m130524_201444_tasks
 */
class m130524_201444_tasks extends Migration
{
    private const TABLE_NAME = 'tasks';

    /**
     * @inheritDoc
     */
    public function up(): void
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),

            'title' => $this->string(),
            'description' => $this->text(),
            'author_id' => $this->integer()->notNull(),
            'assigned_to' => $this->integer(),
            'project_id' => $this->integer()->notNull(),

            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
            'updated_at' => $this->timestamp()->defaultExpression('NOW()'),
        ], $tableOptions);

        $this->addForeignKey(
            self::TABLE_NAME . 'project_id',
            self::TABLE_NAME,
            'project_id',
            'projects',
            'id',
            'NO ACTION',
            'NO ACTION'
        );

        $this->addForeignKey(
            self::TABLE_NAME . 'author_id',
            self::TABLE_NAME,
            'author_id',
            'users',
            'id',
            'NO ACTION',
            'NO ACTION'
        );

        $this->addForeignKey(
            self::TABLE_NAME . 'assigned_to',
            self::TABLE_NAME,
            'assigned_to',
            'users',
            'id',
            'NO ACTION',
            'NO ACTION'
        );
    }

    /**
     * @inheritDoc
     */
    public function down(): void
    {
        $this->dropForeignKey(
            self::TABLE_NAME . 'project_id',
            self::TABLE_NAME
        );

        $this->dropForeignKey(
            self::TABLE_NAME . 'author_id',
            self::TABLE_NAME
        );

        $this->dropForeignKey(
            self::TABLE_NAME . 'assigned_to',
            self::TABLE_NAME
        );

        $this->dropTable(self::TABLE_NAME);
    }
}

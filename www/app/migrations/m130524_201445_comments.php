<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Class m130524_201445_comments
 */
final class m130524_201445_comments extends Migration
{
    private const TABLE_NAME = 'comments';

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

            'comment' => $this->text(),
            'author_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),

            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
            'updated_at' => $this->timestamp()->defaultExpression('NOW()'),
        ], $tableOptions);

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
            self::TABLE_NAME . 'task_id',
            self::TABLE_NAME,
            'task_id',
            'tasks',
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
            self::TABLE_NAME . 'author_id',
            self::TABLE_NAME
        );

        $this->dropForeignKey(
            self::TABLE_NAME . 'task_id',
            self::TABLE_NAME
        );

        $this->dropTable(self::TABLE_NAME);
    }
}

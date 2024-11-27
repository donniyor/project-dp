<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Class m130524_201446_related_tasks
 */
final class m130524_201446_related_tasks extends Migration
{
    private const TABLE_NAME = 'related_tasks';

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
            'first_task_id' => $this->integer()->notNull(),
            'second_task_id' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            self::TABLE_NAME . 'first_task_id',
            self::TABLE_NAME,
            'first_task_id',
            'tasks',
            'id',
            'NO ACTION',
            'NO ACTION'
        );

        $this->addForeignKey(
            self::TABLE_NAME . 'second_task_id',
            self::TABLE_NAME,
            'second_task_id',
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
            self::TABLE_NAME . 'first_task_id',
            self::TABLE_NAME
        );

        $this->dropForeignKey(
            self::TABLE_NAME . 'second_task_id',
            self::TABLE_NAME
        );

        $this->dropTable(self::TABLE_NAME);
    }
}

<?php

declare(strict_types=1);

namespace app\migrations;

use yii\db\Migration;

/**
 * Class m130524_201447_tasks_statuses
 */
final class m130524_201447_tasks_statuses extends Migration
{
    private const TABLE_NAME = 'tasks_statuses';

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
            'status' => $this->integer()->notNull(),
            'project_id' => $this->integer()->notNull(),
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
    }

    /**
     * @inheritDoc
     */
    public function down(): void
    {
        $this->dropForeignKey(
            self::TABLE_NAME . 'project_id',
            self::TABLE_NAME,
        );

        $this->dropTable(self::TABLE_NAME);
    }
}

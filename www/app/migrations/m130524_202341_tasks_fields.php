<?php

declare(strict_types=1);

use app\components\Priority\PriorityEnum;
use yii\db\Migration;

/**
 * Class m130524_202341_tasks_fields
 */
class m130524_202341_tasks_fields extends Migration
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

        $this->addColumn(
            self::TABLE_NAME,
            'priority',
            $this->smallInteger()->notNull()->defaultValue(PriorityEnum::LOWEST),
        );

        $this->addColumn(
            self::TABLE_NAME,
            'deadline',
            $this->timestamp()->null()->defaultExpression('NOW()'),
        );
    }

    /**
     * @inheritDoc
     */
    public function down(): void
    {
        $this->dropColumn(self::TABLE_NAME, 'priority');
        $this->dropColumn(self::TABLE_NAME, 'deadline');
    }
}

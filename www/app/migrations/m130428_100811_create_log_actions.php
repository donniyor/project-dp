<?php

use yii\db\Migration;

/**
 * Class m231128_100832_create_log_actions
 */
class m130428_100811_create_log_actions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(): void
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%log_actions}}', [
            'id' => $this->primaryKey(),

            'admin_login' => $this->string()->notNull(),
            'action_type' => $this->string()->notNull(),
            'extra' => $this->string()->notNull(),

            'status' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        $this->dropTable('{{%log_actions}}');
    }
}

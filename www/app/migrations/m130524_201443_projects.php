<?php

use yii\db\Migration;

/**
 * Class m130524_201443_projects
 */
class m130524_201443_projects extends Migration
{
    private const TABLE_NAME = 'projects';

    /**
     * @inheritDoc
     */
    public function up()
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
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->dropForeignKey(
            self::TABLE_NAME . 'author_id',
            self::TABLE_NAME
        );

        $this->dropTable(self::TABLE_NAME);
    }
}

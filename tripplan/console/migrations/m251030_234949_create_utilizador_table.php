<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%utilizador}}`.
 */
class m251030_234949_create_utilizador_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%utilizador}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%utilizador}}');
    }
}

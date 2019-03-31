<?php

use yii\db\Migration;

/**
 * Class m190329_134816_files
 */
class m190329_134816_files extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('files', [
            'id' => $this->primaryKey(),
            'name' => $this->text()->notNull(),
            'type' => $this->text()->notNull(),
            'size' => $this->integer()->notNull(),
            'blob' => $this->binary()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('files');
        return true;
    }
}

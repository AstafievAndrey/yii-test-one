<?php

use yii\db\Migration;

/**
 * Class m190327_084148_users
 */
class m190327_084148_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'password' => $this->text()->notNull(),
            'authKey' => $this->text(),
            'accessToken' => $this->text(),
        ]);
        $this->insert('users', [
            'id' => 1, 'username' => 'admin', 'password' => md5(md5('admin')),
        ]);
        $this->insert('users', [
            'id' => 2, 'username' => 'demo', 'password' => md5(md5('demo')),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('users', ['id' => [1, 2]]);
        $this->dropTable('users');

        return true;
    }

}

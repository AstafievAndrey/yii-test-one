<?php

use yii\db\Migration;

/**
 * Class m190328_195909_users
 */
class m190328_195909_users extends Migration
{

    private function getUsers() {
        return [
            ['id'=> 1, 'username' => 'admin', 'password' => md5('admin'), 'authKey' => null, 'accessToken' => null],
            ['id'=> 2, 'username' => 'manager', 'password' => md5('manager'), 'authKey' => null, 'accessToken' => null],
            ['id'=> 3, 'username' => 'user', 'password' => md5('user'), 'authKey' => null, 'accessToken' => null],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'authKey' => $this->text(),
            'accessToken' => $this->text(),
        ]);
        foreach($this->getUsers() as $value) {
            $this->insert('users', $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
        return true;
    }
}

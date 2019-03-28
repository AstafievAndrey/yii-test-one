<?php

use yii\db\Migration;

/**
 * Class m190327_141244_users_roles
 */
class m190327_141244_users_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users_roles', [
            'id' => $this->primaryKey(),
            'role_id' => $this->integer(),
            'user_id' => $this->integer(),
        ]);
        $this->addForeignKey(
            'foreign_role_id','users_roles','role_id','roles','id','CASCADE'
        );
        $this->addForeignKey(
            'foreign_user_id','users_roles','user_id','users','id','CASCADE'
        );
        $this->insert('users_roles', [ 'id' => 1, 'role_id' => 1, 'user_id' => 1]);
        $this->insert('users_roles', [ 'id' => 2, 'role_id' => 2, 'user_id' => 2]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('users_roles', ['id' => [1, 2]]);
        $this->dropTable('users_roles');
        
        return true;
    }
}

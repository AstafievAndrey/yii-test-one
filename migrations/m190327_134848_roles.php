<?php

use yii\db\Migration;

/**
 * Class m190327_134848_roles
 */
class m190327_134848_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('roles', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'description' => $this->text(),
        ]);
        $this->insert('roles', [
            'id' => 1, 'name' => 'admin', 'description' => 'Роль администратора',
        ]);
        $this->insert('roles', [
            'id' => 2, 'name' => 'manager', 'description' => 'Роль менеджера',
        ]);
        $this->insert('roles', [
            'id' => 3, 'name' => 'customer', 'description' => 'Роль покупателя',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('roles', ['id' => [1, 2, 3]]);
        $this->dropTable('roles');

        return true;
    }

}

<?php

use yii\db\Migration;

/**
 * Class m190329_131601_categories
 */
class m190329_131601_categories extends Migration
{

    private function getCategories() {
        return [
            ['id'=> 1, 'name' => 'Компьютеры', 'description' => 'Категория компьютеров'],
            ['id'=> 2, 'name' => 'Смартфоны', 'description' => 'Категория смартфонов'],
            ['id'=> 3, 'name' => 'Аксессуары', 'description' => 'Категория аксессуаров'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('categories', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'description' => $this->text()->notNull(),
        ]);
        foreach($this->getCategories() as $value) {
            $this->insert('categories', $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('categories');
        return true;
    }
}

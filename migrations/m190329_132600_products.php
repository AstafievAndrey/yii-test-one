<?php

use yii\db\Migration;

/**
 * Class m190329_132600_products
 */
class m190329_132600_products extends Migration
{
    private function getProducts() {
        return [
            ['id'=> 1, 'name' => 'iphone 7 plus', 'description' => 'телефон iphone 7 plus', 'price' => 50000],
            ['id'=> 2, 'name' => 'imac', 'description' => 'моноблок imac', 'price' => 120000],
            ['id'=> 3, 'name' => 'чехлы', 'description' => 'чехлы на телефоны', 'price' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('products', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'price' => $this->float()->notNull(),
        ]);
        foreach($this->getProducts() as $value) {
            $this->insert('products', $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('products');
        return true;
    }
}

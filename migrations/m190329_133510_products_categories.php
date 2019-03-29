<?php

use yii\db\Migration;

/**
 * Class m190329_133510_products_categories
 */
class m190329_133510_products_categories extends Migration
{
    private function getProductsCategories() {
        return [
            ['id'=> 1, 'product_id' => 1, 'category_id' => 1],
            ['id'=> 2, 'product_id' => 2, 'category_id' => 2],
            ['id'=> 3, 'product_id' => 3, 'category_id' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('products_categories', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey(
            'foreign_products_categories_product_id',
            'products_categories',
            'product_id',
            'products',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'foreign_products_categories_category_id',
            'products_categories',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );
        foreach($this->getProductsCategories() as $value) {
            $this->insert('products_categories', $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('products_categories');
        return true;
    }
}

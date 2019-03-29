<?php

use yii\db\Migration;

/**
 * Class m190329_135338_products_files
 */
class m190329_135338_products_files extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('products_files', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'file_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey(
            'foreign_products_files_product_id',
            'products_files',
            'product_id',
            'products',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'foreign_products_files_file_id',
            'products_files',
            'file_id',
            'files',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('products_files');
        return true;
    }
}

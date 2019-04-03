<?php

namespace app\models\tables;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property double $price
 *
 * @property ProductsCategories[] $productsCategories
 * @property ProductsFiles[] $productsFiles
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'price'], 'required', 'message' => '{attribute} не может быть пустым.'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 255, 'message' => '{attribute} не может быть больше 255 символов.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид товара',
            'name' => 'Название',
            'description' => 'Описание',
            'price' => 'Цена',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsCategories()
    {
        return $this->hasMany(ProductsCategories::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsFiles()
    {
        return $this->hasMany(ProductsFiles::className(), ['product_id' => 'id']);
    }
}

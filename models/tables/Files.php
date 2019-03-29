<?php

namespace app\models\tables;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int $size
 * @property resource $blob
 *
 * @property ProductsFiles[] $productsFiles
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'size', 'blob'], 'required'],
            [['name', 'type', 'blob'], 'string'],
            [['size'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'size' => 'Size',
            'blob' => 'Blob',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsFiles()
    {
        return $this->hasMany(ProductsFiles::className(), ['file_id' => 'id']);
    }
}

<?php

namespace app\models;
use yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadFiles extends Model
{
    public $files;

    public function rules()
    {
        return [
            [['files'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 5],
        ];
    }

    public function getDir() {
        return Yii::getAlias('@webroot').'/uploads/' ;
    }

    public function upload()
    {
        $time = time();
        if ($this->validate()) { 
            foreach ($this->files as $file) {
                $file->saveAs($this->getDir() . $time . '-' . $file->baseName . '.' . $file->extension);
            }
            return $time;
        } else {
            return false;
        }
    }
}

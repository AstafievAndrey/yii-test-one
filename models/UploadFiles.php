<?php

namespace app\models;
use yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadFiles extends Model
{
    private $skipOnEmpty;
    private $maxFiles;
    public $files;

    public function __construct($maxFiles = 4, $skipOnEmpty = false) {
        parent::__construct();
        $this->skipOnEmpty = $skipOnEmpty;
        $this->maxFiles = $maxFiles;
    }

    public function rules()
    {
        return [
            [
                ['files'],
                'file',
                'skipOnEmpty' => $this->skipOnEmpty,
                'extensions' => 'png, jpg',
                'maxFiles' => $this->maxFiles
            ],
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

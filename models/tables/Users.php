<?php

namespace app\models\tables;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }
    
    public function save($runValidation = true, $attributeNames = null)
    {
        $this->password = md5(md5($this->password));
        parent::save($runValidation, $attributeNames);
    }

    public function getRoles() {
        return $this->hasMany(UsersRoles::className(), ['user_id' => 'id']);
    }

    public function hasRoles(array $roles) {
        foreach($this->roles as $key => $value){
            if(array_search($value->role->name, $roles)) {
                return true;
            }
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['password', 'authKey', 'accessToken'], 'string'],
            [['username'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
        ];
    }
}

<?php

use yii\db\Migration;

/**
 * Class m190328_201155_init_rbac
 */
class m190328_201155_init_rbac extends Migration
{
    private function createPermission($name, $desc) {
        $auth = Yii::$app->authManager;
        $permission = $auth->createPermission($name);
        $permission->description = $desc;
        $auth->add($permission);
        return $permission;
    }

    private function createRole($name, array $permissions) {
        $auth = Yii::$app->authManager;
        $role = $auth->createRole($name);
        $auth->add($role);
        foreach($permissions as $permission) {
            $auth->addChild($role, $permission);
        }

        return $role;
    }

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $auth = Yii::$app->authManager;

        $createProduct = $this->createPermission('createProduct', 'Create a product');
        $updateProduct = $this->createPermission('updateProduct', 'Update a product');
        $deleteProduct = $this->createPermission('deleteProduct', 'Delete a product');
        
        $admin = $this->createRole('admin', [$createProduct, $updateProduct , $deleteProduct]);
        $manager = $this->createRole('manager', [$createProduct, $updateProduct , $deleteProduct]);

        $auth->assign($manager, 2);
        $auth->assign($admin, 1);
    }

    public function down()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        return true;
    }


}

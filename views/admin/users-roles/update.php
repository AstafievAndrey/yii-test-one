<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\tables\UsersRoles */

$this->title = 'Update Users Roles: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="users-roles-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

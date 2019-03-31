<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\tables\Products */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Панель администратора', 'url' => ['admin/main']];
$this->params['breadcrumbs'][] = ['label' => 'Продукты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="products-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
            'price',
        ],
    ]) ?>
    <?php if (count($model->productsCategories) > 0) { ?>
        <h3>Категории</h3>
        <table class="table table-striped">
            <thead>
                <th>ИД категории</th>
                <th>Название</th>
                <th>Описание</th>
            </thead>
            <tbody>
            <?php 
                foreach($model->productsCategories as $item) {
                    echo '<tr>'
                            .'<td>'.$item->category->id.'</td>'
                            .'<td>'.$item->category->name.'</td>'
                            .'<td>'.$item->category->description.'</td>'
                        .'</tr>';
                }
            ?>
            </tbody>
        </table>
    <?php }?>
    <?php if (count($model->productsFiles) > 0) { ?>
        <h3>Изображения</h3>
        <div class="row">
        <?php
            foreach($model->productsFiles as $item) {
                echo 
                '<div class="col-sm-3">'
                    .'<img class="img-thumbnail" src="data:'.$item->file->type.';base64,'.base64_encode($item->file->blob).'"/>'
                .'</div>';
            }
        ?>
        </div>
    <?php }?>
</div>

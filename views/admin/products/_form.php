<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\tables\Categories;

/* @var $this yii\web\View */
/* @var $model app\models\tables\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput() ?>
    
    <?php
        $optionsCategList = [];
        foreach($model->productsCategories as $item) {
            $optionsCategList[$item->category_id] = ['selected' => 'selected'];
        }
        echo $form->field($categories, 'id')->dropdownList(
            Categories::find()->select(['name', 'id'])->indexBy('id')->column(),
            [
                'multiple' => true, 'required' => true,
                'options' => $optionsCategList,
            ]
        );
    ?>

    <?php if ($uploadFiles !== false) { ?>
        <?= $form->field($uploadFiles, 'files[]')->fileInput(
            ['multiple' => true, 'accept' => 'image/*']) ?>
    <?php }?>

    <?php if (count($model->productsFiles) > 0) { ?>
        <h3>Изображения</h3>
        <div class="row">
        <?php
            foreach($model->productsFiles as $item) {
                echo 
                '<div class="col-sm-3">'
                    . Html::a('удалить', 
                        ['delete-file', 'id'=> $model->id, 'file' => $item->file->id],
                        [
                            'class' => 'btn btn-danger', 
                            'style' => 'position: absolute',
                            'data' => [
                                'confirm' => 'Вы уверены что хотите удалить?',
                                'method' => 'post',
                            ],
                        ]
                    )
                    .'<img class="img-thumbnail" src="data:'.$item->file->type.';base64,'.base64_encode($item->file->blob).'"/>'
                .'</div>';
            }
        ?>
        </div>
    <?php }?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

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
        echo $form->field($categories, 'id')->dropdownList(
            Categories::find()->select(['name', 'id'])->indexBy('id')->column(),
            ['multiple' => true, 'required' => true]
        );
    ?>

    <?= $form->field($uploadFiles, 'files[]')->fileInput(
        ['multiple' => true, 'accept' => 'image/*']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

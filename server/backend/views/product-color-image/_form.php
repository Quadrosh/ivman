<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductColorImage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-color-image-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'color_id')->textInput() ?>

    <?= $form->field($model, 'imagefile_id')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

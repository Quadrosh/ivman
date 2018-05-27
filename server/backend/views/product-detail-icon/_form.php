<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductDetailIcon */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-detail-icon-form">

    <?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-sm-4">
        <?= $form->field($model, 'name')->textarea(['rows'=>1,'maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'type')->dropDownList(\yii\helpers\ArrayHelper::map(
            \common\models\ProductDetailIconType::find()->all(), 'name','name'),['id'=>'product_status']) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'imagefile_id')->textInput() ?>
    </div>
</div>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

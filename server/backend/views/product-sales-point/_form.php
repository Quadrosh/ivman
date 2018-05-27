<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductSalesPoint */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-sales-point-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'product_id')->textInput(['readOnly'=> true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'sort_order')->textInput() ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>



<!--    --><?//= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
<!---->
<!--    --><?//= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

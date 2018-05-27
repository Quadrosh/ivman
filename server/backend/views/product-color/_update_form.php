<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductColor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-color-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-2">
            <?= $form->field($model, 'product_id')->textInput(['readonly'=>true]) ?>

        </div>
        <div class="col-sm-5">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-5">
            <?= $form->field($model, 'status')->dropDownList(\yii\helpers\ArrayHelper::map(
                \common\models\ProductStatus::find()->all(), 'name','description'),['id'=>'product_status']) ?>
        </div>


        <div class="form-group col-sm-12">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>



    <?php ActiveForm::end(); ?>

</div>

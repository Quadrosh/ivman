<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-sm-3">
        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'vendor_code')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'material')->textarea(['rows' => 1]) ?>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'details')->textarea(['rows' => 1]) ?>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'attention')->textarea(['rows' => 1]) ?>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'made_in')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-12">
<!--        --><?//= $form->field($model, 'description')->textarea(['rows' => 1]) ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'case_qnt')->textInput() ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'status')->dropDownList(\yii\helpers\ArrayHelper::map(
            \common\models\ProductStatus::find()->all(), 'name','description'),['id'=>'product_status']) ?>
    </div>
</div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>











    <?php ActiveForm::end(); ?>

</div>

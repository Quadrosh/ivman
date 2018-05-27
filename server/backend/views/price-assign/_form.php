<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PriceAssign */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="price-assign-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-sm-2">
        <?= $form->field($model, 'product_id')->textInput(['readonly'=>true]) ?>
    </div>
    <div class="col-sm-2">
        <?= $form->field($model, 'color_id')
            ->dropDownList(\yii\helpers\ArrayHelper::map(
                \common\models\ProductColor::find()
                    ->where(['product_id'=>$model['product_id']])
                    ->all(), 'id','name'),[
                'id'=>'product_color-id',
                'prompt'=>'',
            ])->label('Цвет') ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'size_id')
            ->dropDownList(\yii\helpers\ArrayHelper::map(
                \common\models\ProductSize::find()
                    ->where(['product_id'=>$model['product_id']])
                    ->all(), 'id','name'),[
                'id'=>'product_size-id',
                'prompt'=>'',
            ])->label('Размер') ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'price_id')
            ->dropDownList(\yii\helpers\ArrayHelper::map(
                \common\models\Price::find()
                    ->all(), 'id','name'),[
                'id'=>'product_size-id',
            ])->label('Тип цены')?>
    </div>
    <div class="col-sm-2">
        <?= $form->field($model, 'value')->textInput() ?>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>
    </div>
</div>






<!--    --><?//= $form->field($model, 'updated_at')->textInput() ?>

<!--    --><?//= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Detail Icons';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-detail-icon-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="product-detail-icon-form">

        <?php
        $form = ActiveForm::begin([
                'method' => 'post',
                'action' => ['/product-detail-icon/create'],
                'options' => ['enctype' => 'multipart/form-data'],
            ]
        );
        $model = new \common\models\ProductDetailIcon();
        ?>

        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'name')->textarea(['rows'=>1,'maxlength' => true]) ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'type')->dropDownList(\yii\helpers\ArrayHelper::map(
                    \common\models\ProductDetailIconType::find()->all(), 'name','name'),['id'=>'product_status']) ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'imagefile_id')->textInput() ?>
            </div>

            <div class="col-sm-3 text-center">
                <?= Html::submitButton('Create', ['class' =>  'btn btn-success mt25' ]) ?>

            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
<!--    <p>-->
<!--        --><?//= Html::a('Create Product Detail Icon', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name:ntext',
            'type',
//            'imagefile_id',
            [
                'label'=>'image',
                'attribute'=>'imagefile_id',
                'value' => function($data)
                {
                    if ($data['imagefile_id']) {

                        $imagefile = \common\models\Imagefiles::find()
                            ->where(['id'=>$data['imagefile_id']])
                            ->one();
                        return cl_image_tag($imagefile['cloudname'], [
                            "alt" => '',
                            "width" => 50,
                            "height" => 50,
                            "crop" => "fill",
//                    "crop" => "thumb",
                        ]);
                    } else {
                        return 'Нет иконки!';
                    }
                },
                'format'=> 'html',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>


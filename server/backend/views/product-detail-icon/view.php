<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\ProductDetailIcon */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Product Detail Icons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-detail-icon-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name:ntext',
            'type',
            'imagefile_id',
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
        ],
    ]) ?>

</div>

<div class="row">
    <div class="col-sm-4 text-left">
        <h5>Загрузка иконки</h5>
        <?php
        $uploadmodel = new \common\models\UploadForm();
        ?>
        <?php $form = ActiveForm::begin([
            'method' => 'post',
            'action' => ['/product-detail-icon/add-icon-image?id='.$model->id],
            'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>

        <div class="col-sm-12  text-center">
            <?= $form->field($uploadmodel, 'imageFile')->fileInput()->label(false) ?>
            <?= Html::submitButton('Загрузить иконку', ['class' => 'btn btn-primary btn-xs']) ?>

        </div>
        <?php ActiveForm::end();
        ?>
    </div>
</div>
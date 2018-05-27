<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProductColor */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Product Colors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-color-view">

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
            'product_id',
            [
                'attribute'=>'product_id',
                'value' => function($data)
                {
                    $product = $data->product;
                    return $product['code'].' - '.$product['name'];
                },
                'format'=> 'html',
            ],
            'name',
            'icon_img_id',
            [
                'attribute'=>'icon_img_id',
                'value' => function($data)
                {
                    if ($data['icon_img_id']) {

                        $imagefile = \common\models\Imagefiles::find()
                            ->where(['id'=>$data['icon_img_id']])
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
            'main_img_id',
            [
                'attribute'=>'main_img_id',
                'value' => function($data)
                {
                    if ($data['main_img_id']) {

                        $imagefile = \common\models\Imagefiles::find()
                            ->where(['id'=>$data['main_img_id']])
                            ->one();
                        return cl_image_tag($imagefile['cloudname'], [
                            "alt" => '',
                            "width" => 50,
                            "height" => 100,
                            "crop" => "fit",
//                    "crop" => "thumb",
                        ]);
                    } else {
                        return 'Нет основного фото!';
                    }
                },
                'format'=> 'html',
            ],
            'status',
        ],
    ]) ?>

</div>

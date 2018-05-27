<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Colors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-color-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product Color', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

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
            [
                'attribute'=>'main_img_id',
                'value' => function($data)
                {
                    if ($data['main_img_id']) {
                        $colorImage = $data->mainImage;

                        $imagefile = $colorImage->imagefile;
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

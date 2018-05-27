<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'code',
            [
                'attribute'=> 'default_image',
                'value' => function($data){
                        return cl_image_tag($data['default_image'], [
                            "alt" => $data['name'] ,
//                            "width" => 70,
                            "height" => 70,
//        "gravity" => "south_east",
//                            "gravity" => "face",
//        "crop" => "thumb",
                            "crop" => "fill"
                        ]);


                },
                'format'=> 'html',
            ],
            'name',
            [
                'label'=>'fotos',
                'attribute'=> 'default_image',
                'value' => function($data){
                    $r = '';
                    foreach ($data->colors as $index=>$color) {
                        $iter=0;
                        if ($index==0) {
                            foreach ($color->images as $imIndex=>$image) {
                                $iter++;
                            }
                            $r=$r.$iter;
                        } else {
                            if ($index < count($data->colors)-1) {
                                foreach ($color->images as $imIndex=>$image) {
                                    $iter++;
                                }
                                $r=$r.','.$iter;
                            } else {
                                foreach ($color->images as $imIndex=>$image) {
                                    $iter++;
                                }
                                $r=$r.','.$iter;
                            }
                        }
                    }
                    return $r;

                },
                'format'=> 'html',
            ],
            'material',

//            'description:ntext',
            [
                'label'=>'sales points',
                'attribute'=> 'default_image',
                'value' => function($data){
                    return count($data->salesPoints);
                },
                'format'=> 'html',
            ],
            [
                'attribute'=>'category',
                'value' => function($data)
                {
                    $catArrDirty = explode('/',$data['category']);
                    $newValue = '';
                    foreach ($catArrDirty as $cat) {
                        $id = str_replace('-','',$cat);
                        if ($id == null) {
                            break;
                        }
                        $catName = \common\models\Category::find()->where(['id'=>$id])->one()['name'];
                        $newValue = $newValue == ''? $catName : $newValue.', '.$catName;
                    }
                    return $newValue;
                },
                'format'=> 'html',
            ],
            //'case_qnt',
            //'status',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

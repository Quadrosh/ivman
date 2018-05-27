<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

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
            'user_id',
            [
                'attribute'=>'user_id',
                'value' => function($model)
                {
                    $user =  $model->user;
                    return $user['first_name'].' '.$user['last_name'];
                },
                'format'=> 'html',
                'label'=>'Имя Фамилия'
            ],
            'address_id',
            'wrap',
            'shipping_type',
            'user_comment:ntext',
            'admin_comment:ntext',
            'status',
//            'created_at',
            [
                'attribute'=>'created_at',
                'value' => function($data)
                {
                    return \Yii::$app->formatter->asDatetime($data['created_at'], 'dd/MM/yy HH:mm:ss');
                },
                'format'=> 'html',
            ],
//            'updated_at',
            [
                'attribute'=>'updated_at',
                'value' => function($data)
                {
                    return \Yii::$app->formatter->asDatetime($data['updated_at'], 'dd/MM/yy HH:mm:ss');
                },
                'format'=> 'html',
            ],
        ],
    ]) ?>



    <!--    Категории -->
    <div class="row mt20 bt pt20">

        <div class="col-sm-12 text-center">
            <h3>позиции заказа</h3>
        </div>

        <?php

        $items = $model->items;

        $query = \common\models\OrderItem::find()->where(['order_id'=>$model['id']]);
        $itemsDataProvider = new \yii\data\ActiveDataProvider([
            'query'=>$query,
        ]);
        ?>

        <div class="col-sm-12">
            <?php
            echo yii\grid\GridView::widget([
                'dataProvider' => $itemsDataProvider,
                'emptyText' => '',
                'columns'=>[
                    'id',
                    'product_id',
                    [
                        'attribute'=>'product_id',
                        'value' => function($data)
                        {

                            $product = \common\models\Product::find()->where(['id'=>$data['product_id']])->one();
                            return $product['code'];

                        },
                        'format'=> 'html',
                        'label'=>'Артикул',
                    ],
                    [
                        'attribute'=>'product_name',
                        'value' => function($data)
                        {
                            if ($data['product_name']) {
                                return $data['product_name'];

                            } else {
                                $product = \common\models\Product::find()->where(['id'=>$data['product_id']])->one();
                                return $product['name'];
                            }
                        },
                        'format'=> 'html',
                    ],
//                    'product_size_id',
                    [
                        'attribute'=>'product_size_id',
                        'value' => function($data)
                        {
                            $size = \common\models\ProductSize::find()->where(['id'=>$data['product_size_id']])->one();
                            return $size['name'];
                        },
                        'format'=> 'html',
                        'label'=>'Размер',
                    ],
//                    'product_color_id',
                    [
                        'attribute'=>'product_color_id',
                        'value' => function($data)
                        {
                            $color = \common\models\ProductColor::find()->where(['id'=>$data['product_color_id']])->one();
                            return $color['name'];
                        },
                        'format'=> 'html',
                        'label'=>'Цвет',
                    ],
                    'qnt',
                    'price',
                    'price_type',
                    'sum_item',

                    [
                        'class' => \yii\grid\ActionColumn::class,
                        'buttons' => [
                            'delete'=>function($url,$item) use ($model){
                                $newUrl = Yii::$app->getUrlManager()->createUrl(['/product/delete-category',
                                    'categoryId'=>$item['id'],
                                    'productId'=>$model['id']
                                ]);
                                return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>', $newUrl,
                                    ['title' => Yii::t('yii', 'Удалить'),
                                        'data-confirm' => 'точно удалить?',
                                        'data-pjax' => '0',
                                        'data-method'=>'post']);
                            },
                            'view'=>function($url,$model){
                                return false;
                            },
                            'update'=>function($url,$model){
                                return false;
                            },

                        ]
                    ],
                ],
            ]);
            ?>

        </div>
    </div>
    <!--   /Категория -->


</div>

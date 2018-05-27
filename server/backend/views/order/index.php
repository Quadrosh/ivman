<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

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

//            'wrap',
//            'shipping_type',
            [
                'attribute'=>'shipping_type',
                'value' => function($model)
                {
                    return count($model->items);
                },
                'format'=> 'html',
                'label'=>'items'
            ],
            // 'user_comment:ntext',
            // 'admin_comment:ntext',
            // 'status',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

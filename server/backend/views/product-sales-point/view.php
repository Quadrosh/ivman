<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProductSalesPoint */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Product Sales Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-sales-point-view">

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
            'sort_order',
            'name',
            'description:ntext',
            'status',
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductSize */

$this->title = 'Update Product Size: '.$model['name'];
$this->params['breadcrumbs'][] = ['label' => 'Product Sizes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-size-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <h3><?= $model->product['code'].' '.$model->product['name'] ?></h3>

    <?= $this->render('_update_form', [
        'model' => $model,
    ]) ?>

</div>

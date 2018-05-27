<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductColorImage */

$this->title = 'Update Product Color Image: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Product Color Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-color-image-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductSalesPoint */

$this->title = 'Create Product Sales Point';
$this->params['breadcrumbs'][] = ['label' => 'Product Sales Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-sales-point-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

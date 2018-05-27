<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PriceAssign */

$this->title = 'Update Price Assign: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Price Assigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="price-assign-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

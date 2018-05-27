<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OrderAddress */

$this->title = 'Create Order Address';
$this->params['breadcrumbs'][] = ['label' => 'Order Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-address-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

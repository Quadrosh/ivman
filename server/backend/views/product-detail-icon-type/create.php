<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductDetailIconType */

$this->title = 'Create Product Detail Icon Type';
$this->params['breadcrumbs'][] = ['label' => 'Product Detail Icon Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-detail-icon-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

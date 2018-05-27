<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductDetailIcon */

$this->title = 'Create Product Detail Icon';
$this->params['breadcrumbs'][] = ['label' => 'Product Detail Icons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-detail-icon-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

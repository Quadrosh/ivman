<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductColorImage */

$this->title = 'Create Product Color Image';
$this->params['breadcrumbs'][] = ['label' => 'Product Color Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-color-image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

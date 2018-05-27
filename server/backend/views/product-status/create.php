<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductStatus */

$this->title = 'Create Product Status';
$this->params['breadcrumbs'][] = ['label' => 'Product Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PriceAssign */

$this->title = 'Create Price Assign';
$this->params['breadcrumbs'][] = ['label' => 'Price Assigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-assign-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Imagefiles */

$this->title = 'Create Imagefiles';
$this->params['breadcrumbs'][] = ['label' => 'Imagefiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="imagefiles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

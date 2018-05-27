<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' =>  Html::img('@web/img/ivmanufaktura_logo.svg',[
            'alt'=>'Ивановская мануфактура',
            'class'=> 'adminLogo'
        ]),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        [
            'label' => 'libs',
            'items' => [
                ['label' => 'Pages', 'url' => ['/pages']],
                ['label' => 'Price', 'url' => ['/price']],
                ['label' => 'Price Assign', 'url' => ['/price-assign']],
                ['label' => 'Category', 'url' => ['/category']],
                ['label' => 'Imagefiles', 'url' => ['/imagefiles']],
                ['label' => 'Product Status', 'url' => ['/product-status']],
                ['label' => 'Product Detail Icon Types', 'url' => ['/product-detail-icon-type']],
            ],
        ],
        [
            'label' => 'Покупатели',
            'items' => [
                ['label' => 'Список покупателей', 'url' => ['/user']],
            ],
        ],
        [
            'label' => 'Order',
            'items' => [
                ['label' => 'Order', 'url' => ['/order']],
                ['label' => 'Order Item', 'url' => ['/order-item']],
                ['label' => 'Order Address', 'url' => ['/order-address']],
            ],
        ],
        [
            'label' => 'Product',
            'items' => [
                ['label' => 'Product', 'url' => ['/product']],
                ['label' => 'Product Color', 'url' => ['/product-color']],
                ['label' => 'Product Color Image', 'url' => ['/product-color-image']],
                ['label' => 'Product Size', 'url' => ['/product-size']],
                ['label' => 'Product Sales Point', 'url' => ['/product-sales-point']],
                ['label' => 'Product Detail Icon', 'url' => ['/product-detail-icon']],

            ],
        ],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->email . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Ивановская мануфактура <?= date('Y') ?></p>

        <p class="pull-right">Powered by <a href="http://www.deepclouds.ru/" rel="external">Deepclouds</a></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

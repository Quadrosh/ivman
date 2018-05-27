<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \yii\widgets\ActiveForm;
use \common\models\Category;
use \common\models\ProductDetailIcon;


/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->code;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">
    <?= cl_image_tag($model['default_image'], [
        "alt" => '',
        "width" => 100,
        "height" => 200,
        "crop" => "fill",
//                    "crop" => "thumb",
//                    "crop" => "fill",
    ]); ?>

    <h3><?= Html::encode($model->code.' '.$model->name) ?></h3>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'vendor_code',
            'name',
            'material:ntext',
            'details:ntext',
            'attention:ntext',
            'made_in',
            'detail_icons',
//            'description:ntext',
//            'category',
            [
                'attribute'=>'category',
                'value' => function($data)
                {
                    $catArrDirty = explode('/',$data['category']);
                    $newValue = '';
                    foreach ($catArrDirty as $cat) {
                        $id = str_replace('-','',$cat);
                        if ($id == null) {
                            break;
                        }
                        $catName = Category::find()->where(['id'=>$id])->one()['name'];
                        $newValue = $newValue == ''? $catName : $newValue.', '.$catName;
                    }
                    return $newValue;
                },
                'format'=> 'html',
            ],
            'case_qnt',
            'default_color_id',
            'default_image',
            'status',
//            'created_at',
            [
                'attribute'=>'created_at',
                'value' => function($data)
                {
                    return \Yii::$app->formatter->asDatetime($data['created_at'], 'dd/MM/yy HH:mm:ss');
                },
                'format'=> 'html',
            ],
//            'updated_at',
            [
                'attribute'=>'updated_at',
                'value' => function($data)
                {
                    return \Yii::$app->formatter->asDatetime($data['updated_at'], 'dd/MM/yy HH:mm:ss');
                },
                'format'=> 'html',
            ],
        ],
    ]) ?>

</div>

<!--    Место производства -->
<div class="row mt20 bt pt20">
    <div class="col-sm-12 text-center">
        <h3>Место производства</h3>
        <h6 ><span class="grey">Текущее значение :</span><br><?= $model['made_in'] ? $model['made_in']:'<span class="label label-warning">не заполнено</span>'; ?></h6>
    </div>
    <div class="col-sm-6">
        <?php $form = ActiveForm::begin([
            'method' => 'post',
            'action' => ['/product/update?id='.$model['id']],
            'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>
        <?= $form->field($model, 'made_in')
            ->textarea(['rows'=>1])
            ->label(false) ?>
    </div>
    <div class="col-xs-3 text-right">
        <?= Html::submitButton('назначить <i class="fa fa-share" aria-hidden="true"></i>', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
<!--   /Место производства  -->

<!--    Материал -->
<div class="row mt20 bt pt20">
    <div class="col-sm-12 text-center">
        <h3>Материал</h3>
        <h6 ><span class="grey">Текущее значение :</span><br><?= $model['material'] ? $model['material']:'<span class="label label-warning">не заполнено</span>'; ?></h6>
    </div>
<div class="col-sm-6">
    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => ['/product/update?id='.$model['id']],
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>
    <?= $form->field($model, 'material')
        ->textarea(['rows'=>1])
        ->label(false) ?>
</div>


<div class="col-xs-3 text-right">
    <?= Html::submitButton('назначить <i class="fa fa-share" aria-hidden="true"></i>', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end() ?>


</div>
<!--   /Материал -->

<!--    Подробнее -->
<div class="row mt20 bt pt20">
    <div class="col-sm-12 text-center">
        <h3>Подробнее</h3>
        <h6 ><span class="grey">Текущее значение :</span><br><?= $model['details'] ? $model['details']:'<span class="label label-warning">не заполнено</span>'; ?></h6>
    </div>
    <div class="col-sm-6">
        <?php $form = ActiveForm::begin([
            'method' => 'post',
            'action' => ['/product/update?id='.$model['id']],
            'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>
        <?= $form->field($model, 'details')
            ->textarea(['rows'=>1])
            ->label(false) ?>
    </div>
    <div class="col-xs-3 text-right">
        <?= Html::submitButton('назначить <i class="fa fa-share" aria-hidden="true"></i>', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
<!--   /Подробнее -->

<!--    Внимание -->
<div class="row mt20 bt pt20">
    <div class="col-sm-12 text-center">
        <h3>Внимание</h3>
        <h6 ><span class="grey">Текущее значение :</span><br><?= $model['attention'] ? $model['attention']:'<span class="label label-warning">не заполнено</span>'; ?></h6>
    </div>
    <div class="col-sm-6">
        <?php $form = ActiveForm::begin([
            'method' => 'post',
            'action' => ['/product/update?id='.$model['id']],
            'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>
        <?= $form->field($model, 'attention')
            ->textarea(['rows'=>1])
            ->label(false) ?>
    </div>
    <div class="col-xs-3 text-right">
        <?= Html::submitButton('назначить <i class="fa fa-share" aria-hidden="true"></i>', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
<!--   /Внимание -->

<!--    Конкурентные преимущества -->
<div class="row mt20 bt pt20">
    <!--    --><?php //Pjax::begin([
    //        'id' => 'psyAssignPjax',
    //        'timeout' => 2000,
    //        'enablePushState' => false
    //    ]); ?>
    <div class="col-sm-12 text-center">
        <h3>Конкурентные преимущества </h3>
        <p>(почему купить именно это)</p>
    </div>

    <?php
    $newSalesPoint = new \common\models\ProductSalesPoint();
    $query = \common\models\ProductSalesPoint::find()->where(['product_id'=>$model['id']]);
    $salesPointDataProvider = new \yii\data\ActiveDataProvider([
        'query'=>$query,
    ]);
    ?>
    <div class=" col-sm-6 text-center">

        <?php $form = ActiveForm::begin([
            'id'=>'salesPointAssign',
            'action' => ['/product-sales-point/create'],
            'options' => ['data-pjax' => true ]
        ]); ?>
        <?= $form->field($newSalesPoint, 'product_id')
            ->hiddenInput(['value'=>$model['id'],'id' => 'product_sales_point-product_id'])
            ->label(false) ?>

        <?= $form->field($newSalesPoint, 'name')
            ->textInput(['max_length' => true,'id' => 'product_sales_point-name'])
            ->label(false) ?>


        <?= Html::submitButton('Создать конкурентное преимущество <i class="fa fa-share" aria-hidden="true"></i>', ['class' => 'btn btn-primary btn-xs']) ?>
        <?php ActiveForm::end() ?>
    </div>
    <div class="col-sm-6">
        <?php
        echo yii\grid\GridView::widget([
            'dataProvider' => $salesPointDataProvider,
            'emptyText' => '',
            'columns'=>[
                        'sort_order',
                        'name',
                [
                    'class' => \yii\grid\ActionColumn::class,
                    'buttons' => [
                        'delete'=>function($url,$model){
                            $newUrl = Yii::$app->getUrlManager()->createUrl(['/product-sales-point/delete','id'=>$model['id']]);
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>', $newUrl,
                                ['title' => Yii::t('yii', 'Удалить'),
                                    'data-confirm' => 'точно удалить?',
                                    'data-pjax' => '0',
                                    'data-method'=>'post']);
                        },
                        'view'=>function($url,$model){
                            return false;
                        },
                        'update'=>function($url,$model){
                            $newUrl = Yii::$app->getUrlManager()->createUrl(['/product-sales-point/update','id'=>$model['id']]);
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $newUrl,
                                ['title' => Yii::t('yii', 'Изменить'), 'data-pjax' => '0','data-method'=>'post']);
                        },

                    ]
                ],
            ],
        ]);
        ?>

    </div>
<!--    --><?php //\yii\widgets\Pjax::end(); ?>
</div>
<!--   /Конкурентные преимущества -->

<!--    Категории -->
<div class="row mt20 bt pt20">

    <div class="col-sm-12 text-center">
        <h3>Категория</h3>
    </div>

    <?php
    $cat2assign = new Category();
    $catArrDirty = explode('/',$model['category']);
    $catArr = [];
    $catIter = 0;
    foreach ($catArrDirty as $cat) {
        $id = str_replace('-','',$cat);
        if ($id == null) {
            break;
        }
        $catArr[$catIter]['id'] = $id;
        $catArr[$catIter]['name']= Category::find()->where(['id'=>$id])->one()['name'];
        $catIter++;
    }
    $categoryDataProvider = new \yii\data\ArrayDataProvider([
        'allModels'=>$catArr,
    ]);
    ?>
    <div class=" col-sm-6 text-center">

        <?php $form = ActiveForm::begin([
            'id'=>'cat_assign',
            'action' => ['/product/add-category?id='.$model['id']],
            'options' => ['data-pjax' => true ]
        ]); ?>
        <?= $form->field($cat2assign, 'id')
            ->dropDownList(\yii\helpers\ArrayHelper::map(
                Category::find()->all(), 'id','name'),['id'=>'cat_assign-id'])
            ->label(false) ?>


        <?= Html::submitButton('Назначить категорию <i class="fa fa-share" aria-hidden="true"></i>', ['class' => 'btn btn-primary btn-xs']) ?>
        <?php ActiveForm::end() ?>
    </div>
    <div class="col-sm-6">
        <?php
        echo yii\grid\GridView::widget([
            'dataProvider' => $categoryDataProvider,
            'emptyText' => '',
            'columns'=>[
                'id',
                'name',
                [
                    'class' => \yii\grid\ActionColumn::class,
                    'buttons' => [
                        'delete'=>function($url,$item) use ($model){
                            $newUrl = Yii::$app->getUrlManager()->createUrl(['/product/delete-category',
                                'categoryId'=>$item['id'],
                                'productId'=>$model['id']
                            ]);
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>', $newUrl,
                                ['title' => Yii::t('yii', 'Удалить'),
                                    'data-confirm' => 'точно удалить?',
                                    'data-pjax' => '0',
                                    'data-method'=>'post']);
                        },
                        'view'=>function($url,$model){
                            return false;
                        },
                        'update'=>function($url,$model){
                            return false;
                        },

                    ]
                ],
            ],
        ]);
        ?>

    </div>
</div>
<!--   /Категория -->

<!--    detail icons -->
<div class="row mt20 bt pt20">

    <div class="col-sm-12 text-center">
        <h3>Инфо Иконки</h3>
    </div>

    <?php
    $ico2assign = new ProductDetailIcon();
    $icoArrDirty = explode('/',$model['detail_icons']);
    $icoArr = [];
    $icoIter = 0;
    foreach ($icoArrDirty as $cat) {
        $id = str_replace('-','',$cat);
        if ($id == null) {
            break;
        }
        $icoArr[$icoIter]['id'] = $id;
        $icoArr[$icoIter]['name']= ProductDetailIcon::find()->where(['id'=>$id])->one()['name'];
        $icoIter++;
    }
    $categoryDataProvider = new \yii\data\ArrayDataProvider([
        'allModels'=>$icoArr,
    ]);
    ?>
    <div class=" col-sm-6 text-center">

        <?php $form = ActiveForm::begin([
            'id'=>'cat_assign',
            'action' => ['/product/add-detail-icon?id='.$model['id']],
            'options' => ['data-pjax' => true ]
        ]); ?>
        <?= $form->field($ico2assign, 'id')
            ->dropDownList(\yii\helpers\ArrayHelper::map(
                ProductDetailIcon::find()->all(), 'id','name'),['id'=>'detail_icon_assign-id'])
            ->label(false) ?>


        <?= Html::submitButton('Назначить иконку <i class="fa fa-share" aria-hidden="true"></i>', ['class' => 'btn btn-primary btn-xs']) ?>
        <?php ActiveForm::end() ?>
    </div>
    <div class="col-sm-6">
        <?php
        echo yii\grid\GridView::widget([
            'dataProvider' => $categoryDataProvider,
            'emptyText' => '',
            'columns'=>[
                'id',
//                'name',
                [
                    'attribute'=>'name',
                    'value' => function($data)
                    {
                       return nl2br($data['name']);
                    },
                    'format'=> 'html',
                ],
                [
                    'label'=>'icon',
                    'attribute'=>'id',
                    'value' => function($data)
                    {
                        $icon = ProductDetailIcon::find()->where(['id'=>$data['id']])->one();

                        if ($icon->imagefile) {

                            $imagefile = $icon->imagefile;
                            return cl_image_tag($imagefile['cloudname'], [
                                "alt" => '',
                                "width" => 50,
                                "height" => 50,
                                "crop" => "fit",
                            ]);
                        } else {
                            return 'Нет иконки!';
                        }
                    },
                    'format'=> 'html',
                ],
                [
                    'class' => \yii\grid\ActionColumn::class,
                    'buttons' => [
                        'delete'=>function($url,$item) use ($model){
                            $newUrl = Yii::$app->getUrlManager()->createUrl(['/product/delete-detail-icon',
                                'iconId'=>$item['id'],
                                'productId'=>$model['id']
                            ]);
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>', $newUrl,
                                ['title' => Yii::t('yii', 'Удалить'),
                                    'data-confirm' => 'точно удалить?',
                                    'data-pjax' => '0',
                                    'data-method'=>'post']);
                        },
                        'view'=>function($url,$model){
                            return false;
                        },
                        'update'=>function($url,$model){
                            return false;
                        },

                    ]
                ],
            ],
        ]);
        ?>

    </div>
</div>
<!--   /detail icons -->

<!--    Цвета -->
<div class="row mt20 bt pt20">

    <div class="col-sm-12 text-center">
        <h3>Цвета </h3>
        <h5>Основной цвет: <?= \common\models\ProductColor::find()->where(['id'=>$model['default_color_id']])->one()['name'] ?> </h5>
    </div>
    <div class=" col-sm-6 col-sm-offset-3">

        <?php
        $form = ActiveForm::begin([
            'id'=>'colorAssign',
            'action' => ['/product/update?id='.$model['id']],
            'options' => ['data-pjax' => true ]
        ]); ?>

        <div class="col-sm-6">
            <?= $form->field($model, 'default_color_id')
                ->dropDownList(\yii\helpers\ArrayHelper::map(
                    \common\models\ProductColor::find()
                        ->where(['product_id'=>$model['id']])->all(), 'id','name'),['id'=>'product_default_color-item_id'])
                ->label(false) ?>
        </div>
        <div class="col-sm-6 text-center">
            <?= Html::submitButton('Назначить основным цветом <i class="fa fa-share" aria-hidden="true"></i>', ['class' => 'btn btn-primary']) ?>
        </div>




        <?php ActiveForm::end() ?>
    </div>


<!-- создание цвета -->
    <?php
    $newColor = new \common\models\ProductColor();
    $query = \common\models\ProductColor::find()->where(['product_id'=>$model['id']]);
    $colorDataProvider = new \yii\data\ActiveDataProvider([
        'query'=>$query,
    ]);
    ?>
    <div class=" col-sm-6 text-center">

        <?php $form = ActiveForm::begin([
            'id'=>'colorAssign',
            'action' => ['/product-color/create'],
            'options' => ['data-pjax' => true ]
        ]); ?>
        <?= $form->field($newColor, 'product_id')
            ->hiddenInput(['value'=>$model['id'],'id' => 'product_color-product_id'])
            ->label(false) ?>
        <?= $form->field($newColor, 'status')
            ->hiddenInput(['value'=>'active','id' => 'product_color-status'])
            ->label(false) ?>

        <?= $form->field($newColor, 'name')
            ->textInput(['max_length' => true,'id' => 'product_color-name'])
            ->label(false) ?>


        <?= Html::submitButton('Создать цвет <i class="fa fa-share" aria-hidden="true"></i>', ['class' => 'btn btn-primary btn-xs']) ?>
        <?php ActiveForm::end() ?>
    </div>
    <div class="col-sm-6">
        <?php
        echo yii\grid\GridView::widget([
            'dataProvider' => $colorDataProvider,
            'emptyText' => '',
            'columns'=>[
//                'id',
                'name',
//                'icon_img_id',
                [
                    'attribute'=>'icon_img_id',
                    'value' => function($data)
                    {
                        if ($data['icon_img_id']) {

                            $imagefile = \common\models\Imagefiles::find()
                                ->where(['id'=>$data['icon_img_id']])
                                ->one();
                            return cl_image_tag($imagefile['cloudname'], [
                                "alt" => '',
                                "width" => 50,
                                "height" => 50,
                                "crop" => "fill",
//                    "crop" => "thumb",
                            ]);
                        } else {
                           return 'Нет иконки!';
                        }
                    },
                    'format'=> 'html',
                ],
                'status',

                [
                    'class' => \yii\grid\ActionColumn::class,
                    'buttons' => [
                        'delete'=>function($url,$model){
                            $newUrl = Yii::$app->getUrlManager()->createUrl(['/product-color/delete','id'=>$model['id']]);
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>', $newUrl,
                                ['title' => Yii::t('yii', 'Удалить'),
                                    'data-confirm' => 'Точно удалить? Это действие удалит все фото этого цвета и иконку.',
                                    'data-pjax' => '0',
                                    'data-method'=>'post']);
                        },
                        'view'=>function($url,$model){
                            return false;
                        },
                        'update'=>function($url,$model){
                            $newUrl = Yii::$app->getUrlManager()->createUrl(['/product-color/update','id'=>$model['id']]);
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $newUrl,
                                ['title' => Yii::t('yii', 'Изменить'), 'data-pjax' => '0','data-method'=>'post']);
                        },

                    ]
                ],
            ],
        ]);
        ?>

        <div class="col-sm-12 text-center">
            <h5>Загрузка иконки</h5>
            <?php
            $uploadmodel = new \common\models\UploadForm();
            ?>
            <?php $form = ActiveForm::begin([
                'method' => 'post',
                'action' => ['/product-color-image/add-color-icon'],
                'options' => ['enctype' => 'multipart/form-data'],
            ]); ?>

            <div class="col-sm-6">
                <?= $form->field($uploadmodel, 'toModelProperty')->dropDownList(\yii\helpers\ArrayHelper::map(
                    \common\models\ProductColor::find()
                        ->where(['product_id'=>$model['id']])
                        ->all(), 'id','name'),['id'=>'product_icon_color-chose_color'])->label(false) ?>
            </div>

            <div class="col-sm-6">
                <?= $form->field($uploadmodel, 'imageFile')->fileInput()->label(false) ?>
            </div>
            <div class="col-sm-12">
                <?= Html::submitButton('Загрузить иконку', ['class' => 'btn btn-primary btn-xs']) ?>
            </div>
            <?php ActiveForm::end();
            ?>
        </div>

    </div>

<!--    Фото -->
    <div class="col-sm-12 text-center">
        <h3> Фото </h3>
        <?php
        $colors = \common\models\ProductColor::find()->where(['product_id'=>$model['id']])->all();
        $uploadmodel = new \common\models\UploadForm();
        ?>
        <?php foreach ($colors as $color) : ?>
            <div class="row mt100">
                <div class="col-sm-6 text-right colorHead">
                        <?= cl_image_tag($color->icon['cloudname'], [
                            "alt" => '',
                            "width" => 50,
                            "height" => 50,
                            "crop" => "fill",
//                    "crop" => "thumb",
                        ]); ?>
                        <span><?= $color['name'] ?> <?php
                            if ($model['default_color_id']==$color['id']) {
                                echo '(основной)';
                            }?></span>

                </div>

                <div class="col-sm-6 text-left">
                    <?php $form = ActiveForm::begin([
                        'method' => 'post',
                        'action' => ['/product-color-image/add-color-image?colorId='.$color['id']],
                        'options' => ['enctype' => 'multipart/form-data'],
                    ]); ?>

                    <?= $form->field($uploadmodel, 'imageFile')->fileInput()->label(false) ?>

                    <?= Html::submitButton('Загрузить фото', ['class' => 'btn btn-primary btn-xs']) ?>
                    <?php ActiveForm::end();
                    $images = $color->images;
                    ?>
                </div>

            </div>
            <div class="row mt100">

                <?php if (isset($images)) : ?>
                    <?php foreach ($images as $image) : ?>
                        <div class="col-xs-3 text-center">
                            <?= cl_image_tag($image->imagefile['cloudname'], [
                                "alt" => '',
                                "width" => 200,
                                "height" => 292,
                                "crop" => "fit",
                            ]); ?>
                            <?php
                            if ($image->imagefile!=null) {
                                echo  Html::a('Удалить','/product-color-image/delete?id='.$image['id'], [
                                    'class' => 'btn btn-danger btn-xs deletePrIm rot90',
                                    'title' => Yii::t('yii', 'Удалить'),
                                    'data-pjax' => '0',
                                    'data-method'=>'post',
                                    'data-confirm'=>'Точно удалить?'
                                ]);
                                if ($image['id']==$color['main_img_id']) {
                                    echo '<h5>Основной</h5>';
                                } else {
                                    echo Html::a('Назначить основным','/product-color-image/set-main?colorId='.$color['id'].'&imageId='.$image['id'], [
                                        'class' => 'btn btn-default btn-xs ',
                                        'title' => Yii::t('yii', 'Назначить основным'),
                                        'data-pjax' => '0',
                                        'data-method'=>'post',
                                    ]);
                                }

                            }
                            ?>


                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!--   / Цвета -->


<!-- размеры  -->
<div class="row mt20 bt pt20" id="createSizeDiv">

    <?php
    $newSize = new \common\models\ProductSize();
    $query = \common\models\ProductSize::find()->where(['product_id'=>$model['id']]);
    $sizeDataProvider = new \yii\data\ActiveDataProvider([
        'query'=>$query,
    ]);
    ?>
    <div class="col-sm-12 text-center" >
        <h3> Размеры </h3>
    </div>
    <div class=" col-sm-6 text-center">

        <?php $form = ActiveForm::begin([
            'id'=>'colorAssign',
            'action' => ['/product-size/create'],
            'options' => ['data-pjax' => true ]
        ]); ?>
        <?= $form->field($newSize, 'product_id')
            ->hiddenInput(['value'=>$model['id'],'id' => 'product_size-product_id'])
            ->label(false) ?>
        <div class="col-sm-8">
            <?= $form->field($newSize, 'name')
                ->textInput(['max_length' => true,'id' => 'product_size-name']) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($newSize, 'case_qnt')
                ->textInput(['max_length' => true,'id' => 'product_size-name']) ?>
        </div>
        <?= $form->field($newSize, 'status')
            ->hiddenInput(['value'=>'active','id' => 'product_size-status'])
            ->label(false) ?>


        <?= Html::submitButton('Создать размер <i class="fa fa-share" aria-hidden="true"></i>', ['class' => 'btn btn-primary btn-xs']) ?>
        <?php ActiveForm::end() ?>
    </div>
    <div class="col-sm-6">
        <?php
        echo yii\grid\GridView::widget([
            'dataProvider' => $sizeDataProvider,
            'emptyText' => '',
            'columns'=>[
//                'id',
                'name',
//                'description',

                'case_qnt',
                'status',

                [
                    'class' => \yii\grid\ActionColumn::class,
                    'buttons' => [
                        'delete'=>function($url,$model){
                            $newUrl = Yii::$app->getUrlManager()->createUrl(['/product-size/delete','id'=>$model['id']]);
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>', $newUrl,
                                ['title' => Yii::t('yii', 'Удалить'),
                                    'data-confirm' => 'Точно удалить?',
                                    'data-pjax' => '0',
                                    'data-method'=>'post']);
                        },
                        'view'=>function($url,$model){
                            return false;
                        },
                        'update'=>function($url,$model){
                            $newUrl = Yii::$app->getUrlManager()->createUrl(['/product-size/update','id'=>$model['id']]);
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $newUrl,
                                ['title' => Yii::t('yii', 'Изменить'), 'data-pjax' => '0','data-method'=>'post']);
                        },

                    ]
                ],
            ],
        ]);
        ?>
    </div>
</div>
<!-- / размеры  -->


<!-- цены  -->
<div class="row mt20 bt pt20">

    <?php
    $newPrice = new \common\models\PriceAssign();
    $query = \common\models\PriceAssign::find()->where(['product_id'=>$model['id']]);
    $priceDataProvider = new \yii\data\ActiveDataProvider([
        'query'=>$query,
    ]);
    ?>
    <div class=" col-sm-12 text-center">

        <h3> Цены </h3>


        <?php $form = ActiveForm::begin([
            'id'=>'colorAssign',
            'action' => ['/price-assign/create'],
            'options' => ['data-pjax' => true ]
        ]); ?>
        <?= $form->field($newPrice, 'product_id')
            ->hiddenInput(['value'=>$model['id'],'id' => 'product_price-product_id'])
            ->label(false) ?>
        <div class="col-sm-3">
            <?= $form->field($newPrice, 'color_id')
                ->dropDownList(\yii\helpers\ArrayHelper::map(
                    \common\models\ProductColor::find()
                        ->where(['product_id'=>$model['id']])
                        ->all(), 'id','name'),[
                    'id'=>'product_color-id',
                    'prompt'=>'',
                ])->label('Цвет') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($newPrice, 'size_id')
                ->dropDownList(\yii\helpers\ArrayHelper::map(
                    \common\models\ProductSize::find()
                        ->where(['product_id'=>$model['id']])
                        ->all(), 'id','name'),[
                    'id'=>'product_size-id',
                    'prompt'=>'',
                ])->label('Размер') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($newPrice, 'price_id')
                ->dropDownList(\yii\helpers\ArrayHelper::map(
                    \common\models\Price::find()
                        ->all(), 'id','name'),[
                    'id'=>'product_size-id',
                ])->label('Тип цены') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($newPrice, 'value')
                ->textInput(['max_length' => true,'id' => 'product_price-value'])->label('руб') ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($newPrice, 'comment')
                ->textInput(['max_length' => true,'id' => 'product_price-comment']) ?>
        </div>


        <?= Html::submitButton('Создать цену <i class="fa fa-share" aria-hidden="true"></i>', ['class' => 'btn btn-primary btn-xs']) ?>
        <?php ActiveForm::end() ?>
    </div>
    <div class="col-sm-12 pt20">
        <?php
        echo yii\grid\GridView::widget([
            'dataProvider' => $priceDataProvider,
            'emptyText' => '',
            'columns'=>[
//                'id',
//                'color_id',
                [
                    'label'=>'Цвет',
                    'attribute'=>'color_id',
                    'value' => function($data)
                    {
                        $color = \common\models\ProductColor::find()->where(['id'=>$data['color_id']])->one();

                        if ($color) {
                            return $color['name'];
                        } else {
                            return '<span class="grey">все</span>';
                        }
                    },
                    'format'=> 'html',
                ],
//                'size_id',
                [
                    'label'=>'Размер',
                    'attribute'=>'size_id',
                    'value' => function($data)
                    {
                        $size = \common\models\ProductSize::find()->where(['id'=>$data['size_id']])->one();

                        if ($size) {
                            return $size['name'];
                        } else {
                            return '<span class="grey">все</span>';
                        }
                    },
                    'format'=> 'html',
                ],
//                'price_id',
                [
                    'label'=>'Тип цены',
                    'attribute'=>'price_id',
                    'value' => function($data)
                    {
                        $priceType = \common\models\Price::find()->where(['id'=>$data['price_id']])->one();

                        if ($priceType) {
                            return $priceType['name'];
                        } else {
                            return 'Нет типа цены!';
                        }
                    },
                    'format'=> 'html',
                ],
                'value',
                'comment',


                [
                    'class' => \yii\grid\ActionColumn::class,
                    'buttons' => [
                        'delete'=>function($url,$model){
                            $newUrl = Yii::$app->getUrlManager()->createUrl(['/price-assign/delete','id'=>$model['id']]);
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-trash"></span>', $newUrl,
                                ['title' => Yii::t('yii', 'Удалить'),
                                    'data-confirm' => 'Точно удалить?',
                                    'data-pjax' => '0',
                                    'data-method'=>'post']);
                        },
                        'view'=>function($url,$model){
                            return false;
                        },
                        'update'=>function($url,$model){
                            $newUrl = Yii::$app->getUrlManager()->createUrl(['/price-assign/update','id'=>$model['id']]);
                            return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $newUrl,
                                ['title' => Yii::t('yii', 'Изменить'), 'data-pjax' => '0','data-method'=>'post']);
                        },

                    ]
                ],
            ],
        ]);
        ?>
    </div>
</div>
<!-- / цены  -->



<!--    цены preview -->
<div class="row mt20 bt pt20">

    <div class="col-sm-12 text-center">
        <h3>цены preview</h3>
    </div>

    <?php

    $table = $model->priceTable();

    if (!$model->sizes) {
        echo '<a href="#createSizeDiv"><h4 class="text-center">СОЗДАЙ РАЗМЕР, тогда цены заработают</h4></a>';
    }
    ?>

    <?php foreach ($model->priceTable() as $priceForColor) : ?>

    <div class="col-sm-12">
        <?php if (isset($priceForColor['color_name'])) : ?>
        <h5><?= $priceForColor['color_name'] ?></h5>

        <?php

            echo "<table class='table table-striped table-bordered'>";
            echo "<thead><tr>";
            echo "<td>".'' ."</td>";
            foreach ($priceForColor['sizes'] as  $sizeKey) {
                echo "<td>".$sizeKey ."</td>";
            }
            echo "</tr></thead>";

        if (isset($priceForColor['color_prices'])) {
            foreach ($priceForColor['color_prices'] as $priceIndex => $price) {
                echo "<tr>". "<td>".$priceIndex ."</td>";
                foreach ($price as $sizeKey => $sizePrice) {
                    echo "<td>".$sizePrice ."</td>";
                }
                echo "</tr>";
            }
        }

            echo "</table>";
        ?>

        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>
<!--   /цены preview -->
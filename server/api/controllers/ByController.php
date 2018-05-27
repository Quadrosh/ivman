<?php
namespace api\controllers;

use common\models\Category;
use common\models\Product;
use yii\filters\ContentNegotiator;
use yii\filters\RateLimiter;
use yii\rest\ActiveController;
use yii\web\Response;

class ByController extends RestController
{





    public function actionIndex()
    {
        return ['models'=>Product::find()->all()];

    }
    /**
     * По категории
     *
     * @param $id
     *
     * @return mixed
     */
    public function actionCategory($id)
    {
        $category = [];
        $category['products']=Product::find()->where(['like','category','-'.$id.'-'])->all();
        $mCat = Category::find()->where(['id'=>$id])->one();
        $category['category'] = $mCat['name'];
        return $category;

    }


    public function actionOptions(){
        return ['code'=>200];
    }
}



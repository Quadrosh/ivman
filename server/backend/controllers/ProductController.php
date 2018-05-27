<?php

namespace backend\controllers;

use common\models\ProductColor;
use Yii;
use common\models\Product;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        Url::remember();
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        Url::remember();

        $model = $this->findModel($id);

//        echo '<pre>'. print_r($model->priceTable(), true) .'</pre>'; die;


        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Url::previous());
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Url::previous());
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Add detail icon to field of Product model.
     * @param integer $id Product id
     * @return mixed
     */
    public function actionAddDetailIcon($id)
    {
//        var_dump(Yii::$app->request->post()); die;

        $icoId = Yii::$app->request->post('ProductDetailIcon')['id'];
        $model = $this->findModel($id);
        $icoOld = $model['detail_icons'];
        if (strpos($icoOld,'-'.$icoId.'-/') !== false) {
            Yii::$app->session->setFlash('error', 'Эта иконка уже назначена');
            return $this->redirect(Url::previous());
        }
        $model['detail_icons'] = $model['detail_icons'].'-'.$icoId.'-/';
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Иконка назначена');
        } else {
            Yii::$app->session->setFlash('error', 'Не получилось назначить, обратитесь к системному адмиинистратору');
        }
        return $this->redirect(Url::previous());
    }


    /**
     * Delete detail icon from Product model.
     * @param integer $id Product id
     * @return mixed
     */
    public function actionDeleteDetailIcon($iconId,$productId)
    {
        $model = $this->findModel($productId);
        $iconOld = $model['detail_icons'];
        if (strpos($iconOld,'-'.$iconId.'-/') === false) {
            Yii::$app->session->setFlash('error', 'Нет такой иконки');
            return $this->redirect(Url::previous());
        }
        $model['detail_icons'] = str_replace('-'.$iconId.'-/','',$model['detail_icons']);

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Иконка удалена');
        } else {
            Yii::$app->session->setFlash('error', 'Не получилось удалить, обратитесь к системному адмиинистратору');
        }
        return $this->redirect(Url::previous());
    }



    /**
     * Add category to Product model.
     * @param integer $id Product id
     * @return mixed
     */
    public function actionAddCategory($id)
    {
        $catId = Yii::$app->request->post('Category')['id'];
        $model = $this->findModel($id);
        $catOld = $model['category'];
        if (strpos($catOld,'-'.$catId.'-/') !== false) {
            Yii::$app->session->setFlash('error', 'Эта категория уже назначена');
            return $this->redirect(Url::previous());
        }
        $model['category'] = $model['category'].'-'.$catId.'-/';
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Категория назначена');
        } else {
            Yii::$app->session->setFlash('error', 'Не получилось назначить, обратитесь к системному адмиинистратору');
        }
        return $this->redirect(Url::previous());
    }

    /**
     * Delete category from Product model.
     * @param integer $id Product id
     * @return mixed
     */
    public function actionDeleteCategory($categoryId,$productId)
    {
        $model = $this->findModel($productId);
        $catOld = $model['category'];
        if (strpos($catOld,'-'.$categoryId.'-/') === false) {
            Yii::$app->session->setFlash('error', 'Нет такой категории');
            return $this->redirect(Url::previous());
        }
        $model['category'] = str_replace('-'.$categoryId.'-/','',$model['category']);

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Категория удалена');
        } else {
            Yii::$app->session->setFlash('error', 'Не получилось удалить, обратитесь к системному адмиинистратору');
        }
        return $this->redirect(Url::previous());
    }


}

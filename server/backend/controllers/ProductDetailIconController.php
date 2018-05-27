<?php

namespace backend\controllers;

use common\models\Imagefiles;
use common\models\UploadForm;
use Yii;
use common\models\ProductDetailIcon;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductDetailIconController implements the CRUD actions for ProductDetailIcon model.
 */
class ProductDetailIconController extends Controller
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
     * Lists all ProductDetailIcon models.
     * @return mixed
     */
    public function actionIndex()
    {
        Url::remember();
        $dataProvider = new ActiveDataProvider([
            'query' => ProductDetailIcon::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductDetailIcon model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        Url::remember();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductDetailIcon model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductDetailIcon();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Url::previous());
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductDetailIcon model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Url::previous());
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductDetailIcon model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $icon = $this->findModel($id);
        if ($icon->imagefile) {
            $icon->imagefile->delete();
        }
        $icon->delete();
        return $this->redirect(Url::previous());
    }

    /**
     * Finds the ProductDetailIcon model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductDetailIcon the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductDetailIcon::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAddIconImage($id)
    {
        $uploadmodel = new UploadForm();
        $icon = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $uploadmodel->imageFile = UploadedFile::getInstance($uploadmodel, 'imageFile');
            $fileName = $uploadmodel->imageFile->baseName.'.'.$uploadmodel->imageFile->extension;
            if ($uploadmodel->uploadtmp()) {
                $cloud = \Cloudinary\Uploader::upload(Yii::getAlias('@webroot/img/tmp-'. $fileName));
                $imageListItem = new Imagefiles();
                $imageListItem['name'] = $uploadmodel->imageFile->baseName.
                    time().'.'.$uploadmodel->imageFile->extension;
                $imageListItem['cloudname'] = $cloud['public_id'];
                if($imageListItem->save()){
                    unlink(Yii::getAlias('@webroot/img/tmp-' . $fileName));
                    Yii::$app->session->setFlash('success', 'Файл загружен успешно');

                    $icon['imagefile_id']=$imageListItem['id'];
                    if ($icon->save()) {

                        return $this->redirect(Url::previous());
                    } else {
                        Yii::$app->session->setFlash('error', 'ошибка добавления');
                    }

                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка сохранения');
                }
            }
        }

    }
}
